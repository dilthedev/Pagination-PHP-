<?php 
	
	//creating database connection

	$connection = mysqli_connect('localhost','root','','world');


	//getting the total number of records
	
	$query = "SELECT count(id) AS total_rows FROM country";
	$result_set = mysqli_query($connection,$query);
	$result = mysqli_fetch_assoc($result_set);

	$total_rows = $result['total_rows'];

	$rows_per_page = 10;


	if(isset($_GET['p'])){
		$page_no = $_GET['p'];
	}else {
		$page_no = 1;
	}

	
	$start = ($page_no - 1)*$rows_per_page;

	$query = "SELECT id,country_name , continent,head_of_state FROM country ORDER BY id LIMIT {$start},{$rows_per_page}";
	$result_set = mysqli_query($connection,$query);

	
	$table = "<table>";
	$table .= "<tr><th>ID</th><th>Country Name</th><th>Continent</th><th>Head of State</th></tr>";

	while ($result = mysqli_fetch_assoc($result_set)) {
		$table .="<tr><td>{$result['id']}</td><td>{$result['country_name']}</td><td>{$result['continent']}</td><td>{$result['head_of_state']}</td></tr>";
		
	}

	$table .="</table>";

	//first page 

	$first = "<a href=\"pagination.php?p=1\">First</a>";

	//last page

	$last_page_no = ceil($total_rows/$rows_per_page);	
	$last = "<a href=\"pagination.php?p={$last_page_no}\">Last</a>";

	//$total_pages = $total_rows/$rows_per_page;
	
	//next page
	if($page_no >= $last_page_no){
		$next = "<a>Next</a>";
	}else{
		$next_page_no = $page_no + 1;
		$next = "<a href=\"pagination.php?p={$next_page_no}\">Next</a>";
	}

	//previous page
	if($page_no <= 1){
		$prev = "<a>Back</a>";
	}else{
		$prev_page_no = $page_no - 1;
		$prev = "<a href=\"pagination.php?p={$prev_page_no}\">Back</a>";
	}


	$page_nav =  $first . ' | '.$prev.' | '.' Page No '. $page_no.' of '.$last_page_no.' '.$next.' | ' . $last;

	?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Countries</title>
		<link rel="stylesheet" href="main.css">
	</head>
	<body>
	<div class="container">

		<h2>Countries</h2>	

		<?php echo $table; ?>

		<div class="page_nav">
			
			<?php echo $page_nav; ?>

		</div>


	</div> <!-- container -->



	</body>
	</html>