<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;

        }

        .navbar {
            overflow: hidden;
            background-color: #333;
            position: fixed;
            top: 0;
            width: 100%;
            height: 8%;
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
            margin:10px;
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
            height: 100%;
        }

        .navbar a.active {
            background-color: #555;
            color: white;
        }

        .body-content {
            margin-top: 80px; /* Adjust according to navbar height */
            padding: 20px;
        }
        .down{
            margin:10%35%40%35%;
            width:50%;
            
           
        }
        button{
            width: 60%;
            padding: 5%;
            font-size: 20px;
            background-color: black;
            color:white;
        }
    </style>
</head>

<body>
    <div class="body">
    <div class="navbar">
        <div class="navbar-left"></div>
        <div class="navbar-right">
            <a href="#" id='c' onclick="openwebpage(this.id);">list of hired workers</a>
            <a href="#" id="d" onclick="openwebpage(this.id);">List of hired equipment</a>
        </div>
    </div>
    <div class="down">
        <div class="a">
            <div><button class="x"onclick="openwebpage('a')"><b>Hire Worker</b></button></div>
            <div style="margin:3%0%0%0%">
                <button class="x"onclick="openwebpage('b')"><b>Hire Equipment</b></button>
            </div>
        </div>
    </div>
    
    <script>
        function openwebpage(id)
        {
            if(id=='a')
                window.open("farmer_3rd_page.php","_blank");
            else if(id=='b')
                window.open("equipment_1st_page.php","_blank");
            else if(id=="c")
                window.open("listofhiredworkers.php","_blank");
            else
                window.open("list_of_hired_equipment.php","_blank");
        }
    </script>

    
</body>

</html>
