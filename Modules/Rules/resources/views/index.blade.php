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
                                <h4 class="card-title">Gestione Ruoli</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <p class="mb-3">In questa sezione è possibile gestire i ruoli degli utenti del sistema.</p>
                                </div>
                                <livewire:rules-list />
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
    <!-- Bootstrap JS -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Defaultmenu JS -->
    <script src="../assets/js/defaultmenu.min.js"></script>

    <!-- Node Waves JS-->
    <script src="../assets/libs/node-waves/waves.min.js"></script>

    <!-- Sticky JS -->
    <script src="../assets/js/sticky.js"></script>

    <!-- Simplebar JS -->
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/js/simplebar.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/custom.js"></script>
</body>
</html>