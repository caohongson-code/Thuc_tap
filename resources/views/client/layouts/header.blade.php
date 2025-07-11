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
        <li class="nav-item active"><a href="/" class="nav-link">Trang chủ</a></li>
        @if(isset($topCategories))
            @foreach($topCategories as $cat)
                <li class="nav-item"><a href="{{ route('client.categories.show', $cat->id) }}" class="nav-link">{{ $cat->ten }}</a></li>
            @endforeach
        @endif
        <li class="nav-item cta cta-colored"><a href="{{ route('cart.show') }}" class="nav-link">Giỏ hàng <span class="icon-shopping_cart"></span></a></li>

        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           {{ Auth::user()->ho }}  {{ Auth::user()->ten }}
          </a>


          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="{{ route('orders.history') }}">Lịch sử đơn hàng</a></li>

             <li><a class="dropdown-item" href="{{ route('logout') }}">Đăng xuất</a></li>

            <li>          @if (Auth::user()->vai_tro === 'admin')
              <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Trang quản trị</a>
          @endif</li>
          </ul>
        </li>
        @else
        <li class="nav-item active">
          <div class="container mt-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký</button>
          </div>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<!-- Modal Đăng ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Tạo tài khoản mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>

      <div class="modal-body">

        @if ($errors->any() && session('modal') === 'register')
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
          @csrf
                    <div class="mb-3">
            <label for="ho" class="form-label">Họ</label>
            <input type="text" class="form-control" id="ho" name="ho" value="{{ old('ho') }}" required>
          </div>

          <div class="mb-3">
            <label for="ten" class="form-label">Tên:</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{ old('ten') }}" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
          </div>

          <div class="mb-3">
            <label for="matkhau" class="form-label">Mật khẩu:</label>
            <input type="password" class="form-control" id="matkhau" name="matkhau" required>
          </div>

          <div class="mb-3">
            <label for="matkhau_confirmation" class="form-label">Xác nhận mật khẩu:</label>
            <input type="password" class="form-control" id="matkhau_confirmation" name="matkhau_confirmation" required>
          </div>

          <div class="mb-3">
            <label for="dien_thoai" class="form-label">Số điện thoại:</label>
            <input type="text" class="form-control" id="dien_thoai" name="dien_thoai" value="{{ old('dien_thoai') }}" required>
          </div>

          <div class="mb-3">
            <label for="dia_chi" class="form-label">Địa chỉ:</label>
            <input type="text" class="form-control" id="dia_chi" name="dia_chi" value="{{ old('dia_chi') }}" required>
          </div>

          <div class="mb-3">
            <label for="thanhpho" class="form-label">Thành phố:</label>
            <input type="text" class="form-control" id="thanhpho" name="thanhpho" value="{{ old('thanhpho') }}" required>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>

      <div class="modal-body">
        @if ($errors->has('email') && session('modal') === 'login')
          <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif

        @if (session('success') && session('modal') === 'login')
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
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

<!-- Banner -->
<section id="home-section" class="hero">
<div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
        @foreach($banners as $key => $banner)
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <img src="{{ asset($banner->hinh_anh) }}" class="d-block w-100" alt="Banner {{ $key + 1 }}"
                     style="height: 450px; object-fit: cover;">
            </div>
        @endforeach
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Hiển thị modal lại nếu có lỗi -->
@if(session('modal') === 'login')
<script>
  const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
  loginModal.show();
</script>
@endif

@if(session('modal') === 'register')
<script>
  const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
  registerModal.show();
</script>
@endif
