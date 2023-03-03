<?php
//including the database connection file
include("connectdbFood.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$sql = "DELETE FROM foods WHERE id=:id";
$query = $pdo->prepare($sql);
$query->execute(array(':id' => $id));

//redirecting to the display page (index.php in our case)
header("Location:index_food.php");
?>