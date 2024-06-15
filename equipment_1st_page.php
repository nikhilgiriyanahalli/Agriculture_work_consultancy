<?php
session_start(); // Start the session

// Database connection
$con = mysqli_connect("localhost", "root", "", "agricultural_work_consultancy");
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted to confirm equipment selection
    if (isset($_POST['fsubmit'])) {
        // Get selected equipment IDs and farmer ID
        if (isset($_POST['equipment']) && is_array($_POST['equipment'])) {
            $eids = $_POST['equipment']; // Array of selected equipment IDs
            $fid = $_SESSION['fid']; // Farmer ID

            // Update equipment table with farmer ID for each selected equipment
            foreach ($eids as $eid) {
                $query = "UPDATE equipment SET fid='$fid' WHERE eid = '$eid'";
                if (!mysqli_query($con, $query)) {
                    echo "Error updating FID for equipment ID $eid: " . mysqli_error($con);
                }
            }
            $current_date=date("Y-m-d");
            $check_query="SELECT * FROM admin WHERE date='$current_date'";

            $check_result=mysqli_query($con,$check_query);

            if(mysqli_num_rows($check_result) == 0) {
                // Insert a new tuple with the no_of_workers value
                $insert_query = "INSERT INTO admin  (date, no_of_equipment) VALUES ('$current_date', " . count($eids) . ")";
                mysqli_query($con, $insert_query);
            } else {
                // Update the no_of_workers value for the current date
                $update_no_of_equipment_query = "UPDATE admin SET no_of_equipment = no_of_equipment + " . count($eids) . " WHERE date = '$current_date'";
                mysqli_query($con, $update_no_of_equipment_query);
            }
            
            echo "FID updated successfully for selected equipment.";
        }
    }
}

// Close database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>equipment hriring page</title>
    
    <!-- Include necessary CSS and JavaScript libraries -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Include inline CSS -->
    <style>
        body {
            background-image:url(R3.jpg);
            background-size: cover;
            font-size: 13px;
            border:solid black;
        }

        .up {
            width: 35%;
            height: 30%;
            margin: 0.5%0.5%0.5%1%;
            font-size: 2em;
            background-color: white;
            color: black;
            align-content: flex-end;
        }

        .down {
            width: 70%;
            margin: 2% 15% 22% 15%;
            background-color: white
        }

        select {
            width: 45%;
            height: 15%;
            padding: 1%;
            margin: 3%;
        }

        input[type="checkbox"] {
            width: 7%;
            height: 7%;
        }
    </style>
</head>

<body>
<div class="body">
    <div class="up">
    <font face="Times New Roman" size="5"><u>
                <h1><center><b>To Select Equipment</b></h1></u></center></font>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Properly close the form tag -->
            <b>Select equipment type :</b>
            <select id="Select equipment type" name="equipment">
                <option value="tractor">tractor</option>
                <option value="pulley">pulley</option>
                <option value="sprayer">sprayer</option>
                <option value="drilling machine">drilling machine</option>
                <option value="cultivator">cultivator</option>
                <option value="leveller">leveller</option>
                <option value="Ripper machine">Ripper machine</option>
                <option value="Axe">Axe</option>
            </select>
            <br>
            <button type="submit" class="bg-danger" name="submit" style="margin: 8% 0% 0% 40%; font-size: .75em;">Submit</button>
        </form>
    </div>
    <div class="down">
        <h3><b>List of Available Equipment</b></h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table class="table table-bordered text-center">
                <tr class="bg-primary">
                    <td>Equipment ID</td>
                    <td>Equipment Name</td>
                    <td>Location</td>
                    <td>Cost per day</td>
                    <td>Select</td>
                </tr>
                <?php
                
                // Display equipment options only if accessed via POST method and the "submit" button is clicked
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                    $con = mysqli_connect("localhost", "root", "", "agricultural_work_consultancy");
                    if (!$con) {
                        die("Connection error: " . mysqli_connect_error());
                    }

                    $equipment = mysqli_real_escape_string($con, $_POST['equipment']);

                    $query = "SELECT * FROM equipment e WHERE e.ename='$equipment' and fid is NULL";
                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['eid']; ?></td>
                            <td><?php echo $row['ename']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo $row['cost_per_day']; ?></td>
                            <td><input type="checkbox" name="equipment[]" value="<?php echo $row['eid']; ?>"></td>
                        </tr>
                        <?php
                    }
                    mysqli_close($con);
                }
                ?>
            </table>
            <button type="submit" name="fsubmit" style="margin: 8% 0% 0% 40%; font-size: .75em;">Confirm Selection</button>
            <?php
            
            ?>
        </form>
    </div>
</div>
</body>
</html>
