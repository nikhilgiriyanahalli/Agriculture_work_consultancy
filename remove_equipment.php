<?php
// Assuming you have already established a connection to your database
$conn = mysqli_connect("localhost", "root", "", "agricultural_work_consultancy");
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the equipment ID from the form
    $eid = $_POST['eid'];

    // Prepare and execute the delete query
    $delete_query = "DELETE FROM equipment WHERE eid = ?";
    $delete_statement = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($delete_statement, "s", $eid);
    mysqli_stmt_execute($delete_statement);

    if (mysqli_stmt_affected_rows($delete_statement) > 0) {
        echo "<p>Equipment with ID $eid deleted successfully.</p>";
    } else {
        echo "<p>Error: Equipment with ID $eid not found.</p>";
    }

    // Close the delete statement
    mysqli_stmt_close($delete_statement);
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Equipment</title>
</head>
<body>
    <h2>Delete Equipment</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="eid">Equipment ID:</label>
        <input type="text" id="eid" name="eid" required>
        <button type="submit">Delete Equipment</button>
    </form>
</body>
</html>
