<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Fitzone</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            background-color: #F3F4F6;
            color: #2C3E50;
        }

        .email-container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .email-header {
            background: linear-gradient(135deg, #FF6B00 0%, #FF8E53 100%);
            color: white;
            text-align: center;
            padding: 25px 20px;
            position: relative;
        }

        .email-header::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 100%;
            height: 30px;
            background: inherit;
            transform: skewY(-3deg);
        }

        .email-content {
            padding: 40px 30px;
        }

        .reset-link {
            background: linear-gradient(145deg, #FFF0E5 0%, #FFE4D1 100%);
            border: 2px dashed #FF6B00;
            color: #FF6B00;
            text-align: center;
            padding: 20px;
            border-radius: 12px;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 3px;
            margin: 25px 0;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .contact-section {
            background-color: #F9FAFB;
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
        }

        .footer {
            background-color: #FF6B00;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }

        .button {
            display: inline-block;
            background-color: #FF6B00;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #FF8E53;
        }

        @media screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }

            .email-content {
                padding: 25px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1 style="font-size: 24px; font-weight: 700;">Permintaan Pengaturan Ulang Kata Sandi</h1>
        </div>

        <div class="email-content">
            <p style="font-size: 16px; margin-bottom: 20px;">
                Halo, <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
            </p>

            <p style="margin-bottom: 20px;">
                Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di Fitzone. Jika Anda merasa ini adalah permintaan yang sah, klik tombol di bawah untuk melanjutkan proses pengaturan ulang kata sandi Anda.
            </p>

            <div class="reset-link">
                <a href="{{ $resetUrl }}" class="button">Atur Ulang Kata Sandi</a>
            </div>

            <p style="font-size: 16px;">
                Jika Anda tidak merasa melakukan permintaan ini atau tidak mengenali aktivitas ini, cukup abaikan email ini dan kata sandi Anda tidak akan berubah. Kami selalu menjaga keamanan akun Anda dengan sangat serius.
            </p>
        </div>

        <div class="footer">
            © 2024 Fitzone -  Menghadirkan Performa Tanpa Batas
        </div>
    </div>
</body>
</html>
