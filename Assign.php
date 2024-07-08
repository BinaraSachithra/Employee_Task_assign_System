<!DOCTYPE html>
<html>
<head>
    <title>Assign Task</title>
</head>

<body>
    <h2>Assign task to Employee</h2>
    <form method="post" action="process_assign.php">
        <label for="eid">Employee ID:</label>
        <select name="eid" id="eid">
            <?php
            //connect to your database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Project";

            $conn = new mysqli($servername,$username,$password,@$dbname);

            if($conn->connect_error){
                die("Connection failed: ".$conn->connect_error);
            }
            //Get Employee IDs from the database
            $sql = "SELECT eid,ename FROM Employee";
            $result = $conn->query($sql);

            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    echo "<option values='".$row["Eid"]."'>".$row["EName"]."</option>";
                }
            }

            $conn->close();
            ?>
        </select>
        <br>
        <br>

        <label for="tid">TaskID:</label>
        <select name="tid" id="tid">
            <?php
            //connect to your database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Project";

            $conn = new mysqli($servername,$username,$password,$dbname);

            if($conn->connect_error){
                die("Connection failed: ".$conn->connect_error);
            }
            //Get Task ID from the database
            $sql = "SELECT tid, tname FROM Task";
            $result = $conn->query($sql);

            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    echo "<option value='".$row["tid"]."'>".$row["tname"]."</option";
                }
            }

            $conn->close();
            ?>
        </select>
        <br>
        <br>

        <input type="submit" value="Assign Task for Employee">
    </form>
</body>
</html>