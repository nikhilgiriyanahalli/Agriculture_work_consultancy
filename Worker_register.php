<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Worker Registration Form</title>
    <style>
         body {
            font-family: 'Arial', sans-serif;
    
            margin: 0;
            padding: 0;
            border: solid black;
            background-image: URL(R3.jpg);
            background-size: cover;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-wrap: wrap;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            flex-basis: 100%;
        }

        input,
        select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex-basis: calc(50% - 10px);
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container"><font face="Times New Roman" size="5"><u>
        <h2><center>Worker Registration Form</center></h2></font></u>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="wname">wname:</label>
            <input type="text" id="wname" name="wname" required>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required>

            <label for="district">District:</label>
            <select id="district">
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
            <option value="Mysore">Mysore</option>
            <option value="Raichur">Raichur</option>
            <option value="Ramanagara">Ramanagara</option>
            <option value="Shimoga">Shimoga</option>
            <option value="Tumkur">Tumkur</option>
            <option value="Udupi">Udupi</option>
            <option value="Uttara Kannada">Uttara Kannada</option>
            <option value="Vijayapura">Vijayapura</option>
            <option value="Yadgir">Yadgir</option>
        </select>


            <label for="taluk">Taluk:</label>
            <input type="text" id="taluk" name="taluk">

            <label for="village">Village/City:</label>
            <input type="text" id="village" name="village">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="age">Age:</label>
            <input type="text" id="age" name="age">

            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender">

            <button type="submit">Submit</button>
        </form>
    </div>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $wname = isset($_POST["wname"]) ? $_POST["wname"] : '';
            $contact = isset($_POST["contact"]) ? $_POST["contact"] : '';
            $district = isset($_POST["district"]) ? $_POST["district"] : '';
            $taluk = isset($_POST["taluk"]) ? $_POST["taluk"] : '';
            $village = isset($_POST["village"]) ? $_POST["village"] : '';
            $email = isset($_POST["email"]) ? $_POST["email"] : '';
            $password1 = isset($_POST["password"]) ? $_POST["password"] : '';
            $age = isset($_POST["age"]) ? $_POST["age"] : '';
            $gender = isset($_POST["gender"]) ? $_POST["gender"] : '';

            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "agricultural_work_consultancy";
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute the SQL query
            $sql = "INSERT INTO worker (wname, contact, district, taluk, village, email, password, age, gender,availability) VALUES ( '$wname', '$contact', '$district', '$taluk', '$village', '$email', '$password1', '$age', '$gender','1')";

            if ($conn->query($sql) === TRUE) {
                echo "Record inserted successfully";
                $_SESSION['wid'] = $wid;
                echo "<script>window.location.href='skill.php';</script>"; // Redirect using JavaScript
                exit(); // Terminate script execution after redirection
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close(); // Close the database connection
        }
    ?>
</body>
</html>
