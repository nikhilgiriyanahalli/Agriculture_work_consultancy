<?php
session_start();

// Check if the worker ID is set and the user is logged in
if( isset($_SESSION['wid'])) {
    // Check if the logged-in worker ID matches the requested worker ID
    
        // Establish a database connection
        $conn = new mysqli("localhost", "root", "", "agricultural_work_consultancy");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepared statement to avoid SQL injection
        $stmt = $conn->prepare("SELECT * FROM worker WHERE wid = ?");
        $stmt->bind_param("s", $_GET['wid']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Worker found, fetch details
            $worker = $result->fetch_assoc();
        } else {
            // Worker not found
            echo "Worker not found.";
        }

        $stmt->close();
        $conn->close();
    
} 


// If worker details are not retrieved successfully, initialize an empty array
if(!isset($worker)) {
    $worker = array(
        'wname' => '',
        'gender' => '',
        'age' => '',
        'contact' => '',
        'email' => '',
        'district' => '',
        'taluk' => '',
        'village' => ''
    );
}

// Process form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update worker details if new values are provided
    $worker['wname'] = isset($_POST['name']) ? $_POST['name'] : $worker['wname'];
    $worker['gender'] = isset($_POST['gender']) ? $_POST['gender'] : $worker['gender'];
    $worker['age'] = isset($_POST['age']) ? $_POST['age'] : $worker['age'];
    $worker['contact'] = isset($_POST['contact']) ? $_POST['contact'] : $worker['contact'];
    $worker['email'] = isset($_POST['email']) ? $_POST['email'] : $worker['email'];
    $worker['district'] = isset($_POST['district']) ? $_POST['district'] : $worker['district'];
    $worker['taluk'] = isset($_POST['taluk']) ? $_POST['taluk'] : $worker['taluk'];
    $worker['village'] = isset($_POST['village']) ? $_POST['village'] : $worker['village'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Worker</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .container{
            width:30%;
            margin:1%5%5%35%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Worker Details</h2>
        <form action="update_worker.php" method="POST">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?wid=" . $_GET['wid']; ?>" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $worker['wname']; ?>">
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $worker['gender']; ?>">
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" class="form-control" id="age" name="age" value="<?php echo $worker['age']; ?>">
            </div>
            <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $worker['contact']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $worker['email']; ?>">
            </div>
            <div class="form-group">
                <label for="district">District:</label>
                <input type="text" class="form-control" id="district" name="district" value="<?php echo $worker['district']; ?>">
            </div>
            <div class="form-group">
                <label for="taluk">Taluk:</label>
                <input type="text" class="form-control" id="taluk" name="taluk" value="<?php echo $worker['taluk']; ?>">
            </div>
            <div class="form-group">
                <label for="village">Village/City:</label>
                <input type="text" class="form-control" id="village" name="village" value="<?php echo $worker['village']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
</form>
    </div>
</body>
</html>
