<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Todo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
            /* Position below the kebab icon */
            right: 0;
            /* Align to the right edge of the kebab icon */
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
    <div class="container centered-form">
        <div class="form-container">
            <h4>Add new Todo</h4>
            <form id="todo-form">
                @csrf
                <div class="form-group">
                    <label for="todo_title">Title:</label>
                    <input type="text" class="form-control" name="todo_title" id="todo_title" required>
                </div>
                <div class="form-group">
                    <label for="todo_description">Description:</label>
                    <input type="text" class="form-control" name="todo_description" id="todo_description" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Add Todo</button>
            </form>
        </div>
    </div>
    <div class="mt-2 px-5 pt-5 row">
        <div class="card-title">
            <h1>Todos</h1>
        </div>
        @foreach ($todos as $todo)
        <div class="card col-md-2 p-4 m-2 position-relative">
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
        </div>
        @endforeach
    </div>

    <script>
        //inserting new Todo


        // const csrfToken = document.querySelector('input[name="_token"]').value;

        function submitForm(event) {
            event.preventDefault(); // Prevent default form submission
            const form = event.target;

            const title = document.getElementById('todo_title').value;
            const description = document.getElementById('todo_description').value;

            axios.post('/add', {
                    todo_title: title,
                    todo_description: description
                })
                .then(function(response) {
                    // Clear form fields after successful submission
                    form.reset();
                    alert('Todo Created Successfully!');
                    window.location.reload();

                })
                .catch(function(error) {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
        }

        // Attach event listener to the form
        document.getElementById('todo-form').addEventListener('submit', editForm);


        function Card(id) {
            alert("clicked " + id);
        }

        function toggleDropdown(event, menuId) {
            const menu = document.getElementById(menuId);
            menu.classList.toggle('show');
            event.stopPropagation(); // Prevent event from bubbling up
        }

        function fetchTodoByID(id) {
            axios.get('/show/' + id).then((response) => {
                console.log("data: ", response.data);
                const todo = response.data;
                document.getElementById('todo_title').value = todo.todo_title;
                document.getElementById('todo_description').value = todo.todo_description;
                document.getElementById('todo_id').value = todo.id;
                document.getElementById('form-title').innerText = 'Edit Todo';
            })
        }

        function editForm(event) {
            //showing Data

            // window.history.pushState({}, '', `/edit/${id}`);

            event.preventDefault(); // Prevent default form submission
            const form = event.target;

            const title = document.getElementById('todo_title').value;
            const description = document.getElementById('todo_description').value;

            axios.patch('/edit' + id, {
                    todo_title: title,
                    todo_description: description
                })
                .then(function(response) {
                    // Clear form fields after successful submission
                    form.reset();
                    alert('Todo Created Successfully!');
                    window.location.reload();

                })
                .catch(function(error) {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
        }

        function deleteItem(id) {
            if (confirm(`Are you sure you want to delete Todo #${id}?`)) {
                axios.get('/delete/' + id).then((response) => {
                    console.log("deleted");
                    // window.location.reload();
                })
            }
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
    </script>
</body>

</html>