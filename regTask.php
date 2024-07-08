<?php
//create connection
$conn = mysqli_connect("localhost","root","","Project");

//check connection
if (!$conn) {
    die("Connection failed:".mysqli_connect_error());
} else {
    echo"<script>console.log('connected');</script>";
}

$tid = $_POST['tid'];
$name = $_POST['name'];
$sdate = $_POST['sdate'];
$edate = $_POST['edate'];
$nature = $_POST['nature'];

$sql = "INSERT INTO Task
        VALUES ('$tid','$name','$sdate','$edate','$nature')";

if (mysqli_query($conn,$sql)) {
    echo "New record created succesfully";}
else{
    echo "Error"."<br>".mysqli_error($conn);
}
mysqli_close($conn);
?>