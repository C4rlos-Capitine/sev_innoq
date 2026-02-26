<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SV Normas')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800&amp;display=swap" rel="stylesheet" />

    <!-- Vendor CSS (Bootstrap & Icon Font) -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/DataTables/datatables.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/DataTables/datatables.min.css')}}" type="text/css">
    <!-- Plugins CSS (All Plugins Files) -->
    <link rel="stylesheet" href="/assets/css/plugins/animate.css">
    <link rel="stylesheet" href="/assets/css/plugins/jquery-ui.min.css">

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/vendor.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css')}}">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Open Sans', sans-serif;
            color: #212529;
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
        }
        
        .main-content {
            flex: 1;
            padding: 0;
        }
        
        .container-fluid {
            max-width: 100%;
            padding: 0 2rem;
        }
        
        footer {
            margin-top: auto;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }
        #form-login{
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
        }
        .container{
            margin:0;
        }
    </style>
</head>
<body>
    @include('layouts.header_admin')
    
    <!-- Cart Modal Global -->
    @include('layouts.cart-modal')

    <div class="container-fluid main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    @yield('scripts')
</body>
</html>
