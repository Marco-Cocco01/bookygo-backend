<x-layouts::auth.simple :title="$title ?? null">
    <div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="my-4 d-flex justify-content-center">
                    <a href="index.html">
                        <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="">
                    </a>
                </div>
                <div class="card custom-card">
                    <form method="POST" action="{{ route('register.store') }}">
                        <input type="hidden" name="session" value="{{ session('status') }}" /> 
                        @csrf
                        <div class="card-body p-4 pb-3">
                            <h4 class="fw-semibold mb-4 text-center">{{ __('Create an account') }}
                                <p class="fs-6 mt-2">{{__('Enter your details below to create your account')}}</p>
                            </h4>
                            <div class="input-box mb-3" data-bs-validate="Valid email is required: ex@abc.xyz">
                                <input type="text" name="name" class="form-control form-control-lg" id="name" value="{{old('name')}}" placeholder="{{ __('Full name') }}">
                                <span class="authentication-input-icon"><i class="ri-user-3-fill text-default fs-15 op-7"></i></span>
                            </div>
                            <div class="input-box mb-3" data-bs-validate="Valid email is required: ex@abc.xyz">
                                <input type="text" name="email" class="form-control form-control-lg" id="email" value="{{old('email')}}" placeholder="email@example.com">
                                <span class="authentication-input-icon"><i class="ri-mail-fill text-default fs-15 op-7"></i></span>
                            </div>
                            <div class="input-group input-box mb-3">
                                <input type="password" name="password" class="form-control form-control-lg" id="signin-password"  placeholder="{{ __('Password') }}">
                                <span class="authentication-input-icon"><i class="ri-lock-2-fill text-default fs-15 op-7"></i></span>
                                <button aria-label="button" class="btn btn-light" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                            </div>
                            <div class="input-group input-box mb-3">
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" id="signin-password-confirmation"  placeholder="{{ __('Confirm password') }}">
                                <span class="authentication-input-icon"><i class="ri-lock-2-fill text-default fs-15 op-7"></i></span>
                                <button aria-label="button" class="btn btn-light" type="button" onclick="createpassword('signin-password-confirmation',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                        Agree the <span class="text-primary">Terms and Policy.</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-12 d-grid mb-3">
                                <button type="submit" class="btn btn-lg btn-primary">Register</button>
                            </div>
                            <div class="text-center mb-0">Already have an Account ?<a href="{{ route('login') }}" class="text-primary ms-2">{{ __('Log in') }}</a></div>
                        </div>
                    </form>
                    <div class="card-footer">
                        <div class="btn-list text-center">
                            <button type="button" aria-label="button" class="btn btn-icon btn-light">
                                <i class="ri-facebook-line fw-bold text-dark op-7 align-middle"></i>
                            </button>
                            <button type="button" aria-label="button" class="btn btn-icon btn-light">
                                <i class="ri-twitter-line fw-bold text-dark op-7 align-middle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Show Password JS -->
    <script src="../assets/js/show-password.js"></script>
</body>
</html>
</x-layouts::auth.simple>
