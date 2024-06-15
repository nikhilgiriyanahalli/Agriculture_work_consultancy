<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .body {
            border: solid black;
            background-size:cover;

            background-image:url(R3.jpg)
        }
        .form {
        
            margin: 7% 27% 10% 27%;
            width: 40%;
            padding: 3%;
            font-family: Arial, Helvetica, sans-serif ;
            background-color: white;
        }
        .a {
            font-size: 25px;
            color: white;
            background-color: green;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            width: 30%;
            text-align: center;
        }
        .heading {
            text-align: center;
            WIDTH: 0% 0% 3% 0%;
            padding: 2%;
        }
    </style>
</head>
<body>
    <div class="body">
        <div class="form">
            <div class="heading">
            <font face="Times New Roman" size="5"><u>
                <h1 style="">Worker Login</h1></font></u>
            </div>
            <form action="" method="POST">
            <p class="a"></p>
                <H2>
                User ID : &nbsp &nbsp <input type="text" size=30 class="" maxlength=10 name="userid" value=""><br>
                
                <p class="a"></p>
                Password :  <input type="password" class="" size=30 name="password" value=""><br><br></H2>
                
                
                <center>
                <button type="submit" name="submit" class="" style="color: RED; align: center;  font-size:25px;">Login</button></center>  
                <h3 style="margin:10%0%0%0%;">If you are a new user, please register!!!</h3><br>
                <button onclick="openWebPage()" class="" style="COLOR:ORANGE;text-align:center; font-size:20px; margin:0%0%0%0%;">Register</button>
            </form>
            <?php
            session_start(); // Start the session
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $c = mysqli_connect("localhost", "root", "", "agricultural_work_consultancy") or die("Connection failed:" . mysqli_connect_error());
                if (isset($_POST['userid']) && isset($_POST['password'])) {
                    $userid = $_POST['userid'];
                    $password = $_POST['password'];

                    $sql = "SELECT w.wid FROM worker w WHERE w.contact = ? AND w.password = ?";
                    $stmt = mysqli_prepare($c, $sql);
                    mysqli_stmt_bind_param($stmt, "ss", $userid, $password);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) > 0) {
                        // Fetch the worker ID from the result
                        $row = mysqli_fetch_assoc($result);
                        $wid = $row['wid'];

                        // Set the worker ID in the session variable
                        $_SESSION['wid'] = $wid;

                        // Redirect to the next page
                        header("Location: worker2ndpage.php");
                        exit(); // Stop further execution
                    } else {
                        echo '<script type="text/javascript">
                                    alert("Wrong credentials");
                                  </script>';
                    }
                }
            }
            ?>
        </div>
    </div>
    <script>
        function openWebPage() {
            window.open('Worker_register.php', '_blank');
        }
    </script>
</body>
</html>