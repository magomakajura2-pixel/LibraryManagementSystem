<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('last_name')->orderBy('first_name')->paginate(15);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'membership_no' => 'required|string|max:30|unique:members,membership_no',
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'email' => 'nullable|email|max:150|unique:members,email',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
        ]);

        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Member registered.');
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'membership_no' => 'required|string|max:30|unique:members,membership_no,' . $member->member_id . ',member_id',
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'email' => 'nullable|email|max:150|unique:members,email,' . $member->member_id . ',member_id',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:active,suspended,expired',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'Member updated.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member removed.');
    }

    public function show(Member $member)
    {
        $summary = DB::table('vw_member_summary')->where('member_id', $member->member_id)->first();
        return view('members.show', compact('member', 'summary'));
    }

    public function history(Member $member)
    {
        $history = Borrowing::with('book')
            ->where('member_id', $member->member_id)
            ->orderByDesc('borrow_date')
            ->get();

        return view('members.history', compact('member', 'history'));
    }
}
