<?php 

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'national_parks_db');
define('DB_USER', 'user1');
define('DB_PASS', 'user1');

require_once('../db_connect.php');

    // The "forward" link


$limit = 4;

$count = $dbc->query('SELECT count(*) FROM parks')->fetchColumn();
$numPages = ceil($count / $limit);

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$nextPage = $page + 1;

$prevPage = $page - 1;

$offset = ($page - 1) * 4;
    
$stmt = $dbc->prepare('SELECT * FROM parks LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$getParks = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (!empty($_POST)) {
    try   {
        foreach($_POST as $key => $value) {
            if($value == '') {
            throw new Exception("Please fill out section '{$key}'.");
            } 
        } 
        $parks[] = $_POST;
        $query = "INSERT INTO parks (name, location, date_established, area_in_acres, description) VALUES (:name, :location, :date_established, :area_in_acres, :description)";
        $stmt = $dbc->prepare($query);
        
        foreach ($parks as $park) {
            $stmt->bindValue(':name', $park['name'], PDO::PARAM_STR);
            $stmt->bindValue(':location', $park['location'], PDO::PARAM_STR);
            $stmt->bindValue(':date_established', $park['date_established'], PDO::PARAM_STR);
            $stmt->bindValue(':area_in_acres', $park['area_in_acres'], PDO::PARAM_INT);
            $stmt->bindValue(':description', $park['description'], PDO::PARAM_STR);
            $stmt->execute();
        }
    } 

    catch (Exception $e) {
        $msg = $e->getMessage() . PHP_EOL;
    } 
}   


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
 
    <title>National Parks</title>

  </head>
 
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

<? if(isset($msg)) : ?>
    <h3><?= $msg; ?></h3>
<? endif; ?>
    
    <!-- Table -->
  <div class="container">
    <h1>National Parks</h1> 
    <table class="table table-hover table-bordered">
    <tr>
      <td>ID</td>
      <td>Name</td>
      <td>Location</td>
      <td>Date Established</td>
      <td>Acres</td>
      <td>Description</td>

      <tr/>
    <? foreach ($getParks as $rows) : ?>
    <tr>    
      <? foreach ($rows as $park) : ?>
      <td><?= "{$park}" ?></td>
      <? endforeach; ?>
    </tr>       
    <? endforeach; ?>
    </table>

    <!-- Pagination -->
    <ul class="pager">
      <?if($page == 1): ?>
        <li class="active"><a href="/national_parks.php?page=<?= $nextPage; ?>">Next</a></li>
      <? endif; ?>  
      <?if ($page < $numPages && $page != 1) : ?>
        <li class="active"><a href="/national_parks.php?page=<?= $prevPage; ?>">Previous</a></li>
        <li class="active"><a href="/national_parks.php?page=<?= $nextPage; ?>">Next</a></li>
      <? endif; ?>  
      <? if ($page == $numPages) : ?>
        <li class="active"><a href="/national_parks.php?page=<?= $prevPage; ?>">Previous</a></li>
      <?endif; ?>
    </ul>
  </div>


</table>



<form action="/national_parks.php" method="POST" ecntype="multipart/form-data"/>
	<input type="text" name="name" placeholder="Name">
	<input type="text" name="location" placeholder="Location">
	<input type="text" name="date_established" placeholder="Date Established">
	<input type="text" name="area_in_acres" placeholder="Area in Acres">
	<input type="text" name="description" placeholder="Description">
	<input type="submit" value="Save">
</form>
 
</html>



