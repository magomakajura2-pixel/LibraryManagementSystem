<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\BookReturn;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\Librarian;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function create()
    {
        // Refresh overdue flags
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        $loans = Borrowing::query()->active()
            ->with(['book', 'member'])
            ->orderBy('due_date')
            ->get();

        $librarians = Librarian::where('status', 'active')->orderBy('last_name')->get();

        return view('returns.create', compact('loans', 'librarians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrowing_id' => 'required|exists:borrowings,borrowing_id',
            'book_condition' => 'required|in:good,damaged,lost',
            'received_by' => 'nullable|exists:librarians,librarian_id',
        ]);

        $borrowing = Borrowing::with(['book', 'member'])->findOrFail($validated['borrowing_id']);

        if (!$borrowing->isOpen()) {
            return back()->with('error', 'No open loan found for that borrowing id.')->withInput();
        }

        try {
            DB::transaction(function () use ($validated, $borrowing) {
                $returnDate = now()->toDateString();
                $condition = $validated['book_condition'];

                BookReturn::create([
                    'borrowing_id' => $borrowing->borrowing_id,
                    'return_date' => $returnDate,
                    'book_condition' => $condition,
                    'received_by' => $validated['received_by'] ?? null,
                ]);

                $status = $condition === 'lost' ? 'lost' : 'returned';
                $borrowing->update(['status' => $status]);

                $book = $borrowing->book;
                $book->increment('available_copies');
                if ($book->status === 'unavailable' && $book->available_copies > 0) {
                    $book->update(['status' => 'available']);
                }

                // Fine calculation for overdue
                if ($returnDate > $borrowing->due_date && $condition !== 'lost') {
                    $daysLate = (int) now()->diffInDays($borrowing->due_date);
                    $rate = (float) SystemSetting::value('fine_per_day', 0);
                    Fine::create([
                        'borrowing_id' => $borrowing->borrowing_id,
                        'member_id' => $borrowing->member_id,
                        'amount' => $daysLate * $rate,
                        'reason' => "{$daysLate} day(s) overdue",
                        'status' => 'unpaid',
                        'issued_date' => $returnDate,
                    ]);
                }

                AuditLog::create([
                    'actor' => auth()->user()->username ?? 'system',
                    'action' => 'INSERT',
                    'table_name' => 'returns',
                    'record_id' => $borrowing->borrowing_id,
                    'details' => "Loan {$borrowing->borrowing_id} returned",
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'The return could not be recorded.')->withInput();
        }

        return redirect()->route('returns.create')->with('success', 'Return recorded successfully.');
    }
}
