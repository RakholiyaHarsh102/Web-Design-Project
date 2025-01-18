<?php
// Start a session to store bookings
session_start();

// Define a function to calculate the fare
function calculateFare($class) {
    $farePerClass = [
        "I" => 500,  // First Class: $500 per passenger
        "II" => 300, // Second Class: $300 per passenger
        "SL" => 150  // Sleeper Class: $150 per passenger
    ];

    return isset($farePerClass[$class]) ? $farePerClass[$class] : 0;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $trainNumber = $_POST['trainNumber'];
    $passengerName = $_POST['passengerName'];
    $gender = $_POST['gender'];
    $fromCity = $_POST['fromCity'];
    $toCity = $_POST['toCity'];
    $class = $_POST['class'];
    $journeyDate = $_POST['journeyDate'];

    // Validate form inputs
    if (
        empty($trainNumber) || empty($passengerName) || empty($gender) || empty($fromCity) || 
        empty($toCity) || empty($class) || empty($journeyDate)
    ) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit();
    }

    // Calculate the total fare
    $totalFare = calculateFare($class);

    // Initialize session variable to store bookings if not already done
    if (!isset($_SESSION['bookings'])) {
        $_SESSION['bookings'] = [];
    }

    // Add the booking to the session
    $_SESSION['bookings'][] = [
        'trainNumber' => $trainNumber,
        'passengerName' => $passengerName,
        'gender' => $gender,
        'fromCity' => $fromCity,
        'toCity' => $toCity,
        'class' => $class,
        'journeyDate' => $journeyDate,
        'totalFare' => $totalFare
    ];
}

// Generate .txt file for download
if (isset($_GET['download']) && $_GET['download'] == 'true') {
    // Check if bookings exist in session
    if (isset($_SESSION['bookings']) && count($_SESSION['bookings']) > 0) {
        $filename = "bookings_data.txt";
        $fileContent = "Booking Details\n\n";
        
        // Add headers to the text file
        $fileContent .= "Train Number | Passenger Name | Gender | From City | To City | Class | Journey Date | Total Fare ($)\n";
        $fileContent .= str_repeat("-", 100) . "\n";
        
        // Add the session data to the text file
        foreach ($_SESSION['bookings'] as $booking) {
            $fileContent .= "{$booking['trainNumber']} | {$booking['passengerName']} | {$booking['gender']} | {$booking['fromCity']} | {$booking['toCity']} | {$booking['class']} | {$booking['journeyDate']} | {$booking['totalFare']}\n";
        }

        // Set headers to force download
        header('Content-Type: text/plain');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        echo $fileContent;
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 2rem;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 1rem;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 2rem;
            text-decoration: none;
            color: white;
            background: #007bff;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }
        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Booking Details</h1>
    <table>
        <tr>
            <th>Train Number</th>
            <th>Passenger Name</th>
            <th>Gender</th>
            <th>From City</th>
            <th>To City</th>
            <th>Class</th>
            <th>Journey Date</th>
            <th>Total Fare ($)</th>
        </tr>
        <?php
        if (isset($_SESSION['bookings']) && count($_SESSION['bookings']) > 0) {
            foreach ($_SESSION['bookings'] as $booking) {
                echo "<tr>
                        <td>{$booking['trainNumber']}</td>
                        <td>{$booking['passengerName']}</td>
                        <td>{$booking['gender']}</td>
                        <td>{$booking['fromCity']}</td>
                        <td>{$booking['toCity']}</td>
                        <td>{$booking['class']}</td>
                        <td>{$booking['journeyDate']}</td>
                        <td>{$booking['totalFare']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='9' style='text-align:center;'>No bookings available</td></tr>";
        }
        ?>
    </table>

    <!-- Download button -->
    <a href="?download=true" class="download-btn">Download Bookings as .txt</a>

      
    
    <a href="index.html">Go Back to Homepage</a>
</body>
</html>
