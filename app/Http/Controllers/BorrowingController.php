<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Librarian;
use App\Models\Member;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function index()
    {
        // Refresh overdue flags
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        $loans = Borrowing::query()->active()
            ->with(['book', 'member', 'librarian'])
            ->orderBy('due_date')
            ->paginate(15);

        return view('borrowings.index', compact('loans'));
    }

    public function create()
    {
        $books = Book::where('available_copies', '>', 0)
            ->where('status', 'available')
            ->orderBy('title')
            ->get();
        $members = Member::where('status', 'active')->orderBy('last_name')->orderBy('first_name')->get();
        $librarians = Librarian::where('status', 'active')->orderBy('last_name')->get();
        $defaultLoanDays = (int) SystemSetting::value('loan_period', 14);

        return view('borrowings.create', compact('books', 'members', 'librarians', 'defaultLoanDays'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,book_id',
            'member_id' => 'required|exists:members,member_id',
            'librarian_id' => 'nullable|exists:librarians,librarian_id',
            'loan_days' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($validated['book_id']);
        $member = Member::findOrFail($validated['member_id']);

        if ($book->available_copies < 1) {
            return back()->with('error', 'No copies available to borrow.')->withInput();
        }

        if (!$member->isActive()) {
            return back()->with('error', 'Member is not active.')->withInput();
        }

        try {
            DB::transaction(function () use ($validated, $book, $member) {
                $borrowing = Borrowing::create([
                    'book_id' => $validated['book_id'],
                    'member_id' => $validated['member_id'],
                    'librarian_id' => $validated['librarian_id'] ?? null,
                    'borrow_date' => now()->toDateString(),
                    'due_date' => now()->addDays((int) $validated['loan_days'])->toDateString(),
                    'status' => 'borrowed',
                ]);

                $book->decrement('available_copies');
                if ($book->available_copies === 0) {
                    $book->update(['status' => 'unavailable']);
                }

                AuditLog::create([
                    'actor' => auth()->user()->username ?? 'system',
                    'action' => 'INSERT',
                    'table_name' => 'borrowings',
                    'record_id' => $borrowing->borrowing_id,
                    'details' => "Book {$book->book_id} issued to member {$member->member_id}",
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'The operation could not be completed.')->withInput();
        }

        return redirect()->route('borrowings.index')->with('success', 'Book issued successfully.');
    }
}
