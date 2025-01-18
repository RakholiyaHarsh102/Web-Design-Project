<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $mobileNumber = htmlspecialchars($_POST['mobileNumber']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirmPassword']);
    $dob = htmlspecialchars($_POST['dob']);
    $gender = htmlspecialchars($_POST['gender']);

    // Handle file upload
    if (isset($_FILES['photograph']) && $_FILES['photograph']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['photograph']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate file type
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $allowedTypes)) {
            // Save file to server
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            if (move_uploaded_file($_FILES['photograph']['tmp_name'], $targetFile)) {
                $photoPath = $targetFile;
            } else {
                echo "Error uploading file.";
                exit;
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            exit;
        }
    } else {
        echo "File upload error.";
        exit;
    }

    // Check password match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    

    // Display success message
    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Registration Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f9;
            padding: 2rem;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        img {
            max-width: 100px;
            margin: 1rem 0;
            border-radius: 50%;
        }
        .success {
            color: green;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Welcome, $mobileNumber!</h1>
        <p class='success'>Registration successful!</p>
        <p><strong>Date of Birth:</strong> $dob</p>
        <p><strong>Gender:</strong> $gender</p>
        <p>Your uploaded photograph:</p>
        <img src='$photoPath' alt='User Photograph'>
    </div>
</body>
</html>";
} else {
    echo "Invalid request method.";
}
?>
