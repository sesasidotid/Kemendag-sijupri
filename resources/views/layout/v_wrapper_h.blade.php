@include('layout.v_head_h')
<div class="main-content">
    <div class="page-content m-0">
        <div class="container-fluid">
            {{-- <h1>TEST</h1> --}}
            @yield('content')
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    @include('layout.v_footer')
