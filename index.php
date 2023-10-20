<!DOCTYPE html>
<html>

<body>


    <div style='width: 100%; display: inline-flex; justify-content: center;'>
        <div>
            <h1 id="welcomeMessage">Please Login</h1>
            <!-- <p>LOGIN</p> -->
            <!-- <?php
                    echo '<h1 id="welcomeMessage">Please Login</h1>';
                    ?> -->
            <div>
                <form>
                    <label for="username">Username</label><br>
                    <input type="text" id="username" name="username"><br>
                    <label for="password">Password</label><br>
                    <input type="text" id="password" name="password">
                </form>
                <input id='submitForm' style='width: 100%; margin-top: 8px' type="submit" value="Submit">
            </div>
        </div>
    </div>


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
                    if (response.redirected) {
                        const redirectUrl = response.url;
                        window.location.href = redirectUrl;
                    }
                    return response.json()
                })
                .then(function(data) {
                    console.log(data)
                    let user = data.user
                    // console.log(user, '<--- user')
                    // document.getElementById('welcomeMessage').innerText = 'Welcome Back ' + user;
                    if (data.ok) {
               
                        let user = data.user
                      
                    }
                    // Handle the response data from the server here
                })
                .catch(function(error) {
                    // Handle errors here
                });
        });
    </script>


</body>

</html>