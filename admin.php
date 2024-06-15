<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "agricultural_work_consultancy");
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

// Check if the "clear job status" anchor is clicked
if(isset($_GET['clear_job_status'])) {
    // Delete all tuples from the "job status" table
    $clear_query = "DELETE FROM job_status";
    if(mysqli_query($con, $clear_query)) {
        echo "<script>alert('Job status cleared successfully!');</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Monthly hiring of equipment
$equipment_query = "SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(no_of_equipment) AS total_equipment_hired 
                    FROM admin 
                    GROUP BY YEAR(date), MONTH(date)";
$equipment_result = mysqli_query($con, $equipment_query);

// Monthly hiring of workers
$worker_query = "SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(no_of_workers) AS total_workers_hired 
                 FROM admin
                 GROUP BY YEAR(date), MONTH(date)";
$worker_result = mysqli_query($con, $worker_query);

// Close database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .navbar {
            overflow: hidden;
            background-color: #333;
            position: fixed;
            top: 0;
            width: 100%;
            height: 50px; /* Increased height to make the button visible */
            z-index: 1000;
        }

        .navbar-left {
            float: left;
            padding: 16px 20px;
            color: white;
            font-size: 18px;
        }

        .navbar-right {
            float: right;
            margin-right: 20px; /* Adjusted margin */
        }

        .navbar a {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
            transition: background-color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
            height: 100%;
        }

        /* Style the clear job status button */
        .clear-job-status {
            border: none;
            color: white;
            padding: 14px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 17px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

       

        .body-content {
            margin-top: 80px;
            /* Adjust according to navbar height */
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid black;
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            padding: 25px;
        }
        .leftside{
            width: 100%;
            display: flex;

        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="navbar-left">Home</div>
        <div class="navbar-right">
            <a href="#" id='a' onclick="openwebpage(this.id);">block famer</a>
            <a href="#" id="b" onclick="openwebpage(this.id);">block worker</a>
            <a href="#" id="c" onclick="openwebpage(this.id);">remove equipment</a>
            <a href="?clear_job_status=1" class="clear-job-status">Clear Job Status</a>
        </div>
    </div>

    <div class="image">
        <!-- Your content goes here -->
    </div>
    <br>
    <br><br>
    <div class="leftside">
        <div style="margin:2%;">
            <h2>Monthly Hiring of Equipment</h2>
            <table>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Total Equipment Hired</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($equipment_result)) {
                    echo "<tr>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>" . $row['month'] . "</td>";
                    echo "<td>" . $row['total_equipment_hired'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <div style="margin:2%;">
            <h2>Monthly Hiring of Workers</h2>
            <table>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Total Workers Hired</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($worker_result)) {
                    echo "<tr>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>" . $row['month'] . "</td>";
                    echo "<td>" . $row['total_workers_hired'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div class="rightside">
    <script>
        function openwebpage(id) {
            if (id == "a")
                window.open("blockfarmer.php", "_blank");          
            else if (id == "b")
                window.open("blockworker.php", "_blank");
            else
                window.open("remove_equipment.php", "_blank");
          
           
        }
    </script>

</body>

</html>