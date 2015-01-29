<?php 


define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'national_parks_db');
define('DB_USER', 'user1');
define('DB_PASS', 'user1');


require_once('db_connect.php');

$parks = [
	[
	'name' => 'Crater Lake', 
	'location' => 'Oregon',    
	'date_established' => '1902-05-22', 
	'area_in_acres' => '183224.05 acres',
	'description' => 'Crater Lake lies in the caldera of an ancient volcano called Mount Mazama that collapsed 7,700 years ago. It is the deepest lake in the United States and is famous for its vivid blue color and water clarity. There are two more recent volcanic islands in the lake, and, with no inlets or outlets, all water comes through precipitation. '
	],
	[
	'name' => 'Denali', 
	'location' => 'Alaska',    
	'date_established' => '1917-02-26', 
	'area_in_acres' => '4740911.72 acres',
	'description' => 'Centered around Mount McKinley, the tallest mountain in North America, Denali is serviced by a single road leading to Wonder Lake. McKinley and other peaks of the Alaska Range are covered with long glaciers and boreal forest. Wildlife includes grizzly bears, Dall sheep, caribou, and gray wolves. '
	],
	[
	'name' => 'Gates of the Artic', 
	'location' => 'Alaska',    
	'date_established' => '1980-11-02', 
	'area_in_acres' => '7523897.74 acres',
	'description' => 'The country's northernmost park protects an expanse of pure wilderness in Alaska's Brooks Range and has no park facilities. The land is home to Alaska natives, who have relied on the land and caribou for 11,000 years. '
	],
	[
	'name' => 'Glacier Bay', 
	'location' => 'Alaska',    
	'date_established' => '1980-11-02', 
	'area_in_acres' => '3224840.31 acres',
	'description' => 'Glacier Bay has numerous tidewater glaciers, mountains, fjords, and a temperate rainforest, and is home to large populations of grizzly bears, mountain goats, whales, seals, and eagles. When discovered in 1794 by George Vancouver, the entire bay was covered in ice, but the glaciers have since receded more than 65 miles (105 km). '
	],
	['name' => 'Grand Canyon', 
	'location' => 'Arizona',    
	'date_established' => '1919-02-26', 
	'area_in_acres' => '1217403.32 acres',
	'description' => 'The Grand Canyon, carved by the mighty Colorado River, is 277 miles (446 km) long, up to 1 mile (1.6 km) deep, and up to 15 miles (24 km) wide. Millions of years of erosion have exposed the colorful layers of the Colorado Plateau in countless mesas and canyon walls, visible from both the north and south rims, or from a number of trails that descend into the canyon itself. '
	],
	['name' => 'Mesa Verde', 
	'location' => 'Colorado',    
	'date_established' => '1906-06-29', 
	'area_in_acres' => '52121.93 acres',
	'description' => 'This area constitutes over 4,000 archaeological sites of the Ancestral Puebloan people, who lived here and elsewhere in the Four Corners region for at least 700 years. Cliff dwellings built in the 12th and 13th centuries include the famous Cliff Palace, which has 150 rooms and 23 kivas, and the Balcony House, with its many passages and tunnels '
	],
	['name' => 'Petrified Forest', 
	'location' => 'Arizona',    
	'date_established' => '1962-12-09', 
	'area_in_acres' => '93532.57 acres',
	'description' => 'This portion of the Chinle Formation has a great concentration of 225-million-year-old petrified wood. The surrounding Painted Desert features eroded cliffs of wonderfully red-hued volcanic rock called bentonite. There are also dinosaur fossils and over 350 Native American sites. '
	],
	['name' => 'Redwood', 
	'location' => 'California',    
	'date_established' => '1968-10-02', 
	'area_in_acres' => '112512.05',
	'description' => 'This park and the co-managed state parks protect almost half of all remaining Coastal Redwoods, the tallest trees on Earth. There are three large river systems in this very seismically active area, and 37 miles (60 km) of protected coastline reveal tide pools and seastacks. The prairie, estuary, coast, river, and forest ecosystems contain a huge variety of animal and plant species. '
	],
	['name' => 'Yellowstone', 
	'location' => 'Wyoming',    
	'date_established' => '1872-03-01', 
	'area_in_acres' => '12219790.71',
	'description' => 'Situated on the Yellowstone Caldera, the park has an expansive network of geothermal areas including vividly colored hot springs, boiling mud pots, and regularly erupting geysers, the best-known being Old Faithful and Grand Prismatic Spring. The yellow-hued Grand Canyon of the Yellowstone River has a number of scenic waterfalls, and four mountain ranges run through the park. More than 60 mammal species, including the gray wolf, grizzly bear, lynx, bison, and elk, make this park one of the best wildlife viewing spots in the country. '
	],
	['name' => 'Yosemite', 
	'location' => 'California',    
	'date_established' => '1890-10-01', 
	'area_in_acres' => '761266.19 acres',
	'description' => 'Among the earliest candidates for National Park status, Yosemite features towering granite cliffs, dramatic waterfalls, and old-growth forests at a unique intersection of geology and hydrology. Half Dome and El Capitan rise from the park's centerpiece, the glacier-carved Yosemite Valley, and from its vertical walls drop Yosemite Falls, North America's tallest waterfall. Three Giant Sequoia groves, along with a pristine wilderness in the heart of the Sierra Nevada, are home to an abundance of rare plant and animal species. '],
];


$stmt = $dbc->prepare('INSERT INTO parks (name, location, date_established, area_in_acres, description) VALUES (:name, :location, :date_established, :area_in_acres, :description)');

foreach ($parks as $value) {
	$stmt->bindValue(':name', $value['name'], PDO::PARAM_STR);

	$stmt->bindValue(':location', $value['location'], PDO::PARAM_STR);

	$stmt->bindValue(':date_established', $value['date_established'], PDO::PARAM_STR);

	$stmt->bindValue(':area_in_acres', $value['area_in_acres'], PDO::PARAM_STR);

	$stmt->bindValue(':description', $value['description'], PDO::PARAM_STR);
	
	$stmt->execute();

echo "Inserted ID: " . $dbc->lastInsertId() . PHP_EOL;

}
	