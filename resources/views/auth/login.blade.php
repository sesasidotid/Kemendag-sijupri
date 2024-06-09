<!DOCTYPE html>
<html>

<head>
    <title>SijuPRI</title>
    <link rel="shortcut icon" href="{{ asset('images/binboot.jpg') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/ef.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
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
    <div class="containery">
        <div class="img">
            <div class="containerx" style="position: absolute;">
                <h1 style="font-size: 30px;">Selamat Datang Di </h1>
                <h1> SIJUPRI </h1>
            </div>
            <img height="60%" style="margin-left: 50% ; mar" src="{{ asset('images/binboot.jpg') }}">
        </div>
        <div class="login-content" style="width: 80%;">
            <form action="{{ route('do_login') }}" method="POST">
                @csrf <!-- Tambahkan token CSRF -->
                @if (Session::get('status') === 1)
                    <div class="alert alert-danger" style="font-size: 0.8rem" role="alert">
                        <strong>NIP / PASSWORD SALAH !</strong> Silahkan coba lagi.
                    </div>
                @endif
                <img src="{{ asset('auth/img/logo.svg') }}" style="max-height: 10vh;">
                <h2 style="font-size: 2rem; font-weight: 600;">
                    LOGIN
                </h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>NIP</h5>
                        <input type="text" name="nip" class="input">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input name="password" id="pass" type="password" class="input">
                        <i onclick="see()" id="mata" class="ix fas fa-eye-slash"
                            style="display: none; color:  #355c7d;;"></i>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-12 m-2 ms-3">
                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY', '') }}"></div>
                        </div>
                        <div class="col-12">
                            <button id="btn-submit-login" class="btn btn-lg m-2" type="submit">
                                <i class='fas fa-sign-in-alt'></i> Masuk
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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
