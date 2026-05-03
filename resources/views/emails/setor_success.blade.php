<!DOCTYPE html>
<html>
<head>
    <title>Setoran Berhasil</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-w: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #16a34a; margin: 0;">Setoran Berhasil! 🎉</h2>
            <p style="color: #666;">Terima kasih telah menabung di Bank Sampah</p>
        </div>
        
        <p>Halo, <strong>{{ $data['nama_nasabah'] }}</strong>,</p>
        <p>Setoran sampah Anda baru saja diproses oleh petugas kami. Berikut adalah rinciannya:</p>

        <div style="background-color: #f9fafb; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; color: #555;">Jenis Sampah</td>
                    <td style="padding: 8px 0; text-align: right; font-weight: bold;">{{ $data['jenis_sampah'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #555;">Berat</td>
                    <td style="padding: 8px 0; text-align: right; font-weight: bold;">{{ $data['berat'] }} Kg</td>
                </tr>
                <tr style="border-bottom: 1px dashed #ccc;">
                    <td style="padding: 8px 0; color: #555;">Nominal Didapat</td>
                    <td style="padding: 8px 0; text-align: right; color: #16a34a; font-weight: bold;">+ Rp {{ number_format($data['nominal'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0 0 0; color: #333; font-weight: bold;">Total Saldo Aktif</td>
                    <td style="padding: 12px 0 0 0; text-align: right; font-weight: bold; font-size: 18px;">Rp {{ number_format($data['saldo_akhir'], 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        
        <p style="color: #666; font-size: 12px; text-align: center;">Bumi berterima kasih atas kontribusi Anda hari ini. Pantau terus tabungan Anda melalui aplikasi.</p>
    </div>
</body>
</html>