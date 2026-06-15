<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: sans-serif; background-color: #f1f5f9; padding: 20px;">
    <div style="max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0;">
        <h2 style="color: #5B1D2A; text-align: center;">SIPETANG</h2>
        <p>Halo,</p>
        <p>Kami menerima permintaan untuk mereset password akun Anda. Silakan gunakan kode OTP di bawah ini untuk melanjutkan proses reset password:</p>

        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #5B1D2A; background: #f8fafc; padding: 10px 25px; border-radius: 8px; border: 1px dashed #cbd5e1;">
                {{ $otp }}
            </span>
        </div>

        <p style="color: #64748b; font-size: 14px;">Kode OTP ini berlaku selama 15 menit. Jika Anda tidak meminta reset password, abaikan email ini.</p>
        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;">
        <p style="font-size: 12px; color: #94a3b8; text-align: center;">© 2026 Sistem Presensi Elektro - Poliban</p>
    </div>
</body>
</html>
