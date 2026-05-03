<div style="font-family: Arial, sans-serif; max-w: 600px; margin: auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 10px; background-color: #fafafa;">
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="color: #dc2626; margin: 0;">Penarikan Saldo Ditolak</h2>
        <p style="color: #6b7280; font-size: 14px;">Bank Sampah Digital</p>
    </div>

    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid #fee2e2;">
        <p style="color: #374151;">Halo, <strong>{{ $data['nama'] }}</strong>.</p>
        <p style="color: #374151;">Mohon maaf, pengajuan penarikan saldo Anda sebesar <strong>Rp {{ number_format($data['nominal'], 0, ',', '.') }}</strong> pada tanggal {{ $data['tanggal'] }} terpaksa kami tolak.</p>
        
        <div style="background-color: #fef2f2; border-left: 4px solid #dc2626; padding: 15px; margin: 20px 0;">
            <p style="margin: 0; color: #991b1b; font-size: 14px;"><strong>Catatan Admin / Alasan Penolakan:</strong></p>
            <p style="margin: 5px 0 0 0; color: #7f1d1d; font-style: italic;">"{{ $data['alasan'] }}"</p>
        </div>

        <p style="color: #374151;">Jangan khawatir, dana penarikan tersebut telah <strong>dikembalikan secara utuh</strong> ke saldo aktif Bank Sampah Anda. Anda dapat mengajukan penarikan kembali dengan memperbaiki data sesuai catatan di atas.</p>
    </div>

    <p style="text-align: center; color: #9ca3af; font-size: 12px; margin-top: 20px;">
        Terima kasih,<br>Tim Bank Sampah Digital
    </p>
</div>