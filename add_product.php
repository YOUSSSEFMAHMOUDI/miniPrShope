<?php
include_once('db.php');

// Retrieve the product details from the form
$name = $_POST['name'];
$price = $_POST['price'];
$image = $_POST['image'];

// Prepare and execute the SQL statement
$sql = "INSERT INTO products (name, price, img) VALUES ('$name', '$price', '$image')";
 
if ($conn->query($sql) === TRUE) {
  echo 'Product added successfully <a href="." >Back</a>';
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
