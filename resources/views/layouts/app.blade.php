@include("partials.head")

</head>
<body>
    <div class="page">
        @include("partials.header")
        @include("partials.sidebar")

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                @include("partials.page-header", ["title" => "Dashboard", "subtitle" => 'Home'])

                <!--Start::row-4 -->
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <h4 class="card-title">&nbsp;</h4>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div>
                                        <input class="form-control form-control-sm" type="text" placeholder="Search Here" aria-label=".form-control-sm example">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                {{ $slot }}
                            </div>
                            <div class="card-footer">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!--End::row-4 -->

            </div>
        </div>
        <!-- End::app-content -->
        @include("partials.footer")

    </div>

    @include("partials.commonjs")

    <!-- Apex Charts JS -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/js/index.js"></script>
    <!-- Custom JS -->
    <script src="../assets/js/custom.js"></script>
</body>
</html>