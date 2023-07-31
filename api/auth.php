<?php

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'user' && $password === '123') {
        $response = ['status' => 'success', 'message' => 'Authentication successful'];
    } else {
        $response = ['status' => 'error', 'message' => 'Authentication failed'];
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle other HTTP methods (if needed)
    http_response_code(405); // Method Not Allowed
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Method not allowed']);
}
?>
