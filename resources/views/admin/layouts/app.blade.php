<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang quản trị')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            background-color: #343a40;
            padding-top: 60px;
        }

        .sidebar .nav-link {
            color: #adb5bd;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }

        .main-content {
            margin-left: 240px;
            padding: 2rem;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 240px;
            right: 0;
            z-index: 1030;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3">
        <a href="#" class="text-white text-decoration-none fs-4 mb-4">
            🧸 Gấu Bông Admin
        </a>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link active"><i data-feather="home" class="me-2"></i>Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link"><i data-feather="folder" class="me-2"></i>Danh mục</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link"><i data-feather="box" class="me-2"></i>Sản phẩm</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link"><i data-feather="file-text" class="me-2"></i>Đơn hàng</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link"><i data-feather="users" class="me-2"></i>Người dùng</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.banners.index') }}" class="nav-link"><i data-feather="image" class="me-2"></i>Banner</a>
            </li>
 <a href="{{ route('home') }}" class="nav-link">
    <i data-feather="home" class="me-2"></i>Trang khách
</a>

            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link"><i data-feather="log-out" class="me-2"></i>Đăng xuất</a>
            </li>
        </ul>
    </div>

    <!-- Navbar -->
    {{-- <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h5">Trang quản trị</span>
        </div>
    </nav> --}}

    <!-- Main content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        feather.replace();
    </script>
    @yield('scripts')
</body>

</html>
