<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Worker</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <?php
    // Start session
    session_start();

    // Check if the user is logged in
    if(isset($_SESSION['wid'])) {
        // Check if the form data is submitted
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // Establish a database connection
            $conn = new mysqli("localhost", "root", "", "agricultural_work_consultancy");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and bind parameters
            $stmt = $conn->prepare("UPDATE worker SET wname=?, gender=?, age=?, contact=?, email=?, district=?, taluk=?, village=? WHERE wid=?");
            $stmt->bind_param("ssisssssi", $wname, $gender, $age, $contact, $email, $district, $taluk, $village, $wid);

            // Set parameters from the form data
            $wname = $_POST['name'];
            $gender = $_POST['gender'];
            $age = $_POST['age'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $district = $_POST['district'];
            $taluk = $_POST['taluk'];
            $village = $_POST['village'];
            $wid = $_SESSION['wid']; // Worker ID from session

            // Execute the update statement
            if ($stmt->execute()) {
                echo "Worker details updated successfully.";
            } else {
                echo "Error updating worker details: " . $stmt->error;
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
        } else {
            // If the form data is not submitted via POST method
            echo "Form submission method not allowed.";
        }
    } else {
        // If the user is not logged in
        echo "User not logged in.";
    }
    ?>
</body>
</html>
