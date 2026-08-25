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
                        <p class="text-muted text-center">Inserisci la tua password per completare il tuo processo di registrazione.</p>
                        <p class="text-warning text-center">Nota: La password deve contenere almeno 8 caratteri, una lettera maiuscola, una lettera minuscola e un numero.</p>
                        <form method="POST" action="{{ route('addbupsw.store', ['token' => $token]) }}">
                            @csrf
                            @error('password')
                                 <div class="input-group input-box mb-3 text-center"><span class="text-danger">{{ $message }}</span><br></div>
                            @enderror
                            @error('password_confirmation')
                                <div class="input-group input-box mb-3 text-center"><span class="text-danger">{{ $message }}</span><br></div>
                            @enderror
                            <div class="input-group input-box mb-3">
                                <input type="password" name="password" class="form-control form-control-lg" id="signin-password" placeholder="Password">
                                <span class="authentication-input-icon"><i class="ri-lock-2-fill text-default fs-15 op-7"></i></span>
                                <button type="button" aria-label="button" class="btn btn-light" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                            </div>
                            <div class="input-group input-box mb-3">
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" id="signin-password-confirmation" placeholder="Conferma password">
                                <span class="authentication-input-icon"><i class="ri-lock-2-fill text-default fs-15 op-7"></i></span>
                                <button type="button" aria-label="button" class="btn btn-light" onclick="createpassword('signin-password-confirmation',this)" id="button-addon3"><i class="ri-eye-off-line align-middle"></i></button>
                            </div>
                            <div class="col-xl-12 d-grid mb-3">
                                <button type="submit" class="btn btn-lg btn-primary">Completa Registrazione</button>
                            </div>
                        </form>
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
    <script src="../assets/js/custom-switcher.min.js"></script>

    <!-- Show Password JS -->
    <script src="../assets/js/show-password.js"></script>

</body>
</html>
</x-layouts::auth.simple>
