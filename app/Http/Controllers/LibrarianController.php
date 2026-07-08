<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Http\Controllers;

use App\Models\Librarian;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LibrarianController extends Controller
{
    public function index()
    {
        $librarians = Librarian::with('user')->orderBy('last_name')->orderBy('first_name')->paginate(15);
        return view('librarians.index', compact('librarians'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('librarian')
            ->with('role')
            ->orderBy('username')
            ->get();
        return view('librarians.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'employee_no' => 'required|string|max:30|unique:librarians,employee_no',
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:30',
            'privilege_level' => 'required|in:librarian,assistant',
        ]);

        Librarian::create($validated);

        return redirect()->route('librarians.index')->with('success', 'Librarian added.');
    }

    public function edit(Librarian $librarian)
    {
        return view('librarians.edit', compact('librarian'));
    }

    public function update(Request $request, Librarian $librarian)
    {
        $validated = $request->validate([
            'employee_no' => 'required|string|max:30|unique:librarians,employee_no,' . $librarian->librarian_id . ',librarian_id',
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:30',
            'privilege_level' => 'required|in:librarian,assistant',
            'status' => 'required|in:active,inactive',
        ]);

        $librarian->update($validated);

        return redirect()->route('librarians.index')->with('success', 'Librarian updated.');
    }

    public function destroy(Librarian $librarian)
    {
        $librarian->delete();
        return redirect()->route('librarians.index')->with('success', 'Librarian removed.');
    }
}
