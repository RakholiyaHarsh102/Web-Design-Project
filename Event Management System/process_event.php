<?php
// Start a session to store events
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventDescription = $_POST['eventDescription'];
    $status = $_POST['status'];
    $participants = $_POST['participants'];

    // Validate form inputs
    if (empty($eventName) || empty($eventDate) || empty($eventDescription) || empty($status) || empty($participants)) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit();
    }

    // Initialize session variable to store events if not already done
    if (!isset($_SESSION['events'])) {
        $_SESSION['events'] = [];
    }

    // Add the event to the session
    $_SESSION['events'][] = [
        'name' => $eventName,
        'date' => $eventDate,
        'description' => $eventDescription,
        'status' => $status,
        'participants' => $participants,
    ];
}


// Function to generate the event data in text format
function generateEventsText() {
    $output = "";
    if (isset($_SESSION['events']) && count($_SESSION['events']) > 0) {
        foreach ($_SESSION['events'] as $event) {
            $output .= "Event Name: {$event['name']}\n";
            $output .= "Date: {$event['date']}\n";
            $output .= "Description: {$event['description']}\n";
            $output .= "Status: {$event['status']}\n";
            $output .= "No. of Participants: {$event['participants']}\n";
            $output .= str_repeat("-", 40) . "\n";
        }
    } else {
        $output .= "No events added yet.\n";
    }
    return $output;
}

// Trigger file download if 'Download Events' button is clicked
if (isset($_GET['download'])) {
    $eventsText = generateEventsText();
    $filename = "events_list.txt";

    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo $eventsText;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Listings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 2rem;
        }
        h1 {
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background: #e4e4e4;
            margin: 0.5rem 0;
            padding: 1rem;
            border-radius: 4px;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 1rem;
            text-decoration: none;
            color: white;
            background: #007bff;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }
        a:hover {
            background: #0056b3;
        }
        .download-btn {
            display: block;
            text-align: center;
            margin-top: 2rem;
            text-decoration: none;
            color: white;
            background: #28a745;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }
        .download-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <h1>Event Listings</h1>
    <ul>
        <?php
        if (isset($_SESSION['events']) && count($_SESSION['events']) > 0) {
            foreach ($_SESSION['events'] as $event) {
                echo "<li>
                        <strong>Event Name:</strong> {$event['name']}<br>
                        <strong>Date:</strong> {$event['date']}<br>
                        <strong>Description:</strong> {$event['description']}<br>
                        <strong>Status:</strong> {$event['status']}<br>
                        <strong>No. of Participants:</strong> {$event['participants']}
                      </li>";
            }
        } else {
            echo "<li>No events added yet.</li>";
        }
        ?>
    </ul>
    <a href="?download=true" class="download-btn">Download Events as .txt</a>

    <a href="index.html">Go Back to Homepage</a>
</body>
</html>
