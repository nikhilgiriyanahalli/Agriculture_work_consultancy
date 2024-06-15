<?php
// Assuming you have already established a connection to your database
$conn = mysqli_connect("localhost", "root", "", "agricultural_work_consultancy");
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the farmer ID from the form
    $fid = $_POST['fid'];

    // Begin the transaction
    mysqli_begin_transaction($conn);

    // Insert contact into blocked_numbers table
    $insert_query = "INSERT INTO blocked_numbers_farmer (contact) SELECT contact FROM farmer WHERE fid = ?";
    $insert_statement = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($insert_statement, "s", $fid);
    mysqli_stmt_execute($insert_statement);

    if (mysqli_stmt_affected_rows($insert_statement) < 1) {
        // Rollback the transaction if no rows were affected
        mysqli_rollback($conn);
        echo "<p>Error: Farmer with ID $fid not found.</p>";
    } else {
        // Delete tuple from farmer table
        $delete_query = "DELETE FROM farmer WHERE fid = ?";
        $delete_statement = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_statement, "s", $fid);
        mysqli_stmt_execute($delete_statement);

        // Commit the transaction
        mysqli_commit($conn);

        // Output success message
        echo "<p>Farmer with ID $fid blocked successfully.</p>";

        // Close the delete statement if it's not null
        if ($delete_statement !== null) {
            mysqli_stmt_close($delete_statement);
        }
    }

    // Close the insert statement
    mysqli_stmt_close($insert_statement);
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Block Farmer</title>
</head>
<body>
    <h2>Block Farmer</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="fid">Farmer ID:</label>
        <input type="text" id="fid" name="fid" required>
        <button type="submit"class="button" onclick="redirectToLogin()" >Block Farmer</button>
    </form>
    
</body>
</html>
