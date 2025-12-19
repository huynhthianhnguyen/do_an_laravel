<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
</head>

<body style="margin:0; padding:0; background:#f5f5f5; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5; padding:20px 0;">
    <tr>
        <td align="center">

            <!-- Wrapper -->
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; padding:20px;">

                <!-- Header -->
                <tr>
                    <td align="center" style="padding-bottom:20px;">
                        <h2 style="margin:0; color:#333;">
                            Cảm ơn bạn đã đặt hàng tại Olivine Fashion Store 💖
                        </h2>
                    </td>
                </tr>

                <!-- Thông tin đơn -->
                <tr>
                    <td style="color:#333; font-size:15px;">

                        <p>Đơn hàng <strong>#{{ $order->id }}</strong> của bạn đã được ghi nhận.</p>

                        <h3 style="margin-top:20px;">Thông tin đơn hàng:</h3>

                        <ul style="padding-left:20px; margin-top:10px;">
                            @foreach ($order->items as $item)
                                <li style="margin-bottom:5px;">
                                    {{ $item->ten_san_pham }} × {{ $item->quantity }} —
                                    {{ number_format($item->gia, 0, ',', '.') }} ₫
                                </li>
                            @endforeach
                        </ul>

                        <p style="margin-top:20px; font-size:16px;">
                            <strong>Tổng cộng:</strong>
                            <span style="color:#e74c3c; font-weight:bold;">
                                {{ number_format($order->total, 0, ',', '.') }} ₫
                            </span>
                        </p>

                        <p style="margin-top:20px;">
                            Chúng tôi sẽ sớm liên hệ để xác nhận và giao hàng.<br>
                            — Đội ngũ Olivine Fashion 🌸
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="padding-top:20px; border-top:1px solid #ddd; color:#555; font-size:14px;">
                        <p style="margin:0; font-weight:bold;">Olivine Fashion</p>
                        <p style="margin:3px 0;">123 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh</p>
                        <p style="margin:3px 0;">
                            Email: <a href="mailto:olivinefashion82@gmail.com">olivinefashion82@gmail.com</a>
                        </p>
                        <p style="margin:3px 0;">Hotline: 090 555 6787</p>
                    </td>
                </tr>

            </table>
            <!-- End Wrapper -->

        </td>
    </tr>
</table>

</body>
</html>
