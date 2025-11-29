<?php 
if ($_SESSION['acces_allowed'] ?? false) {
    header("Location: ./"); // Redirect to the index page if access is already allowed
    exit();
}
if (isset($_POST['userInput'])) {
    $userInput = $_POST['userInput'];
    // Process the input as needed, e.g., save to database or perform validation
    // For demonstration, we'll just echo it back
    if($userInput == "") {
        echo "script>alert('Please enter a valid input.');</script>";
    } else {
        if($userInput == "OA2025") {
            echo "<script>alert('Access granted!');</script>";
            $_SESSION['acces_allowed'] = true; // Store the access code in session
            header("Location: ./"); // Redirect to the index page
            exit();
        } else {
            echo "<script>alert('Access denied!');</script>";
        }
    }
    echo "<p>You entered: " . htmlspecialchars($userInput) . "</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acces Code Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: #4CAF50;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        
        button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
        }
        
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Acces Code Form</h1>
        <form action="" method="post">
            <label for="userInput">Enter your Acces Code:</label>
            <input type="text" id="userInput" name="userInput" placeholder="Type something here...">
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>