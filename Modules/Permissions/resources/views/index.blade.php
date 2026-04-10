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
                                <h4 class="card-title">Gestione Permessi</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <p class="mb-3">In questa sezione è possibile gestire i permessi degli utenti del sistema.</p>
                                </div>
                                <livewire:permissions-list />
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

    <!-- Jquery Cdn -->

    <!-- Datatables Cdn -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>

    <!-- Internal Datatables JS -->
    <script src="../assets/js/datatables.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/custom.js"></script>
</body>
</html>