<!DOCTYPE html>
<html lang="en">
@include('partials/_head')

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('partials/_navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <!-- @include('partials/_setting') -->
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            @include('partials/_sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper" style="background: linear-gradient(to top, #fff7dd, #fff7dd);">
                    @yield('content')
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                    @yield('scripts')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('partials/_footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    @include('partials/_scripts')
</body>

</html>