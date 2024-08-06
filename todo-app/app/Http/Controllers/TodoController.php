<?php

namespace App\Http\Controllers;

use App\Models\TodoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $todos = TodoModel::where('user_id', $user->id)->get();
        return view('todo.todo', [
            'todos' => $todos,
            'username' => $user->name
        ]); // Pass todos to the view

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
            'todo_status' => 1,
            'user_id' => Auth::id(),
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
    public function markAsDone(int $id, Request $request)
    {
        TodoModel::findorFail($id)->update(
            [
                'todo_status' => 0,
            ]
        );
    }
    public function markAsTodo(int $id, Request $request)
    {
        TodoModel::findorFail($id)->update(
            [
                'todo_status' => 1,
            ]
        );
    }
    //delete
    public function destroy(int $id)
    {
        $todo = TodoModel::findOrfail($id);
        $todo->delete();

        // return redirect()->back()->with('status', "Todo is deleted");
        return response()->json(['success' => true]);
    }
}
