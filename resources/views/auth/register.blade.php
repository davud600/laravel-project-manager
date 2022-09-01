@extends('layouts.guest')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
            <div class="py-4 d-flex justify-content-center">
                <a href="index.html" class="w-auto logo d-flex align-items-center">
                    <img src="assets/img/logo.png" alt="" />
                    <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
            </div>
            <!-- End Logo -->

            <div class="mb-3 card">
                <div class="card-body">
                    <div class="pt-4 pb-2">
                        <h5 class="pb-0 text-center card-title fs-4">
                            Create an Account
                        </h5>
                        <p class="text-center small">
                            Enter your personal details to create account
                        </p>
                    </div>

                    <form class="row g-3 needs-validation" action="/register" method="post">
                        @csrf
                        @method('POST')
                        <div class="col-12">
                            <label for="yourName" class="form-label">Your Name</label>
                            <input type="text" name="name" class="form-control" id="yourName" required />
                            <div class="invalid-feedback">
                                Please, enter your name!
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="yourEmail" class="form-label">Your Email</label>
                            <input type="email" name="email" class="form-control" id="yourEmail" required />
                            <div class="invalid-feedback">
                                Please enter a valid Email adddress!
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="yourCompany" class="form-label">Your Company</label>
                            <input type="text" name="company" class="form-control" id="yourCompany" required />
                            <div class="invalid-feedback">
                                Enter your company name!
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="yourPassword" required />
                            <div class="invalid-feedback">
                                Please enter your password!
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required />
                                <label class="form-check-label" for="acceptTerms">
                                    I agree and accept the
                                    <a href="#">terms and conditions</a>
                                </label>
                                <div class="invalid-feedback">
                                    You must agree before submitting.
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">
                                Create Account
                            </button>
                        </div>
                        <div class="col-12">
                            <p class="mb-0 small">
                                Already have an account? <a href="/login">Log in</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by
                <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </div>
</div>
@stop