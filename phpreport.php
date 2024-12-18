<?php
header("Content-Type: application/json; charset=UTF-8");

// Database configuration
$host = "localhost";
$db_name = "modulecoders_psdiag";
$username = "modulecoders_psuser";
$password = "PSdiag@123";


// Create a connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// SQL query to fetch data
$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    $users = [];

    // Fetch all data
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // Return the data as JSON
    echo json_encode($users);
} else {
    echo json_encode([]);
}

// Close the connection
$conn->close();
?>

