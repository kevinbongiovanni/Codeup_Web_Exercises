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
  try	{
	foreach($_POST as $key => $value) {
	  if($value == '') {
		throw new Exception("Please fill out section '{$key}'.");
	  }	
	} 
	$parks[] = $_POST;
	$query = "INSERT INTO parks (name, description, location, date_established, area_in_acres) VALUES (:name, :description, :location, :date_established, :area_in_acres)";
	$stmt = $dbc->prepare($query);
	foreach ($parks as $park) {
	  $stmt->bindValue(':name', $park['name'], PDO::PARAM_STR);
	  $stmt->bindValue(':description', $park['description'], PDO::PARAM_STR);
	  $stmt->bindValue(':location', $park['location'], PDO::PARAM_STR);
	  $stmt->bindValue(':date_established', $park['date_established'], PDO::PARAM_STR);
	  $stmt->bindValue(':area_in_acres', $park['area_in_acres'], PDO::PARAM_INT);
      $stmt->execute();
	}
  } catch (Exception $e) {
	$msg = $e->getMessage() . PHP_EOL;
  }	
}	
?>

<!DOCTYPE html>
<html>
<head>
	<title>National Parks</title>
</head>
<body>

<!--Error Message-->
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
	  <td>Description</td>
	  <td>Location</td>
	  <td>Date Established</td>
	  <td>Acres</td>
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
	    <li class="active"><a href="/test.php?page=<?= $nextPage; ?>">Next</a></li>
	  <? endif; ?>	
	  <?if ($page < $numPages && $page != 1) : ?>
	    <li class="active"><a href="/test.php?page=<?= $prevPage; ?>">Previous</a></li>
        <li class="active"><a href="/test.php?page=<?= $nextPage; ?>">Next</a></li>
	  <? endif; ?>	
	  <? if ($page == $numPages) : ?>
	    <li class="active"><a href="/test.php?page=<?= $prevPage; ?>">Previous</a></li>
	  <?endif; ?>
  	</ul>
  </div>

	<!--Form-->
  <p>
	<form method="POST" action="/test.php">
	<label for="name"></label>
	  <input id="name" name="name" type="text" placeholder="Park Name">
	<label for="location"></label>
	  <input id="location" name="location" type="text" placeholder="Location">
	<label for="date_established"></label>
	  <input id="date_established" name="date_established" type="text" placeholder="Date Est">
	<label for="area_in_acres"></label>
	  <input id="area_in_acres" name="area_in_acres" type="text" placeholder="Area in Acres">
	<label for="description"></label>
	  <input id="description" name="description" type="text" placeholder="Description">
	<button type="submit">Submit</button>
    </form>
  </p>
</body>
</html>