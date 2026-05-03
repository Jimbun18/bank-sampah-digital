<div style="font-family: sans-serif; max-w: 500px; margin: auto; border: 1px solid #eee; padding: 20px; border-radius: 15px;">
    <div style="text-align: center; margin-bottom: 20px;">
        <div style="font-size: 40px; margin-bottom: 10px;">💸</div>
        <h2 style="color: #16a34a; margin: 0;">Dana Berhasil Ditransfer!</h2>
    </div>
    
    <p>Halo <strong>{{ $data['nama'] }}</strong>,</p>
    <p>Kabar baik! Penarikan saldo Anda telah disetujui dan dana telah sukses dikirimkan ke rekening tujuan Anda.</p>
    
    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <tr style="background: #f9fafb;">
            <td style="padding: 10px; border-bottom: 1px solid #eee; color: #666;">ID Transaksi</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: right; font-weight: bold;">#TRK-{{ $data['id_penarikan'] }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #eee; color: #666;">Bank Tujuan</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: right; font-weight: bold;">{{ $data['bank'] }}</td>
        </tr>
        <tr style="background: #f9fafb;">
            <td style="padding: 10px; border-bottom: 1px solid #eee; color: #666;">Nomor Rekening</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: right; font-weight: bold;">{{ $data['no_rekening'] }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #eee; color: #666;">Nominal Cair</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: right; font-weight: bold; color: #16a34a;">Rp {{ number_format($data['nominal'], 0, ',', '.') }}</td>
        </tr>
        <tr style="background: #f0fdf4;">
            <td style="padding: 10px; color: #166534; font-weight: bold;">Status</td>
            <td style="padding: 10px; text-align: right; color: #166534; font-weight: bold;">BERHASIL</td>
        </tr>
    </table>
    
    <p style="font-size: 12px; color: #999; margin-top: 20px; text-align: center;">Terima kasih telah mempercayakan tabungan Anda pada kami.</p>
</div>