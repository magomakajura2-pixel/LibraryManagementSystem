<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\Librarian;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Refresh overdue flags
        Borrowing::query()->active()
            ->where('due_date', '<', now()->toDateString())
            ->where('status', 'borrowed')
            ->update(['status' => 'overdue']);

        $stats = [
            'total_books' => Book::count(),
            'total_members' => Member::count(),
            'active_loans' => Borrowing::whereIn('status', ['borrowed', 'overdue'])->count(),
            'overdue_loans' => Borrowing::where('status', 'overdue')->count(),
            'unpaid_fines' => Fine::where('status', 'unpaid')->sum('amount') ?? 0,
            'total_librarians' => Librarian::count(),
        ];

        $activity = AuditLog::orderByDesc('created_at')->limit(8)->get();

        return view('dashboard.index', compact('stats', 'activity'));
    }
}
