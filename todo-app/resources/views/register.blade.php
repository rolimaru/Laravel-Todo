<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center " style="height: 100vh; background-color: #f8f1ef;">
        <div class="card shadow" style="width: 100%; max-width: 500px;">
            <div class="card-body">
                <h5 class="card-title">Register</h5>
                <form id="register-form" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                    <div class="d-flex justify-content-end mt-3 "> <i>back to </i> <span class="fs-2 font-weight-bold mx-3"><a href="/"> Login </a></span>
                    </div>
                </form>
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

            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password-confirm').value;

            // console.log(passwordConfirm + " and " + password);

            if (passwordConfirm == password) {
                axios.post('/registerSubmit', {
                        username: username,
                        email: email,
                        password: password,
                    })
                    .then(function(response) {
                        // console.log("success")
                        if (confirm("Account Created try to login")) {
                            console.log("nice");
                        }
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                        alert('An error occurred.');
                    });
            } else {
                console.log("unmatched password");
            }

        }
        document.getElementById('register-form').addEventListener('submit', submitForm);
    </script>
</body>

</html>