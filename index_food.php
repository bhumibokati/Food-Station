<?php
//including the database connection file
include_once("connectdbFood.php");
session_start();
//fetching data in descending order (lastest entry first)
$result = $pdo->query("SELECT * FROM foods ORDER BY id DESC");
?>

<html>
<head>	
    <title>Homepage</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
<a class='btn btn-primary' href="food.html">Add New Data</a><br/><br/>
<?php
if(!empty($_SESSION['success'])){
    echo $_SESSION['success'];
   unset($_SESSION['success']);//so you do not have to display it over and over again
  }
?>
<table class="table table-bordered">

	<tr bgcolor='#CCCCCC'>
		<td>Food Name</td>
		<td>Price</td>
        <td>Description</td>
        <td>Update</td>

	</tr>
	<?php 	
	while($row = $result->fetch(PDO::FETCH_ASSOC)) { 		
		echo "<tr>";
		echo "<td>".$row['fname']."</td>";
		echo "<td>".$row['price']."</td>";
        echo "<td>".$row['food_desc']."</td>";	
    
        echo "<td><a  class='btn btn-warning' href=\"edit_food.php?id=$row[id]\">Edit</a> <a class='btn btn-danger' href=\"delete_food.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
	
	}
	?>
	</table>
</body>
</html>