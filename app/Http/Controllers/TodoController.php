<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
     use AuthorizesRequests;
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())->latest()->get();
        return view('dashboard', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'ToDo berhasil ditambahkan!');
    }

    public function edit(Todo $todo)
    {
        // optional: policy check bisa ditambah nanti
        return view('edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        // Cek apakah todo milik user yang sedang login
        if ($todo->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $todo->update($request->only(['title', 'description', 'is_done']));

        return redirect()->route('dashboard')->with('success', 'ToDo berhasil diperbarui!');
    }

    public function destroy(Todo $todo)
    {
        if ($todo->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $todo->delete();

        return redirect()->route('dashboard')->with('success', 'ToDo berhasil dihapus!');
    }
}
