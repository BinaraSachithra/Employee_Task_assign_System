<?php
//create connection
$conn = mysqli_connect("localhost","root","","Project");

//check connection
if (!$conn) {
    die("Connection failed:".mysqli_connect_error());
} else {
    echo"<script>console.log('connected');</script>";
}

$addedActivities = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $tid = $_POST["tid"];
        $activity = $_POST["activity"];
        
        $addedActivities[] = array(
            "tid" => $tid,
            "activity" => $activity,
        );
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Activities to Task</title>

    <style>
        *{
            margin: 0; 
            padding: 0;
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        body{
            background-color:transparent;
            font-family:Verdana, Geneva, Tahoma, sans-serif;
            background-image: url('Images/emp1.jpg');
            background-repeat: no-repeat;
            background-size:cover;
        }

        h1{
            color:cornsilk;
            text-align: center;
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            margin-top: 30px;
        }

        .container2{
            max-width: 700px;
            margin: auto;
            margin-top: 20px;
            padding: 20px;
            background-color:transparent;
            border-radius: 40px;
            box-shadow: 1px 1px 50px rgba(0, 0, 1, 2);
        }

        .form-table{
            width: 300px;
            padding: 7px;
            margin-bottom: 10px;
            border-radius: 6px;
        }

        label{
            display:inline-block;
            font-weight: bolder;
            margin-bottom: 10px;
            color:seashell;
        }

        input[type="text"]{
            width: 300px;
            padding: 7px;
            margin-bottom: 10px;
            border-radius: 6px;
        }

        input[type="number"]{
            width: 300px;
            padding: 7px;
            margin-bottom: 10px;
            border-radius: 6px;
        }

        input[type="submit"] {
            text-align: center;
            display: block;
            margin: auto;
            background-color: burlywood;
            padding: 10px 50px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 800;
        }

        input[type="submit"]:hover{
            opacity: 0.75;
        }

        .navbar{
            display: flex;
            align-items: center;
            padding: 20px;
        }

        nav{
            flex: 1;
            text-align: right;
        }
        nav ul{
            display: inline-block;
            list-style-type: none;
        }
        nav ul li{
            display: inline-block;
            margin-right: 20px;
        }
        a{
            text-decoration: none;
            color: #3e3131;
        }
        p{
            color: #3e3131;
        }
        .header{
            background: radial-gradient(#fff,#749be8);
        }
        .header .row{
            margin-top: 0px;
        }
    </style>
</head>
<body>
    <div class="header">
            <div class="navbar">
            <nav>
                <ul id="MenuItems">
                    <li><a href="Activity.php">Activity</a></li>
                    <li><a href="Task.html">Task</a></li>
                    <li><a href="">Report</a></li>
                    <li><input type="submit" value="Logout" name="submit" id="logout"></li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="container2">
        <form id="activity-form" action="assignTask.php" method="post" class="p-4 bg-light rounded">
            <h2>Activities</h2>
            <table class="form-table">
                <tr>
                    <td class="form-label">Task ID  </td>
                    <td>
                        <select name="tid" id="tid" class="form-control">
                            <?php
                            // Populate the dropdown with Task IDs from the database
                            $sql = "SELECT Tid FROM Task";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row["Tid"] . "'>" . $row["Tid"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="form-label">Activity  </td>
                    <td><input type="text" name="activity" class="form-control"/></td>
                </tr>
            </table>
            <input type="button" value="Add" name="add" id="add" class="btn btn-success">
        </form>
    </div>
    <br><br>

    <div class="table-container">
        <table class="table">
            <thead class="mx-auto">
                <tr>
                    <th>Task ID </th>
                    <th>Activity </th>
                    <th>Action </th>
                </tr>
            </thead>
            <tbody id="activity-table-body" class="mx-auto">
                
            </tbody>
        </table>
        <input type="submit" name="submit" id="submit" class="btn btn-primary">
    </div>

    <script>
    $(document).ready(function () {
        var addedActivities = []; // Initialize an empty array in JavaScript

        // Handle the "Add" button click using JavaScript
        $("#add").click(function () {
            var $tid = $("#tid").val();
            var $activity = $("input[name='activity']").val();

            // Create a new activity object with a manually specified activityId
            var newActivity = {
                "Tid": tid,
                "activity": activity
            };

            // Add the new activity to the addedActivities array
            addedActivities.push(newActivity);

            // Clear the input field
            $("input[name='activity']").val("");

            // Refresh the table with the updated data
            refreshTable();
        });

        // Function to refresh the table with added data
        function refreshTable() {
            var tableBody = $("#activity-table-body"); // Get the table body
            tableBody.empty(); // Clear the table body

            // Loop through addedActivities and append rows to the table body
            for (var i = 0; i < addedActivities.length; i++) {
                var data = addedActivities[i];
                var row = "<tr><td>" + data.tid + "</td><td>" + data.activity + "</td><td><button  class='btn btn-danger delete-btn' data-index='" + i + "'>Delete</button></td></tr>";
                tableBody.append(row);
            }

            //add delete button
            $(".delete-btn").click(function () {
                var index = $(this).data("index");
                addedActivities.splice(index, 1); // Remove the item from the array
                refreshTable(); // Refresh the table to reflect the changes
            });
        }

        // Handle the form submission
        $("#submit").click(function () {
            $.ajax({
                type: "POST",
                url: "assignTask.php",
                data: { "addedActivities": addedActivities },
                success: function (response) {
                    // Handle the response from the server 
                    if (response === "success") {
                        alert("Data submitted successfully!");
                        // Clear the addedActivities array and refresh the table
                        addedActivities = [];
                        refreshTable();
                    } else {
                    alert("Data submitted successfully!");
                        // Clear the addedActivities array and refresh the table
                        addedActivities = [];
                        refreshTable();

                        // alert("Error: " + response);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle AJAX errors
                    alert("AJAX Error: " + error);
                }
            });
        });
    });

    </script>
</body>
</html>
