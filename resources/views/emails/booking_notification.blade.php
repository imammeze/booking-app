<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
        .header { background-color: #d97706; padding: 20px; text-align: center; color: white; }
        .content { padding: 30px; background-color: #ffffff; }
        .footer { background-color: #f9fafb; padding: 15px; text-align: center; font-size: 12px; color: #6b7280; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table td { padding: 10px; border-bottom: 1px solid #f3f4f6; }
        .label { font-weight: bold; color: #4b5563; width: 30%; }
        .button { display: inline-block; padding: 12px 25px; background-color: #d97706; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 25px; }
        .badge { background-color: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Masjid Al Haq</h2>
            <p style="margin:5px 0 0; font-size: 14px; opacity: 0.9;">Notifikasi Permohonan Booking</p>
        </div>
        
        <div class="content">
            <p>Assalamu'alaikum <strong>Admin</strong>,</p>
            <p>Ada pengajuan booking ruangan baru yang memerlukan tinjauan Anda:</p>
            
            <table class="details-table">
                <tr>
                    <td class="label">Peminjam</td>
                    <td>{{ $booking->name }}</td>
                </tr>
                <tr>
                    <td class="label">WhatsApp</td>
                    <td><a href="https://wa.me/{{ $booking->phone_number }}" style="color: #059669; text-decoration: none;">{{ $booking->phone_number }}</a></td>
                </tr>
                <tr>
                    <td class="label">Ruangan</td>
                    <td>{{ $booking->room->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Kegiatan</td>
                    <td>{{ $booking->title }}</td>
                </tr>
                <tr>
                    <td class="label">Waktu</td>
                    <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="label">Status</td>
                    <td><span class="badge">MENUNGGU PERSETUJUAN</span></td>
                </tr>
            </table>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="button">Masuk ke Dashboard Admin</a>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Masjid Al Haq Booking System.<br>Pesan ini dikirim secara otomatis oleh sistem.</p>
        </div>
    </div>
</body>
</html>