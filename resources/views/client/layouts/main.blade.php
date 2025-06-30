<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

  <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Local CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/open-iconic-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/owl.theme.default.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/magnific-popup.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/bootstrap-datepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/jquery.timepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/flaticon.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/icomoon.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/client/vegefoods-master/css/style.css') }}">
</head>
<body class="goto-here">

  @include('client.layouts.header')

  @yield('content')

  @include('client.layouts.footer')

  <!-- JS: Bootstrap & jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS: Local Scripts -->
  <script src="{{ asset('assets/client/vegefoods-master/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/jquery-migrate-3.0.1.min.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/jquery.easing.1.3.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/jquery.stellar.min.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/aos.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/jquery.animateNumber.min.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('assets/client/vegefoods-master/js/scrollax.min.js') }}"></script>

</body>
</html>