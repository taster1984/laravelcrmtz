<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            min-width: 200px;
            max-width: 200px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 60px;
            background-color: #343a40;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 10px 15px;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            border-radius: 5px;
        }
        .content {
            margin-left: 200px;
            padding: 20px;
            flex: 1;
        }
        .topbar {
            height: 60px;
            position: fixed;
            left: 200px;
            right: 0;
            top: 0;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            padding: 0 20px;
            z-index: 1000;
        }
    </style>
    @stack('styles')
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center py-3">Admin Panel</h4>
    <a href="{{ route('admin.tickets.index') }}" class="@if(request()->is('admin/tickets*')) active @endif">
        <i class="fas fa-ticket-alt me-2"></i> Tickets
    </a>
</div>

<!-- Topbar -->
<div class="topbar d-flex justify-content-end align-items-center">
    <span>
        Logged in as <strong>{{ auth()->user()->name ?? 'Manager' }}</strong>
    </span>
    <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
        @csrf
        <button class="btn btn-sm btn-outline-secondary" type="submit">Logout</button>
    </form>
</div>
<!-- Main content -->
<div class="content mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <br><br>
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
