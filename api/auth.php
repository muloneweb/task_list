<?php
// Logging a message
error_log("log  AAAAAAAAA");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data

    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "root1#1234!";
    $database = "test";

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $password = $conn->real_escape_string($_POST['password'] ?? '');
    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    // while ($row = $result->fetch_assoc()) {
    //     // Log each row or the necessary data here
    //     error_log(print_r($row, true)); // Assuming you want to log the array representation of each row
    // }
    if ($result->num_rows > 0) {
        $authenticationResult = true;
        $response = array('success' => true, 'message' => 'Authentication successful', 'user' => $username);
        echo json_encode($response);
      //  header("Location: http://localhost/project/redirect.php");
        // exit();
        // Output data of each row
        // while ($row = $result->fetch_assoc()) {
        //     echo "id: " . $row["id"] . " - Username: " . $row["username"] . " - Email: " . $row["email"] . "<br>";
        // }

    } else {



        error_log("Username: " . $username);
        error_log("Password: " . $password);
        // SQL query to insert data into the table
        $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            error_log("Data inserted successfully. Username: " . $username);
            echo "Data inserted successfully";
        } else {
            if (!$stmt->execute()) {
                error_log("Error: " . $stmt->error);
            }
        }
    }
    $stmt->close(); // Close the statement

    // Handling the redirection based on the authentication result
    $conn->close(); // Close the connection

    // header("Location: http://localhost/project/redirect.php");
    exit();
}

// If the request method is not POST (e.g., user manually accessed the URL)
http_response_code(405); // Method Not Allowed
header('Content-Type: application/json');
echo json_encode(['error' => 'Method not allowed']);
