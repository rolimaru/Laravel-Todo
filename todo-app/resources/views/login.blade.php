<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh; background-color: #f8f1ef">
        <div class="card shadow" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h5 class="card-title">Login</h5>
                <form id="login-form" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <div class="d-flex justify-content-center mt-3">
                    <p class="fs-6">Done have an account? </p>
                    <a href="/register">
                        Create Account
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function submitForm(event) {
            event.preventDefault(); // Prevent default form submission
            const form = event.target;

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // console.log(passwordConfirm + " and " + password);

            axios.post('/loginSubmit', {
                    email: email,
                    password: password,
                })
                .then(function(response) {
                    // console.log("data: ", response.data);
                    if (response.data.role) {
                        if (response.data.role == 'user') {
                            window.location.href = '/todo'; // Redirect to the /todo route
                        } else {
                            window.location.href = '/admin'; // Redirect to the /todo route

                        }
                    } else {
                        alert('Login failed.');
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });


        }
        document.getElementById('login-form').addEventListener('submit', submitForm);
    </script>
</body>

</html>