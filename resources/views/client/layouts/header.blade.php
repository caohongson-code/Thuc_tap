<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-success ftco-navbar-light" id="ftco-navbar">

  <div class="container">
    <a class="navbar-brand" href="/"><img src="https://bemori.vn/wp-content/uploads/2024/06/Logo-trang-chu-Mobile-1.webp" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ftco-nav"
      aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="oi oi-menu"></span> Menu
    </button>

    <div class="collapse navbar-collapse" id="ftco-nav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active"><a href="/" class="nav-link">Home</a></li>
        <li class="nav-item active"><a href="/danhmuc" class="nav-link">Danh mục</a></li>
        <li class="nav-item"><a href="/about" class="nav-link">About</a></li>
        <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
        <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
        <li class="nav-item cta cta-colored">
          <a href="/giohang" class="nav-link">Giỏ hàng <span class="icon-shopping_cart"></span></a>
        </li>

        {{-- Kiểm tra đăng nhập --}}
        @if(!empty($_SESSION['user']))

<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    {{ $_SESSION['user']['name'] ?? 'User' }}
  </a>
  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
    <li><a class="dropdown-item" href="/lich-su-don-hang">Lịch sử đơn hàng</a></li>
    <li><a class="dropdown-item" href="/logout">Đăng xuất</a></li>
  </ul>
</li>

        @else
        <li class="nav-item active">
          <div class="container mt-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký</button>
          </div>
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>

{{-- Hiển thị thông báo sau redirect --}}


<!-- Modal Đăng ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Tạo tài khoản mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng">X</button>
      </div>

      <div class="modal-body">
        <form action="/register" method="post">
          <div class="mb-3">
            <label for="fullname" class="form-label">Họ và tên:</label>
            <input type="text" class="form-control" id="fullname" name="name" value="{{ $_SESSION['data']['name'] ?? '' }}" required>
          </div>

          <div class="mb-3">
            <label for="registerEmail" class="form-label">Email:</label> 
            <input type="email" class="form-control" id="registerEmail" name="email" value="{{ $_SESSION['data']['email'] ?? '' }}" required>
          </div>

          <div class="mb-3">
            <label for="registerPassword" class="form-label">Mật khẩu:</label>
            <input type="password" class="form-control" id="registerPassword" name="password" required>
          </div>

          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Xác nhận mật khẩu:</label>
            <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
          </div>

          <div class="mb-3">
            <label for="dien_thoai" class="form-label">Số điện thoại:</label>
            <input type="text" class="form-control" id="dien_thoai" name="dien_thoai" value="{{ $_SESSION['data']['dien_thoai'] ?? '' }}" required>
          </div>  

          <div class="mb-3">
            <label for="dia_chi" class="form-label">Địa chỉ:</label>
            <input type="text" class="form-control" id="dia_chi" name="dia_chi" value="{{ $_SESSION['data']['dia_chi'] ?? '' }}" required>
          </div>

          <div class="mb-3">
            <label for="thanhpho" class="form-label">Thành phố:</label>
            <input type="text" class="form-control" id="thanhpho" name="thanhpho" value="{{ $_SESSION['data']['thanhpho'] ?? '' }}" required>
          </div>

          <button type="submit" class="btn btn-success w-100">Đăng ký</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- Modal đăng nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Đăng nhập tài khoản</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng">X</button>
      </div>

      <div class="modal-body">
        <form action="/login" method="post">
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

        <hr>
        <p class="text-center">
          Khách hàng mới? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Tạo tài khoản</a><br>
          <a href="#">Khôi phục mật khẩu</a>
        </p>
      </div>

    </div>
  </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Điều khiển modal hiển thị sau khi đăng ký --}}
@if(isset($_SESSION['msg']))
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="toastNotify" class="toast align-items-center text-white {{ $_SESSION['status'] ? 'bg-success' : 'bg-danger' }} border-0 show" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          {{ $_SESSION['msg'] }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close">X</button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      @if(isset($_SESSION['action']) && $_SESSION['action'] === 'login')
        // 👇 Nếu cần hiển thị modal đăng nhập
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
      @elseif(!$_SESSION['status'])
        // 👇 Nếu là lỗi đăng ký → hiện modal đăng ký
        const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
        registerModal.show();
      @endif
    });
  </script>

  @php
    unset($_SESSION['msg']);
    unset($_SESSION['status']);
    unset($_SESSION['action']);
    unset($_SESSION['data']);
  @endphp
@endif


<!-- Banner -->
{{-- <section id="home-section" class="hero">
  <div class="home-slider owl-carousel">
    @foreach($banners as $product)
      <div class="slider-item" style="background-image: url('{{ file_url($product['anh']) }}');"></div>
    @endforeach
  </div>
  
</section> --}}
