<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function overdue()
    {
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        $books = DB::table('vw_overdue_books')
            ->orderByDesc('days_overdue')
            ->get();

        return view('reports.overdue', compact('books'));
    }

    public function mostBorrowed()
    {
        $books = DB::table('vw_most_borrowed_books')
            ->limit(20)
            ->get();

        return view('reports.most_borrowed', compact('books'));
    }

    public function availability()
    {
        $books = DB::table('vw_book_availability')
            ->orderBy('title')
            ->get();

        return view('reports.availability', compact('books'));
    }
}
