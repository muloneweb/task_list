<?php
// Logging a message
error_log("SERVER");


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
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
    if (isset($_COOKIE['user'])) {
        $username = $_COOKIE['user'];
      
        // echo "Value is: " . $_COOKIE['user'];
        $stmt = $conn->prepare("SELECT * FROM data WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $response = array();
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
    
        // Send JSON response
        echo json_encode($response);
        exit();
    }

}


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
        $cookie_name = "user";
        $cookie_value = "$username";
        $expiration = time() + 3600; // current time + 1 hour
        $path = "/"; // The cookie will be available within the entire domain
        $domain = "localhost"; // Set the domain for which the cookie is available
        $secure = false; // Whether the cookie should only be transmitted over a secure HTTPS connection
        $http_only = true; // Whether the cookie is accessible only through the HTTP protocol
        
        setcookie($cookie_name, $cookie_value, $expiration, $path, $domain, $secure, $http_only);
        
        // Send JSON response
        echo json_encode($response);
        
        // Redirect to dashboard page after setting the cookie and sending JSON response
        header("Location: http://localhost/project/dashboard.php");
        exit();
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
            $cookie_name = "user";
            $cookie_value = "John Doe";
            $expiration = time() + 3600; // current time + 1 hour
            $path = "/"; // The cookie will be available within the entire domain
            $domain = "127.0.0.1"; // Set the domain for which the cookie is available
            $secure = false; // Whether the cookie should only be transmitted over a secure HTTPS connection
            $http_only = true; // Whether the cookie is accessible only through the HTTP protocol

            setcookie($cookie_name, $cookie_value, $expiration, $path, $domain, $secure, $http_only);

            // Check if the cookie is set
            if (isset($_COOKIE[$cookie_name])) {
                echo "Cookie '" . $cookie_name . "' is set.<br>";
                echo "Value is: " . $_COOKIE[$cookie_name];
            } else {
                echo "Cookie named '" . $cookie_name . "' is not set!";
            }
            header("Location: http://localhost/project/dashboard.php");
        } else {
            if (!$stmt->execute()) {
                error_log("Error: " . $stmt->error);
            }
        }
    }
    $stmt->close(); // Close the statement

    // Handling the redirection based on the authentication result
    $conn->close(); // Close the connection


    exit();
}

// If the request method is not POST (e.g., user manually accessed the URL)
http_response_code(405); // Method Not Allowed
header('Content-Type: application/json');
echo json_encode(['error' => 'Method not allowed']);
