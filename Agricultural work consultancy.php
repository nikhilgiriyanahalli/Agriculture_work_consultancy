<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-size:cover;
            background-image: url(T1.jpg);
        }

        .navbar {
            overflow: hidden;
            background-color: #333;
            position: fixed;
            top: 0;
            width: 100%;
            height: 9%;
            z-index: 1000;
        }

        .navbar-left {
            float: left;
            padding: 16px 20px;
            color: white;
            font-size: 18px;
        }

        .navbar-right {
            float: right;
            height: 100%;
            margin:1%;
        }

        .navbar a {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
            transition: background-color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
            height:100%;
        }

        .navbar a.active {
            background-color: #555;
            color: white;
        }

        .body-content {
            margin-top: 80px; /* Adjust according to navbar height */
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="navbar-left">Home</div>
        <div class="navbar-right">
            <a href="#" id='a' onclick="openwebpage(this.id);">Admin</a>
            <a href="#" id="b" onclick="openwebpage(this.id);">Farmer</a>
            <a href="#" id="c" onclick="openwebpage(this.id);">Worker</a>
           
            <a href="#" id="e" onclick="openwebpage(this.id);">Terms & Conditions</a>
        </div>
    </div>

    <div class="image">
        <!-- Your content goes here -->
    </div>

    <script>
        function openwebpage(id) {
            if (id == "a")
                window.open("admin_login.php", "_blank");
            if (id == "b")
                window.open("farmer_login.php", "_blank");
            if (id == "c")
                window.open("Worker_login.php", "_blank");
            if (id == "d")
                window.open("Worker_login.php", "_blank");
            else
                window.open("terms&conditions.php", "_blank");
        }
    </script>
</body>

</html>
