<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('asset/css/cssCart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Giỏ hàng</title>
</head>
<body>
    <div class="navbar">
        <h1>📱 Đơn hàng của bạn</h1>
        <div class="nav-links">
            <a href="{{ route('home') }}">Trang chủ</a>
            <a href="{{ route('cart.index') }}">Giỏ hàng</a>
            <a href="{{ route('order.history') }}">Lịch sử</a>
            @if(session('user_id'))
                <span>{{ session('user_name') }}</span>
                <a href="{{ route('logout') }}">Đăng xuất</a>
            @else
                <a href="{{ route('login') }}">Đăng nhập</a>
            @endif
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                 {{ session('error') }}
            </div>
        @endif

        @if(isset($data))
            <div class="cart-header">
                <h2 style="color: #333;">🛒 Đơn hàng của bạn ( {{ count($data["donHang"]) }} đơn hàng)</h2>
            </div>

            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Đơn giá</th>
                            <th>Trạng thái</th>
                            <th>Loại thanh toán</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data["donHang"] as $item)
                        <tr>
                            <td>
                                <div class="product-info">
                                    <span class="product-name">{{ strtoupper($item->id_don_hang) }}</span>
                                </div>
                            </td>
                            <td>{{ number_format($item->tong_tien*1000,0,'.','.') }}₫</td>
                            <td>{{ $item->ten_trang_thai }}</td>
                            <td>{{ ($item->ten_loai_thah_toan == "COD") ? "Thanh toán khi nhận hàng" : "BANKING"}}</td>
                            @if($item->trang_thai_don_hang < 3)
                                <td>
                                    <form action="{{ route('order.huy') }}" method="POST" class="quantity-form">
                                        @csrf
                                        <input type="hidden" name="idDonHang" value="{{ $item->id_don_hang }}">
                                        <button type="submit" class="update-btn" name="update-quantity">❌ Hủy đơn</button>
                                    </form>
                                </td>
                            @elseif($item->trang_thai_don_hang == 5)
                                <td>
                                    <form action="{{ route('order.confirm') }}" method="POST" class="quantity-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="idDonHang" value="{{ $item->id_don_hang }}">
                                        <button type="submit" class="update-btn" name="update-quantity">
                                            Đã nhận được hàng
                                        </button>
                                    </form>
                                </td>
                            @else
                                <td></td>
                            @endif
                                <td>
                                    <a href="{{ route('order.history-detail',$item->id_don_hang) }}">
                                    <i class="fa-solid fa-eye" style="color:blue;"></i>Xem chi tiết</a>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h2 style="color: #666; margin-bottom: 10px;">Đơn hàng trống</h2>
                <p style="color: #999;">Bạn chưa có đơn nào đang chờ giao dịch</p>
                <a href="{{ route('home') }}" class="continue-shopping">Tiếp tục mua sắm</a>
            </div>
        @endif
    </div>
</body>
</html>