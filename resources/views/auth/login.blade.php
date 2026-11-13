<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ url(Storage::url($setting['app_logo'])) }}" />
    <title> {{ __('login') }} || {{ $setting['app_name'] }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ url('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{ url('assets/dist/css/adminlte.min.css') }}" rel="stylesheet">

    @php
        $setting = getSetting();
        $primary_color = isset($setting['primary_color']) ? $setting['primary_color'] : '#be212a';
        $secondary_color = isset($setting['secondary_color']) ? $setting['secondary_color'] : '#1e293b';
    @endphp

    <style>
        :root {
            --primary-color: #be212a;
            /* Forced to your brand red */
            --secondary-color: {{ $secondary_color }};
            --slate: #1e293b;
        }

        body.login-page {
            /* Adding a subtle overlay to the background image for better contrast */
            background-image: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), url('{{ url('assets/dist/img/photo1.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            background: #ffffff;
        }

        .login-card-body {
            padding: 40px 30px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-logo img {
            max-width: 220px;
            height: auto;
            object-fit: contain;
        }

        .login-box-title {
            text-align: center;
            font-weight: 800;
            color: var(--slate);
            font-size: 1.6rem;
            margin-bottom: 5px;
        }

        .login-box-msg {
            text-align: center;
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Custom Input Styling */
        .inner-addon {
            position: relative;
            margin-bottom: 20px;
        }

        .inner-addon .fa {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            pointer-events: none;
            transition: color 0.3s;
        }

        .inner-addon .password-toggle {
            left: auto;
            right: 20px;
            cursor: pointer;
            pointer-events: auto;
        }

        .inner-addon .form-control {
            height: 55px;
            border-radius: 12px;
            padding-left: 50px;
            padding-right: 50px;
            border: 1.5px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 1rem;
            color: var(--slate);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .inner-addon .form-control::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .inner-addon .form-control:focus {
            border-color: var(--primary-color);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(190, 33, 42, 0.1);
        }

        .inner-addon .form-control:focus+.fa {
            color: var(--primary-color);
        }

        .login-btn {
            background-color: #000000;
            /* Black button */
            border-color: #000000;
            color: #ffffff;
            font-weight: 700;
            font-size: 1.05rem;
            height: 55px;
            border-radius: 12px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .login-btn:hover,
        .login-btn:focus {
            background-color: var(--primary-color);
            /* Hover to brand red */
            border-color: var(--primary-color);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(190, 33, 42, 0.3);
        }

        .alert {
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
        }

        .alert-danger {
            background-color: #fde8ea;
            color: var(--primary-color);
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card-body {
                padding: 30px 20px;
            }

            .login-box-title {
                font-size: 1.4rem;
            }
        }
    </style>
</head>

<body class="hold-transition login-page">

    @if (env('DEMO_MODE'))
        <div class="alert bg-warning mb-3 text-dark position-absolute w-100"
            style="top: 0; left: 0; border-radius: 0; z-index: 999; font-size: 12px;">
            <b>Note:</b> If you cannot login here, please close the codecanyon frame by clicking on <b>x Remove
                Frame</b> button from top right corner on the page or <a href="https://news-admin.wrteam.me/"
                target="_blank">&gt;&gt; Click here &lt;&lt;</a>
        </div>
    @endif

    <div class="login-box">
        <div class="card" id="login_form_card">
            <div class="card-body login-card-body">

                <div class="login-logo">
                    <a href="javascript:void(0)">
                        <img src="{{ url(Storage::url($setting['app_logo_full'])) }}" alt="Logo" />
                    </a>
                </div>

                <h3 class="login-box-title">Welcome Back!</h3>
                <p class="login-box-msg">Please log in to your account</p>

                <form role="form" id="login_form" action="{{ route('authenticate') }}" novalidate method="post">
                    @csrf

                    <div class="form-group inner-addon">
                        <i class="fa fa-user"></i>
                        <input type="text" name="username" class="form-control"
                            @if (env('DEMO_MODE')) value="admin" @endif placeholder="Username or Email"
                            required>
                    </div>

                    <div class="form-group inner-addon">
                        <i class="fa fa-lock"></i>
                        <input id="password" type="password" name="password" class="form-control"
                            @if (env('DEMO_MODE')) value="admin123" @endif placeholder="Password" required>
                        <i class="fa fa-eye-slash password-toggle" id="eye-icon"
                            onclick="togglePasswordVisibility()"></i>
                    </div>

                    @if (session('error'))
                        <div class="row col-12 px-0">
                            <p id="error_msg" class="alert alert-danger w-100 text-center">{{ session('error') }}</p>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block login-btn">Log In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Forgot Password Card (Kept hidden by default as per your script) -->
        <div class="card" id="forgot_password_card" style="display: none">
            <div class="card-body login-card-body">
                <div class="login-logo">
                    <a href="javascript:void(0)">
                        <img src="{{ url(Storage::url($setting['app_logo_full'])) }}" alt="Logo" />
                    </a>
                </div>

                <h3 class="login-box-title">Reset Password</h3>
                <p class="login-box-msg">Enter your email to receive a reset link</p>

                <form role="form" id="forgot_password_form" action="" method="post">
                    @csrf
                    <div class="form-group inner-addon">
                        <i class="fa fa-envelope"></i>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="Email Address" required>
                    </div>

                    <div class="row col-12 px-0">
                        <p id="email_sent" class="alert alert-success w-100 text-center"></p>
                    </div>
                    <div class="row col-12 px-0">
                        <p id="invalid_email" class="alert alert-danger w-100 text-center"></p>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" id="forgot_submit_btn"
                                class="btn btn-primary btn-block login-btn">Reset Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Validation -->
    <script src="{{ url('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ url('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script type="text/javascript">
        $('#login_form').validate({
            rules: {},
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $(document).ready(function() {
            $('#error_msg').delay(4000).fadeOut();

            /*By Default Hide Forgot Password Form*/
            $('#forgot_password_card').hide();

            /*On click Forgot Password -> show Forgot password form*/
            $('#forgot_password_btn').on('click', function(e) {
                e.preventDefault();
                $('#login_form_card').hide();
                $('#forgot_password_card').show();
            });

            /*Hide error, success msg*/
            $('#email_sent').hide();
            $('#invalid_email').hide();

            /*on submit forgot password - email sent*/
            $('#forgot_password_form').submit(function(e) {
                e.preventDefault();
                var email = $('#email').val();
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "check_email",
                    data: {
                        email: email
                    },
                    beforeSend: function() {
                        $('#forgot_submit_btn').html('Checking...');
                    },
                    success: function(result) {
                        $('#forgot_submit_btn').html('Reset Password');
                        if (result == true) {
                            $('#email_sent').html("Email Sent Successfully").show().delay(4000)
                                .fadeOut();
                            allowsubmit = true;
                        } else {
                            $('#invalid_email').html("Invalid Email ID.").show().delay(4000)
                                .fadeOut();
                        }
                    },
                    error: function(result) {
                        $('#old_status').html("Error" + result);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }
    </script>

</body>

</html>
