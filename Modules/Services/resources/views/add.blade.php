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
                                <h4 class="card-title">Gestione Tipologia Servizi</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <p class="mb-3">&nbsp;</p>
                                </div>
                                    <livewire:AddService />
                                <div class="card-footer">
                                    &nbsp;
                                </div>
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