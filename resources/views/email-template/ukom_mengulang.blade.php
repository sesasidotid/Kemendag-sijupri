<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        /* Custom CSS Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .row {
            display: flex;
            justify-content: center;
        }

        .col-md-6 {
            width: 50%;
            text-align: center;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>Tekan tombol dibawah untuk masuk pada form pendaftaran</p>
                <div>
                    <a href="{{ $url }}" class="btn" style="color: white">Klik di-sini</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
