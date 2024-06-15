
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: white;
            background-image: url(R.jpeg);
            font-size: 13px;
        }

        .up {
            width: 35%;
            height: 40%;
            margin: 0%;
            font-size: 2em;
            background-color: #3090CF;
            color: black;
            align-content: flex-end;
        }

        .down {
            width: 70%;
            margin: 2% 15% 2% 15%;
            background-color: white;
        }

        select {
            width: 45%;
            height: 15%;
            padding: 1%;
            margin: 3%;
        }

        input[type="radio"] {
            width: 7%;
            height: 7%;
        }
    </style>
</head>

<body>
<div class="body">
    <div class="up">
        <h1>Parameters for selecting Workers</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Skill:
            <select name="skill" id="skill">
                <option value="Ploughing">Ploughing</option>
                <option value="Driving">Driving</option>
                <option value="High powered job">High Powered job</option>
                <option value="Medium powered job">Medium powered job</option>
            </select>
            <br>
            Gender
            <fieldset id="group1">
                Male:<input type="radio" value="M" name="gender">
                Female:<input type="radio" value="F" name="gender">
                NA:<input type="radio" value="NA" name="gender">
            </fieldset>
            <button type="submit" class="bg-danger" name="submit"
                    style="margin: 8% 0% 0% 40%; font-size: .75em;">Submit
            </button>
        </form>
    </div>
    <div class="down">
        <h3>List of Available Workers</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table class="table table-bordered text-center ">
                <tr class="bg-primary">
                    <td>Worker ID</td>
                    <td>Worker Name</td>
                    <td>Age</td>
                    <td>Gender</td>
                    <td>Contact</td>
                    <td>Select</td>
                </tr>
                <tr>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $con = mysqli_connect("localhost", "root", "", "agricultural_work_consultancy");
                        if (!$con) {
                            die("Connection error: " . mysqli_connect_error());
                        }

                        $skill = mysqli_real_escape_string($con, $_POST['skill']);
                        $gender = mysqli_real_escape_string($con, $_POST['gender']);

                        // Debugging output
                        echo "Skill: " . $skill . "<br>";
                        echo "Gender: " . $gender . "<br>";

                        $query = "SELECT * FROM worker w,skill s WHERE w.wid=s.wid and s.sname = '$skill' AND w.gender = '$gender'";
                        $result = mysqli_query($con, $query);

                        // Debugging output
                        echo "Number of rows: " . mysqli_num_rows($result) . "<br>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <td><?php echo $row['wid']; ?></td>
                            <td><?php echo $row['wname']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td>
                                <input type="checkbox" name="selectedWorkers[]" value="<?php echo $row['wid']; ?>">
                            </td>
                            </tr>
                            <?php
                        }

                        // After the while loop, insert selected workers into the new table
                        if (isset($_POST['submit'])) {
                            $selectedWorkers = isset($_POST['selectedWorkers']) ? $_POST['selectedWorkers'] : array();

                            foreach ($selectedWorkers as $selectedWorkerID) {
                                $insertQuery = "INSERT INTO SelectedWorkers SELECT * FROM worker WHERE wid = '$selectedWorkerID'";
                                mysqli_query($con, $insertQuery);
                            }
                        }
                        if ( isset($_POST['fsubmit'])) {
                            // Get selected worker IDs and farmer ID
                            if(isset($_POST['worker_ids']) && is_array($_POST['worker_ids'])) {
                                $worker_ids = $_POST['worker_ids'];
                                $farmer_id = $_SESSION['fid'];
                        
                                // Get additional farmer information
                                $query_farmer = "SELECT * FROM farmer f WHERE fid = '$farmer_id'";
                                $result_farmer = mysqli_query($con, $query_farmer);
                                $farmer_info = mysqli_fetch_assoc($result_farmer);
                                $farmer_contact = $farmer_info['contact'];
                                $farmer_location = $farmer_info['address'];
                                $farmer_email = $farmer_info['email'];
                                
                                
                        
                                // Insert selected workers into job status table
                                foreach($worker_ids as $worker_id) {
                                    $query = "INSERT INTO job_status (fid, wid, contact, location, email, skill) 
                                              VALUES ('$farmer_id', '$worker_id', '$farmer_contact', '$farmer_location', '$farmer_email', '$skill')";
                                    if (!mysqli_query($con, $query)) {
                                        echo "Error: " . mysqli_error($con);
                                    }
                                }
                            }
                        }

                        mysqli_close($con);
                    }
                    
                    ?>
            </table>
            <button type="submit" class="bg-danger" name="submit" style="margin-top: 1em;">Submit Selected Workers</button>
        </form>
    </div>
</div>
</body>
</html>