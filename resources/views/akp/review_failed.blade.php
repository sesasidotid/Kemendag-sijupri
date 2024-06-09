<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SIjuPRI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/binboot.jpg') }}">
    <!-- third party css -->
    <link href="{{ asset('starter/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->
    <!-- App css -->
    <link href="{{ asset('starter/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('starter/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('starter/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
</head>

<body class="loading" data-layout="topnav"
    data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
    <div class="wrapper">
        <div class="content-page">
            <div class="content">
                <div class="container-fluid p-4 mt-5">
                    <div class="card card-body">
                        <h3>Terjadi Kesalahan</h3> <small class="text-danger">({{ $message }})</small>
                        <p class="text-info">*silahkan tutup laman ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('starter/js/vendor.min.js') }}"></script>
    <script src="{{ asset('starter/js/app.min.js') }}"></script>
    <script src="{{ asset('starter/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('starter/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('starter/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>
</body>

</html>
