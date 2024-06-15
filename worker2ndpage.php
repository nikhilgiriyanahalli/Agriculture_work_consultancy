<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Profile page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: URL(R3.jpg);
            background-size: cover;
            
            border:solid black;
        }
        .up {
            width:30%;
            margin:0%0%3%35%;
        }
        .down {
            width:60%;
            margin:0%10%5%20%;
        }
    </style>
</head>
<body>
    <div class='body'>
        <div class="up">
            <table class="table table-bordered text-center bg-primary ">
                <tr><th colspan="2" style="font-size: 25px; text-align:center;">Worker Profile</th></tr>
                <?php
                session_start();

                // Create connection
                $conn = new mysqli("localhost","root","","agricultural_work_consultancy");

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepared statement to avoid SQL injection
                $stmt = $conn->prepare("SELECT * FROM worker WHERE wid = ?");
                $stmt->bind_param("s", $_SESSION['wid']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>ID</td><td>" . $row["wid"]. "</td></tr>";
                        echo "<tr><td>Name</td><td>" . $row["wname"]. "</td></tr>";
                        echo "<tr><td>Gender</td><td>" . $row["gender"]. "</td></tr>";
                        echo "<tr><td>Age</td><td>" . $row["age"]. "</td></tr>";
                        echo "<tr><td>Contact</td><td>" . $row["contact"]. "</td></tr>";
                        echo "<tr><td>Email</td><td>" . $row["email"]. "</td></tr>";
                        echo "<tr><td>District</td><td>" . $row["district"]. "</td></tr>";
                        echo "<tr><td>Taluk</td><td>" . $row["taluk"]. "</td></tr>";
                        echo "<tr><td>Village/City</td><td>" . $row["village"]. "</td></tr>";
                        echo '<tr><td colspan="2" style="color:black"><button onclick="editWorker(' . $row["wid"] . ')">edit</button></td></tr>';
                    } 
                } else {
                    echo "0 results";
                }
                $stmt->close();
                $conn->close();
              
                ?>
           <table>
    <h3 style="background-color:white;width:40%;text-align:center;"><b>Availability</b></h3>
    <h4 style="background-color:white;width:40%;text-align:center;">(If available select yes!!)</h4>
    <form method="POST">
        <fieldset id="group1" style="background-color:white;width:40%;text-align:center;">
            <b>YES</b>: <input type="radio" value="yes" name="avail">&nbsp;
            <b>NO</b>: <input type="radio" value="no" name="avail">
        </fieldset>
        <!-- Add a hidden input field for worker ID -->
        <input type="hidden" name="wid" value="your_worker_id_here">
        <input type="submit" class="bg-danger" style="margin:1% 0 0 10%;" value="Submit">
    </form>
</table>

<?php
if (isset($_POST["avail"])) {
    // Get the selected availability option from the form
    $avail = ($_POST["avail"] == "yes") ? 1 : 0;

    $wid=$_SESSION["wid"];

    // Validate $wid here (e.g., check if it's not empty and is a valid ID)

    // Create connection
    $conn = new mysqli("localhost", "root", "", "agricultural_work_consultancy");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepared statement to avoid SQL injection
    $stmt = $conn->prepare("UPDATE worker SET availability=? WHERE wid=?");
    $stmt->bind_param("ii", $avail, $wid); // Assuming 'availability' and 'wid' are integers in the database

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>


        </div>
        
        <div class="down">
    <h2>Job requested Farmer details</h2>
    <table class="bg-primary table table-bordered text-center ">
        <?php
        
        if(isset($_SESSION['wid'])) {
            $wid = $_SESSION['wid'];
            // Create connection
            $conn = new mysqli("localhost","root","","agricultural_work_consultancy");
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepared statement to fetch farmer details associated with the worker ID
            $stmt = $conn->prepare("SELECT f.fname, f.contact, f.email, f.district, f.taluk, f.village, j.skill 
                                    FROM job_status j 
                                    JOIN farmer f ON j.fid = f.fid
                                    WHERE j.wid = ?");
            $stmt->bind_param("s", $wid);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>Farmer Name</td><td>" . $row["fname"]. "</td></tr>"; 
                    echo "<tr><td>Famrer Contact</td><td>" . $row["contact"]. "</td></tr>";
                    echo "<tr><td>Farmer Email</td><td>" . $row["email"]. "</td></tr>";
                    echo "<tr><td>District</td><td>" . $row["district"]. "</td></tr>";
                    echo "<tr><td>Taluk</td><td>" . $row["taluk"]. "</td></tr>";
                    echo "<tr><td>Village/City</td><td>" . $row["village"]. "</td></tr>";
                    echo "<tr><td>Skill hired for</td><td>" . $row["skill"]. "</td></tr>"; // Display job status
                }
            } else {
                echo "<tr><td colspan='2'>No farmer details found for this worker</td></tr>";
            }
            $stmt->close();
            $conn->close();
        } else {
            echo "Worker ID not set.";
        }
        ?>
    </table>
</div>
    </div>

    <script>
        function editWorker(workerId) {
            // Redirect to an edit page with the worker ID
            window.location.href = "edit_worker.php?wid=" + workerId;
        }
    </script>
</body>
</html>