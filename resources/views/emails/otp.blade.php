<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Bank Sampah</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-w: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; text-align: center;">
        <h2 style="color: #16a34a;">Selamat Datang di Bank Sampah!</h2>
        <p>Terima kasih telah mendaftar. Untuk melanjutkan pendaftaran akun Anda, silakan masukkan kode OTP berikut:</p>
        
        <div style="margin: 30px 0; font-size: 36px; font-weight: bold; letter-spacing: 5px; color: #333;">
            {{ $otp }}
        </div>
        
        <p style="color: #666; font-size: 14px;">Kode ini hanya berlaku selama <strong>5 menit</strong>. Jangan berikan kode ini kepada siapapun.</p>
    </div>
</body>
</html>