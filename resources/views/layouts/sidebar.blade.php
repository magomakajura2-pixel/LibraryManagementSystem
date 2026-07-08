@php
$role = auth()->user()->role?->role_name;
@endphp
<aside class="sidebar" id="sidebar">
    <div class="sidebar-heading">Main</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard</a>
        </li>
    </ul>

    <div class="sidebar-heading">Catalogue</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('books.index') ? 'active' : '' }}" href="{{ route('books.index') }}">
                <i class="bi bi-book"></i> Books</a>
        </li>
        @if(in_array($role, ['admin','librarian']))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('books.create') ? 'active' : '' }}" href="{{ route('books.create') }}">
                <i class="bi bi-plus-circle"></i> Add Book</a>
        </li>
        @endif
    </ul>

    @if(in_array($role, ['admin','librarian']))
    <div class="sidebar-heading">People</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('members.index') ? 'active' : '' }}" href="{{ route('members.index') }}">
                <i class="bi bi-people"></i> Members</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('members.create') ? 'active' : '' }}" href="{{ route('members.create') }}">
                <i class="bi bi-person-plus"></i> Add Member</a>
        </li>
        @if($role === 'admin')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('librarians.*') ? 'active' : '' }}" href="{{ route('librarians.index') }}">
                <i class="bi bi-person-badge"></i> Librarians</a>
        </li>
        @endif
    </ul>
    @endif

    <div class="sidebar-heading">Circulation</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('borrowings.index') ? 'active' : '' }}" href="{{ route('borrowings.index') }}">
                <i class="bi bi-arrow-right-circle"></i> Active Loans</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('borrowings.create') ? 'active' : '' }}" href="{{ route('borrowings.create') }}">
                <i class="bi bi-box-arrow-up-right"></i> Issue Book</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('returns.create') ? 'active' : '' }}" href="{{ route('returns.create') }}">
                <i class="bi bi-box-arrow-in-down-left"></i> Return Book</a>
        </li>
    </ul>

    @if(in_array($role, ['admin','librarian']))
    <div class="sidebar-heading">Reports</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.overdue') ? 'active' : '' }}" href="{{ route('reports.overdue') }}">
                <i class="bi bi-exclamation-triangle"></i> Overdue Books</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.most_borrowed') ? 'active' : '' }}" href="{{ route('reports.most_borrowed') }}">
                <i class="bi bi-bar-chart"></i> Most Borrowed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reports.availability') ? 'active' : '' }}" href="{{ route('reports.availability') }}">
                <i class="bi bi-stack"></i> Availability</a>
        </li>
    </ul>
    @endif
</aside>
