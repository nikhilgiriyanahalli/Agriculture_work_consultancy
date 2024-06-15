<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>List of Hired Workers</title>
    <style>
        .table {
            width: 80%;
            margin: 4% 4% 4% 8%;
            
        }
    </style>
</head>
<body>
<div class="body">
    <h1>List of hired Workers</h1>
    <div class="table">
        <?php
        // Enable error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Start session
        session_start();

        // Database connection
        $con = mysqli_connect("localhost", "root", "", "agricultural_work_consultancy");
        if (!$con) {
            die("Connection error: " . mysqli_connect_error());
        }

        // Check if fid is set in session
        if (!isset($_SESSION['fid'])) {
            die("Error: Farmer ID is not set in the session.");
        }

        // Fetch hired workers
        $fid = $_SESSION['fid'];
        $query = "SELECT w.wname, w.wid, w.contact, w.email, w.district, j.skill FROM worker w, job_status j WHERE w.wid = j.wid AND j.fid = '$fid'";
        $result = mysqli_query($con, $query);
        if (!$result) {
            die("Query execution error: " . mysqli_error($con));
        }

        // Display table header
        echo '<table class="table table-bordered text-center ">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>sl no.</th>';
        echo '<th>Worker Names</th>';
        echo '<th>Worker ID</th>';
        echo '<th>Worker contact</th>';
        echo '<th>Email</th>';
        echo '<th>District</th>';
        echo '<th>Skill Hired For</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Display hired workers
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $i++ . '</td>';
            echo '<td>' . $row['wname'] . '</td>';
            echo '<td>' . $row['wid'] . '</td>';
            echo '<td>' . $row['contact'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['district'] . '</td>';
            echo '<td>' . $row['skill'] . '</td>';
            echo '</tr>';
        }

        // Close table
        echo '</tbody>';
        echo '</table>';

        // Close database connection
        mysqli_close($con);
        ?>
    </div>
</div>
</body>
</html>
