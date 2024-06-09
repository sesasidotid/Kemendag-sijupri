<!DOCTYPE html>
<html>

<head>
    <title>SijuPRI</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('auth/ef.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <img class="wave" src="{{ asset('auth/img/wave.png') }}">
    <div class="containery">

        <div class="img">
            <div class="containerx" style="position: absolute;">
                <h1 style="font-size: 30px;">Selamat Datang Di </h1>
                <h1> SIJUPRI </h1>
            </div>

            <img src="{{ asset('auth/img/bg.svg') }}">
        </div>
        <div class="login-content" style="width: 80%;">
            <form action="{{ route('/login') }}" method="POST">
                @csrf <!-- Tambahkan token CSRF -->

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
                <a href="#" style="text-align: right; display: block;">Lupa kata sandi?</a>
                <div>
                    <button class="btn btn-lg"
                        style="
					font-size: 0.8rem;
					background-color: #19497d;
					color: #fff;
					font-family: 'Poppins', sans-serif;
					text-transform: uppercase;
					box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
					cursor: pointer;
					transition: .5s;">
                        <i class='fas fa-sign-in-alt'></i> Masuk
                    </button>

                    <div class="horizontal-line p-4">
                        <div class="line"></div>
                        <div class="text">Atau</div>
                        <div class="line"></div>
                    </div>
                    <div>
                        <small style="">Perpindahan Jabatan Ke Jabatan Fungsional Perdagangan ? </small>

                    </div>

                </div>

                <style>
                    .horizontal-line {
                        display: flex;
                        align-items: center;
                    }

                    .line {
                        flex: 1;
                        border-top: 1px solid #292727;
                        margin: 0 10px;
                    }

                    .text {
                        font-weight: 600;
                        font-size: 14px;
                    }
                </style>
                <a href="/user/register"
                    style=" color: rgba(100, 41, 41, 0.55);  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"><span
                        class="badge bg-info text-white" style="font-size: small; font-weight: 600;">Registrasi
                        Sekarang</span></a>
            </form>

        </div>

    </div>
    <div>
        <footer></footer>
    </div>
    <script type="text/javascript" src="{{ asset('auth/js/main.js') }}"></script>
</body>

</html>
