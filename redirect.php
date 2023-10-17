<!DOCTYPE html>
<html>

<body>

        <?php
                $user = 'Login';
                echo '<h1> hi </h1>';
                echo  "hello {$user}";
                echo '</br>Good Day ' . $user . '1';
                ?></h1>
        <p>LOGGED IN</p>

        <!-- <form >
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password</label><br>
            <input type="text" id="password" name="password">
            <input id='submitForm' type="submit" value="Submit">
        </form> -->

<!--     
        <script>
            document.getElementById('submitForm').addEventListener('click', function(event) {
            // This function will be executed when the submit button is clicked
            event.preventDefault(); // Prevent the default form submission behavior

            // Get the form data
            var formData = new FormData();
            formData.append('username', document.getElementById("username").value);
            formData.append('password', document.getElementById("password").value);

            // Send the form data to the server using fetch API
            fetch('http://localhost/project/api/auth.php', {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Assuming the server responds with JSON data
            })
            .then(function(data) {
                // Handle the response data from the server here
            })
            .catch(function(error) {
                // Handle errors here
            });
        });
        </script>  -->
      

</body>

</html>