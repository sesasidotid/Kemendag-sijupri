<!DOCTYPE html>
<html>

<head>
    <title>SijuPRI</title>
    <link rel="shortcut icon" href="{{ asset('images/binboot.jpg') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/ef.css') }}">

    <link href="{{ asset('build/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        #btn-submit-login {
            font-size: 0.8rem;
            background-color: #19497d;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            cursor: pointer;
            transition: .5s;
        }
    </style>
</head>

<body>
    <img class="wave" src="{{ asset('auth/img/wave.png') }}">
    <div class="row">
        <div style="padding: 10px"></div>
    </div>
    <div class="row">
        <div class="col">
            <div class="float-end">
                <a href="{{ route('/') }}" class="btn btn-md btn-warning" style="margin-right: 10px">
                    Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="containery">
            <div class="img">
                <div class="containerx" style="position: absolute;">
                    <h1 style="font-size: 30px;">Selamat Datang Di </h1>
                    <h1> SIJuPRI </h1>
                    <h6 class="text-white fw-bold"> Sistem Informasi Jabatan Fungsional Perdagangan Republik Indonesia
                    </h6>
                </div>
                <img height="60%" style="margin-left: 50% ; mar" src="{{ asset('images/binboot.jpg') }}">
            </div>
            <div class="login-content" style="width: 80%;">
                <form action="" method="POST" style="background: #ffffff50">
                    @csrf <!-- Tambahkan token CSRF -->
                    @if (Session::has('login_message'))
                        <div class="alert alert-danger" style="font-size: 0.8rem" role="alert">
                            <strong>{{ Session::get('login_message') }}</strong>
                        </div>
                    @endif
                    <img src="{{ asset('auth/img/logo.svg') }}" style="max-height: 10vh;">
                    <h2 style="font-size: 2rem; font-weight: 600;">
                        LOGIN
                    </h2>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control bg-white" id="nipInput" name="nip"
                                    placeholder="NIP">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control bg-white" id="pass" name="password"
                                    placeholder="Password">
                                <button class="btn btn-outline-info" type="button" onclick="see()">
                                    <i id="mata" class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-12 m-2 ms-3">
                                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY', '') }}"></div>
                            </div>
                            <div class="col-12">
                                <button id="btn-submit-login" class="btn btn-lg byn-primary" type="submit">
                                    <i class='fas fa-sign-in-alt'></i> Masuk
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div>
        <footer></footer>
    </div>
    <script type="text/javascript" src="{{ asset('auth/js/main.js') }}"></script>
    <script></script>
    <script>
        function createHiddenInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        }

        fetch('https://api.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {
                const ipAddress = data.ip;
                const userAgent = navigator.userAgent;

                const forms = document.querySelectorAll('form');

                forms.forEach(form => {
                    const ipInput = createHiddenInput('ip_address', ipAddress);
                    const userAgentInput = createHiddenInput('user_agent', userAgent);

                    form.appendChild(ipInput);
                    form.appendChild(userAgentInput);
                });
            });
    </script>
</body>

</html>
