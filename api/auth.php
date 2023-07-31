<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'user' && $password === '123') {
        $authenticationResult = true; // Replace this with your actual authentication logic
    } else {
        $authenticationResult = false; // Replace this with your actual authentication logic
    }

    // Handle the redirection based on authentication result
    if ($authenticationResult) {
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}

// If the request method is not POST (e.g., user manually accessed the URL)
http_response_code(405); // Method Not Allowed
header('Content-Type: application/json');
echo json_encode(['error' => 'Method not allowed']);
