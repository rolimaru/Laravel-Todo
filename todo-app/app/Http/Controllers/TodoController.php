<?php

namespace App\Http\Controllers;

use App\Models\TodoModel;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = TodoModel::all(); // Fetch all todos
        return view('todo.todo', compact('todos')); // Pass todos to the view

    }

    public function create(Request $request)
    {
        // Validate the request
        $request->validate([
            'todo_title' => 'required|string',
            'todo_description' => 'required|string',
        ]);

        // Create a new Todo item using the validated data
        TodoModel::create([
            'todo_title' => $request->todo_title,
            'todo_description' => $request->todo_description,
        ]);

        return "success"; // just returned or refreshed the page
    }
    public function showById(int $id) //simply returning the todo data
    {
        $todo = TodoModel::findOrFail($id); //for server side looping
        return ($todo);
    }


    public function update(int $id, Request $request)
    {
        // Validate the request
        $request->validate([

            'todo_title' => 'required|string',
            'todo_description' => 'required|string',
        ]);

        // Create a new Todo item using the validated data
        TodoModel::findorFail($id)->update([
            'todo_title' => $request->todo_title,
            'todo_description' => $request->todo_description,
        ]);
        return "success"; // just returned or refreshed the page

    }
    //delete
    public function destroy(int $id)
    {
        $todo = TodoModel::findOrfail($id);
        $todo->delete();

        return redirect()->back()->with('status', "Todo is deleted");
    }
}
