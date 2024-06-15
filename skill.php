<!DOCTYPE html>
<html>
<head>
    <title>Worker Registration Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 650px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height:500px;
        }

        form {
            flex-wrap: wrap;
            height:300px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            flex-basis: 100%;
        }

        select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex-basis: calc(50% - 10px);
            box-sizing: border-box;
            font-size:20px;
        }

        .button {
            background-color: #4caf50;
            color: #fff;
            padding: 2%; /* Adjust padding to make the button smaller */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 20%;
            margin:1%0%2%40%;
            font-size: 15px; /* Adjust font size to make the button smaller */
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Worker Registration Form</h2>
        <div class="form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">   
                <label for="skills">Skills:</label>
                <select id="skills" name="skills[]" multiple>
                    <option value="Ploughing">Ploughing</option>
                    <option value="Irrigation">Irrigation</option>
                    <option value="Coconut-Harvesting">Coconut Harvesting</option>
                    <option value="Arecanut-Harvesting">Arecanut Harvesting</option>
                    <option value="Cotton-Harvesting">Cotton Harvesting</option>
                    <option value="Tea-Harvesting">Tea Harvesting</option>
                    <option value="Coffee-Harvesting">Coffee Harvesting</option>
                    <option value="Driving">Driving</option>
                    <option value="High powered job">High powered job</option>
                    <option value="Medium powered job">Medium powered job</option>
                </select>
                <div>
                    <br>
                    <button type="button" class="button" onclick="redirectToLogin()">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    session_start();

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve worker ID from session
        $worker_id = $_SESSION['wid'];
    
        // Retrieve selected skills from the form
        $skills = isset($_POST["skills"]) ? $_POST["skills"] : array();

        // Connect to your database (replace these with your actual database credentials)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "agricultural_work_consultancy";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert each selected skill into the database
        foreach ($skills as $skill) {
            // Sanitize input to prevent SQL injection
            $skill = $conn->real_escape_string($skill);
            
            // Prepare SQL statement
            $sql = "INSERT INTO skill (wid, sname) VALUES ('$worker_id', '$skill')";
            
            // Execute SQL statement
            if ($conn->query($sql) === TRUE) {
                echo "Record inserted successfully for skill: $skill<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Close the database connection
        $conn->close();
    }
    ?>
    
    <script>
        // Function to allow selecting multiple options without holding Ctrl key
        document.getElementById('skills').addEventListener('mousedown', function(event) {
            event.preventDefault();

            var select = this;
            var scroll = select.scrollTop;

            event.target.selected = !event.target.selected;

            setTimeout(function() {
                select.scrollTop = scroll;
            }, 0);
        });

        function redirectToLogin() {
            window.location.href = "Worker_login.php";
        }
    </script>
   
</body>
</html>
