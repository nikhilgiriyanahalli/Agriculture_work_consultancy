<?php
session_start(); // Start the session

// Database connection
$con = mysqli_connect("localhost", "root", "", "agricultural_work_consultancy");
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fsubmit'])) {
    // Get selected worker IDs and farmer ID
    if(isset($_POST['worker_ids']) && is_array($_POST['worker_ids'])) {
        $worker_ids = $_POST['worker_ids'];
        $farmer_id = $_SESSION['fid'];
        $skill = $_SESSION['skill'];

        // Get additional farmer information
        $query_farmer = "SELECT * FROM farmer f WHERE fid = '$farmer_id'";
        $result_farmer = mysqli_query($con, $query_farmer);
        $farmer_info = mysqli_fetch_assoc($result_farmer);
        

        // Insert selected workers into job status table
        foreach($worker_ids as $worker_id) {
            $query = "INSERT INTO job_status (fid, wid, skill) 
                      VALUES ('$farmer_id', '$worker_id','$skill')";
            if (!mysqli_query($con, $query)) {
                echo "Error: " . mysqli_error($con);
            }
            // Update worker availability
            $update_query = "UPDATE worker SET availability = 0 WHERE wid = '$worker_id'";
            mysqli_query($con, $update_query);
            $current_date=date("Y-m-d");
            $check_query="SELECT * FROM admin WHERE date='$current_date'";

            $check_result=mysqli_query($con,$check_query);

            if(mysqli_num_rows($check_result) == 0) {
                // Insert a new tuple with the no_of_workers value
                $insert_query = "INSERT INTO admin  (date, no_of_workers) VALUES ('$current_date', " . count($worker_ids) . ")";
                mysqli_query($con, $insert_query);
            } else {
                // Update the no_of_workers value for the current date
                $update_no_of_workers_query = "UPDATE admin SET no_of_workers = no_of_workers + " . count($worker_ids) . " WHERE date = '$current_date'";
                mysqli_query($con, $update_no_of_workers_query);
            }
        }
    }
}

// Close database connection
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Famer page</title>
    <style>
        body {
            background-size:cover;

    background-image:url(R3.jpg);
      
            font-size: 13px;
            border: solid black;
            margin:0.5%0.5%0.5%0.5%;
            
        }

        .up {
            width: 35%;
            height: 40%;
            margin: 2%0%0%2%;
            font-size: 1.78em;
            border:solid white;
            color: black;
           
            background-color:white;
        }

        .down {
            width: 70%;
            margin: 2% 15% 22% 15%;
            background-color: white;
        }

        select {
            width: 45%;
            height: 15%;
            padding: 1%;
            margin: 3%0%0%0%;
        }

        input[type="radio"] {
            width: 7%;
            height: 7%;
        }

        .submit {
            margin: 0% 0% 1% 45%;
        }
    </style>
</head>
<body bgcolor : white>
<div class="body">
    <div class="up">
    <font face="Times New Roman" size="5"><u>
        <h1><b>  Parameters for selecting Workers</b></h1></u></font>
        <form method="post">
            <b>&nbsp Skill :</b>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
            <select name="skill" id="skill">
                <option value="Ploughing">Ploughing</option>
                <option value="Irrigation">Irrigation</option>
                <option value="Coconut-Harvesting">Coconut-Harvesting</option>
                <option value="Arecanut-Harvesting">Arecanut-Harvesting</option>
                <option value="Cotton-Harvesting">Cotton-Harvesting</option>
                <option value="Tea-Harvesting">Tea-Harvesting</option>
                <option value="Coffee-Harvesting">Coffe-Harvesting</option>
                <option value="Driving">Driving</option>
                <option value="High powered job">High Powered job</option>
                <option value="Medium powered job">Medium powered job</option>
                
            </select>
            <br>
            <br>
            <fieldset id="group1">
                <b> &nbsp Gender :</b> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Male<input type="radio" value="M" name="gender">
                Female<input type="radio" value="F" name="gender">
                NA<input type="radio" value="NA" name="gender">
            </fieldset>
            <b> &nbsp Select District :</b>&nbsp 
            <select id="district" name="district">
            <option value="Bangalore Urban">Bangalore Urban</option>
            <option value="Bangalore Rural">Bangalore Rural</option>
            <option value="Belgaum">Belgaum</option>
            <option value="Bellary">Bellary</option>
            <option value="Bidar">Bidar</option>
            <option value="Chamarajanagar">Chamarajanagar</option>
            <option value="Chikballapur">Chikballapur</option>
            <option value="Chikmagalur">Chikmagalur</option>
            <option value="Chitradurga">Chitradurga</option>
            <option value="Dakshina Kannada">Dakshina Kannada</option>
            <option value="Davanagere">Davanagere</option>
            <option value="Dharwad">Dharwad</option>
            <option value="Gadag">Gadag</option>
            <option value="Gulbarga">Gulbarga</option>
            <option value="Hassan">Hassan</option>
            <option value="Haveri">Haveri</option>
            <option value="Kodagu">Kodagu</option>
            <option value="Kolar">Kolar</option>
            <option value="Koppal">Koppal</option>
            <option value="Mandya">Mandya</option>
            <option value="Mysuru">Mysuru</option>
            <option value="Raichur">Raichur</option>
            <option value="Ramanagara">Ramanagara</option>
            <option value="Shimoga">Shimoga</option>
            <option value="Tumkur">Tumkur</option>
            <option value="Udupi">Udupi</option>
            <option value="Uttara Kannada">Uttara Kannada</option>
            <option value="Vijayapura">Vijayapura</option>
            <option value="Yadgir">Yadgir</option>
        </select>

            <button type="submit" class="bg-danger" name="submit"
                    style="margin: 8% 0% 0% 40%; font-size: .75em;">Submit
            </button>
        </form>
    </div>
    <div class="down">
        <h3>List of Available Workers</h3>
        <form method="post">
            <table class="table table-bordered text-center ">
                <tr class="bg-primary">
                    <td>Worker ID</td>
                    <td>Worker Name</td>
                    <td>Age</td>
                    <td>Gender</td>
                    <td>Contact</td>
                    <td>Select</td>
                </tr>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
                    $con = mysqli_connect("localhost", "root", "", "agricultural_work_consultancy");
                    if (!$con) {
                        die("Connection error: " . mysqli_connect_error());
                    }

                    $skill = isset($_POST['skill']) ? mysqli_real_escape_string($con, $_POST['skill']) : '';
                    $gender = isset($_POST['gender']) ? mysqli_real_escape_string($con, $_POST['gender']) : '';
                    $district = isset($_POST['district']) ? mysqli_real_escape_string($con, $_POST['district']) : '';
                    

                    //setting a Session variable
                    $_SESSION['skill']=$skill;
                if($gender=="NA"){
                    $query = "SELECT w.wid,w.wname,w.age,w.gender,w.contact FROM worker w,skill s WHERE w.wid=s.wid and s.sname = '$skill' and availability=1 and district like '$district'";
                }
                else{
                    $query = "SELECT w.wid,w.wname,w.age,w.gender,w.contact FROM worker w,skill s WHERE w.wid=s.wid and s.sname = '$skill' AND w.gender = '$gender'and availability=1 and district like '$district'";
                }

                    
                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['wid']; ?></td>
                            <td><?php echo $row['wname']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td><input type="checkbox" name="worker_ids[]" value="<?php echo $row['wid']; ?>"></td>
                        </tr>
                        <?php
                    }
                    mysqli_close($con);
                }
                ?>
            </table>
            <div>
                <button type="submit" class="submit" name="fsubmit" >Submit</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>