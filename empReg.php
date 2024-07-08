<?php

//create connection
$conn = mysqli_connect("localhost","root","","Project");

//check connection
if(!$conn){
    die("Connection failed:".mysqli_connect_error());
} else {
    echo"<script>console.log('connected');</script>";
}

    $eid = $_POST['eid'];
    $ename = $_POST['name'];
    $tele = $_POST['tele'];
    $email = $_POST['email'];
    $desig = $_POST['desig'];
    

    $sql = "INSERT INTO
            Employee (Eid,Name,Telephone,Email,Designation)
            VALUES ('$eid','$ename','$tele','$email','$desig')";

    if(mysqli_query($conn,$sql)){
        echo"New Record Created Succesfully";
    }else{
        echo"Error"."<br>".mysqli_error($conn);
    }
    mysqli_close($conn);
?>