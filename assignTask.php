<?php
    $taskId = $_POST["tid"];
    $activity = $_POST["activity"];
    $database = "Project";

    //create connection
    $conn = mysqli_connect("localhost","root","","Project");

    if(!$conn){
        die("Connection failed: ".mysqli_connect_error());
    }else{
        echo "Conected successfuly"."<br>";
    }

    $sql = "INSERT INTO TaskActivity (activityid,tid,activity)
            VALUES ('','$taskId','$activity')";

    if(mysqli_query($conn,$sql)){
        echo "Activity added successfully.";
    } else {
        echo "Error"."<br>".mysqli_error($conn);
    }
    $conn->close();
?>