<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Todo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .centered-form {
            display: flex;
            justify-content: center;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            margin-top: 20px;
        }

        .kebab-menu {
            cursor: pointer;
            font-size: 24px;
            display: inline-block;
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            min-width: 160px;
            z-index: 1000;
            padding: 0;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            padding: 10px 15px;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="head d-flex justify-content-end">

        <div class="mx-5 ">
            <div style="font-size: 50px ">
                <i class="bi bi-person-circle"></i>
                {{ $username}}

            </div>
            <div class="d-flex justify-content-end">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>

        </div>
    </div>

    <div class="container  ">
        <div class="form-container">
            <h4 id="form-title">Add new Todo</h4>
            <form id="todo-form">
                @csrf
                <input type="hidden" id="todo_id">
                <div class="form-group">
                    <label for="todo_title">Title:</label>
                    <input type="text" class="form-control" name="todo_title" id="todo_title" required>
                </div>
                <div class="form-group">
                    <label for="todo_description">Description:</label>
                    <input type="text" class="form-control" name="todo_description" id="todo_description" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit Todo</button>
            </form>

        </div>

    </div>

    <div class=" row mx-3">
        <div class="col-md-6">
            <div class=" mt-2  pt-5 row">

                <div class="card-title">
                    <h1>Todos</h1>
                </div>
                @foreach ($todos as $todo)
                @if ($todo->todo_status == 1)
                <div class="card col-md-4 p-4 m-2 position-relative shadow">
                    <div class="container d-flex justify-content-end">
                        <div class="position-relative">
                            <span class="kebab-menu" onclick="toggleDropdown(event, 'dropdown-menu-{{ $todo->id }}')">
                                &#8226;&#8226;&#8226;
                            </span>
                            <div class="dropdown-menu" id="dropdown-menu-{{ $todo->id }}">
                                <div class="dropdown-item" onclick="fetchTodoByID(`{{ $todo->id }}`)">Edit</div>
                                <div class="dropdown-item" onclick="deleteItem(`{{ $todo->id }}`)">Delete</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-head flex" onclick="Card('{{ $todo->id }}')">
                        <h4>{{ $todo->todo_title }}</h4>
                    </div>
                    <div class="body">
                        <h6>{{ $todo->todo_description }}</h6>
                    </div>
                    <div class="footer mt-4 d-flex justify-content-end">
                        <button class="btn btn-success" style="width: 65px; height: 40px;" onclick="markAsDone(`{{ $todo->id }}`)">
                            Done
                        </button>
                    </div>
                </div>
                @endif
                @endforeach
                <!-- Dones -->
            </div>
        </div>
        <!-- Dones -->
        <div class="col-md ">
            <div class=" mt-2 pt-5 row">

                <div class="card-title ">
                    <h1>Done Todos</h1>
                </div>
                @foreach ($todos as $todo)
                @if ($todo->todo_status == 0)

                <div class="card col-md-4 p-4 m-2 position-relative shadow">
                    <div class="container d-flex justify-content-end">
                        <div class="position-relative">
                            <span class="kebab-menu" onclick="toggleDropdown(event, 'dropdown-menu-{{ $todo->id }}')">
                                &#8226;&#8226;&#8226;
                            </span>
                            <div class="dropdown-menu" id="dropdown-menu-{{ $todo->id }}">
                                <!-- <div class="dropdown-item" onclick="fetchTodoByID(`{{ $todo->id }}`)">Edit</div> -->
                                <div class="dropdown-item" onclick="deleteItem(`{{ $todo->id }}`)">Delete</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-head flex" onclick="Card('{{ $todo->id }}')">
                        <h4>{{ $todo->todo_title }}</h4>
                    </div>
                    <div class="body">
                        <h6>{{ $todo->todo_description }}</h6>
                    </div>
                    <div class="footer mt-4 d-flex justify-content-end">
                        <button class="btn btn-info text-bold" style="width: 130px; height: 40px;" onclick="markAsTodo(`{{ $todo->id }}`)">
                            back to Todo
                        </button>

                    </div>
                </div>
                @endif
                @endforeach
                <!-- Dones -->
            </div>
        </div>
    </div>
</body>


<script>
    // Function to handle create and edit form submission
    function submitForm(event) {
        event.preventDefault(); // Prevent default form submission
        const form = event.target;

        const title = document.getElementById('todo_title').value;
        const description = document.getElementById('todo_description').value;
        const id = document.getElementById('todo_id').value;

        // Determine if we are creating a new todo or editing an existing one
        const url = id ? `/edit/${id}` : '/add';
        const method = id ? 'patch' : 'post';

        axios({
                method: method,
                url: url,
                data: {
                    todo_title: title,
                    todo_description: description
                }
            })
            .then(function(response) {
                // Clear form fields after successful submission
                form.reset();
                document.getElementById('todo_id').value = '';
                document.getElementById('form-title').innerText = 'Add new Todo';
                alert('Todo ' + (id ? 'Updated' : 'Created') + ' Successfully!');
                window.location.reload();
            })
            .catch(function(error) {
                console.error('Error:', error);
                alert('An error occurred.');
            });
    }

    // Attach event listener to the form
    document.getElementById('todo-form').addEventListener('submit', submitForm);

    // Function to show the edit form with the current todo details
    function fetchTodoByID(id) {
        axios.get('/show/' + id).then((response) => {
            console.log("data: ", response.data);
            const todo = response.data;
            document.getElementById('todo_title').value = todo.todo_title;
            document.getElementById('todo_description').value = todo.todo_description;
            document.getElementById('todo_id').value = todo.id;
            document.getElementById('form-title').innerText = 'Edit Todo';
        }).catch(function(error) {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    }

    function deleteItem(id) {
        if (confirm(`Are you sure you want to delete Todo #${id}?`)) {
            axios.delete(`/delete/${id}`).then((response) => {
                console.log("deleted");
                window.location.reload();
            }).catch(function(error) {
                console.error('Error:', error);
                alert('An error occurred.');
            });
        }
    }


    function toggleDropdown(event, menuId) {
        const menu = document.getElementById(menuId);
        menu.classList.toggle('show');
        event.stopPropagation(); // Prevent event from bubbling up
    }

    // Close the dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const menus = document.querySelectorAll('.dropdown-menu');
        menus.forEach(menu => {
            if (!menu.contains(event.target) && !event.target.classList.contains('kebab-menu')) {
                menu.classList.remove('show');
            }
        });
    });

    function markAsDone(id) {
        // alert("clicked" + id);
        axios.patch(`/markAsDone/${id}`).then((reponse) => {
            console.log("success");
            window.location.reload()
        }).catch((err) => {
            console.log("Error", err);
        })
    }

    function markAsTodo(id) {
        // alert("clicked" + id);
        axios.patch(`/markAsTodo/${id}`).then((reponse) => {
            console.log("success");
            window.location.reload()
        }).catch((err) => {
            console.log("Error", err);
        })
    }
</script>

</html>