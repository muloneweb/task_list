<!DOCTYPE html>
<html>

<body>
    <h2>Your list</h2>
    <div id='list'>


    </div>
    <button id='newTask'>Add Task</button>
    <?php
    // Check if the 'user' cookie is set
    if (isset($_COOKIE['user'])) {
        $username = $_COOKIE['user'];
        echo "Welcome back, " . $username . "!";
    ?>
        <script>
            async function addTasks() {
                fetch('http://localhost/project/api/tasks.php', {
                    method: 'POST',
                    body: '',
                })
            }


            let addtasksBtn = document.getElementById('newTask');
            addtasksBtn.addEventListener('click', addTasks);

            async function getTasks() {
                let request = await fetch('http://localhost/project/api/auth.php')
                if (request.ok) {
                    let data = await request.json()
                    console.log(data.ok, 'LLL')
                    let tasks = document.getElementById('list');


                    for (let task of data) { // Changed 'taks' to 'task' and used 'data' instead of 'tasks'
                        let newDiv = document.createElement('div');
                        newDiv.textContent = task; // Changed 'tasts' to 'newDiv' and added 'textContent'
                        tasks.appendChild(newDiv); // Changed 'tasts' to 'tasks'
                    }

                }
            }
            getTasks()
        </script>
    <?php
    } else {
        header("Location: http://localhost/project");
        exit();
    }
    ?>







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