<div style="font-family: sans-serif; max-w: 500px; margin: auto; border: 1px solid #eee; padding: 20px; border-radius: 15px;">
    <div style="text-align: center; margin-bottom: 20px;">
        <div style="font-size: 40px; margin-bottom: 10px;">⏳</div>
        <h2 style="color: #eab308; margin: 0;">Pengajuan Penarikan Diproses</h2>
    </div>
    
    <p>Halo <strong>{{ $data['nama'] }}</strong>,</p>
    <p>Kami telah menerima permintaan penarikan saldo Anda. Saat ini pengajuan tersebut sedang dalam antrean pencairan oleh tim Keuangan kami.</p>
    
    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <tr style="background: #f9fafb;">
            <td style="padding: 10px; border-bottom: 1px solid #eee; color: #666;">Nominal Pengajuan</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: right; font-weight: bold; color: #333;">Rp {{ number_format($data['nominal'], 0, ',', '.') }}</td>
        </tr>
    </table>
    
    <p style="font-size: 12px; color: #999; margin-top: 20px; text-align: center;">Mohon kesediaannya menunggu maksimal 1x24 jam hari kerja.</p>
</div>