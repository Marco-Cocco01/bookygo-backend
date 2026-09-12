<x-layouts::auth.simple :title="$title ?? null">
    <div class="container px-3">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="my-4 d-flex justify-content-center">
                    <a href="{{ route('login') }}">
                        <img src="../assets/images/brand-logos/logo.png" alt="Bookygo" class="w-35">
                    </a>
                </div>
                <div class="card custom-card">
                    <div class="card-body p-4 pb-3">
                        <h6 class="fw-semibold mb-4 text-center">Completa la tua registrazione</h6>
                        <p class="text-warning text-center"><p>Ti abbiamo inviato un link di verifica. Clicca sul link nella email per attivare il tuo account</p>
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="btn btn-primary mt-3">Torna al login</a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-list text-center">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Bootstrap JS -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
</x-layouts::auth.simple>
