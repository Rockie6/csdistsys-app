<?php
include 'config.php';

// get the id from the url
$id = $_GET['id'];

// delete the record
$sql = "DELETE FROM users WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
