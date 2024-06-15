<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        
        .login-container {
            width: 300px;
            margin: 100px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form id="loginForm" onsubmit="return validateForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" >
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" >
            <button type="submit">Login</button>
            <p id="error" class="error"></p>
        </form>
    </div>

    <script>
        function validateForm() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var error = document.getElementById("error");

            // Simple validation, you can enhance it as needed
            if (username === "nikhil" && password === "nikhil@123"||username==="isiri"&&password==="isiri@123") {
                window.open("admin.php", "_blank");
            }
            else{
                error.textContent = "Please enter both username and password.";
                return false;
            }

            // Replace this with your actual authentication logic
            // For now, just returning true to submit the form
            return true;
        }
    </script>
</body>
</html>
