<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('asset/css/cssCart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Giỏ hàng</title>
    <style>
        .fa-pencil:hover{
            color:blue;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📱 Giỏ hàng của bạn</h1>
        <div class="nav-links">
            <a href="{{ route('home') }}">Trang chủ</a>
            <a href="{{ route('order.index') }}">Đơn hàng</a>
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

        @if(count($cartItems) > 0)
            <div class="cart-header">
                <h2 style="color: #333;">🛒 Giỏ hàng của bạn ({{ count($cartItems) }} sản phẩm)</h2>
                <a href="{{ route('cart.clear',$cartItems[0]->idDonHang) }}" class="clear-btn" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">Xóa tất cả</a>
            </div>

            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr>
                            <td>
                                <div class="product-info">
                                    <span class="product-name">{{ $item->name }}</span>
                                    <img class="product-meta" src="{{ asset('asset/images/'.$item->src_anh) }}"/>
                                </div>
                            </td>
                            <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</td>
                            <td>
                                <form action="{{ route('cart.update', [$item->id,$item->idDonHang]) }}" method="POST" class="quantity-form">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->ton_kho }}" class="quantity-input">
                                    <button type="submit" class="update-btn" name="update-quantity">Cập nhật</button>
                                </form>
                            </td>
                            <td style="font-weight: 600; color: #667eea;">{{ number_format($item->price, 0, ',', '.') }}₫</td>
                            <td>
                                <a href="{{ route('cart.remove', [$item->id,$item->idDonHang]) }}" class="remove-btn" onclick="return 
                                        confirm('Bạn có chắc muốn xóa sản phẩm này?')">❌ Xóa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <form class="cart-summary" method="post" action=" {{ route('order.order') }} " id="formOrder">
                @csrf
                <div class="summary-row">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>
                <div class="summary-row">
                    <span>Tổng cộng:</span>
                    <span>{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>
                <div class="summary-row">
                    <span>Phương thức thanh toán:</span>
                   <select style="padding:8px;font-size:16px;border-radius:5px;" name="ptThanhToan" id="ptThanhToan">Phương thức thanh toán
                        <option value="1">Thanh toán khi nhận hàng</option>
                        <option value="2">BANKING</option>
                   </select>
                </div>
                <div class="summary-row">
                    <span>Địa chỉ:</span>
                    <div>
                        <input name="diachi" value="{{ $cartItems[0]->dia_chi }}" readonly id="diachi" style="width:400px;padding:3px;border-radius:3px;">
                        <i class="fa-solid fa-pencil" id="btnAddress"></i>
                    </div>
                </div>
                <div class="summary-row">
                    <span>Số điện thoại:</span>
                    <div>
                        <input name="sdt" value="{{$cartItems[0]->sdt}}" readonly id="sdt" style="width:400px;padding:3px;border-radius:3px;">
                        <i class="fa-solid fa-pencil" id="btnPhone"></i>
                    </div>
                </div>
                <input type="hidden" value="{{ $total }}" name="amount"/>
                <input type="hidden" value="{{ $cartItems[0]->idDonHang }}" name="idDonHang"/>
                <button class="checkout-btn" name="thanhtoan">Đặt hàng</button>
            </form>
        @else
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h2 style="color: #666; margin-bottom: 10px;">Giỏ hàng trống</h2>
                <p style="color: #999;">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                <a href="{{ route('home') }}" class="continue-shopping">Tiếp tục mua sắm</a>
            </div>
        @endif
    </div>
    <script>
        let diachi = document.querySelector('#diachi')
        let sdt = document.querySelector('#sdt')
        let btnAddress = document.querySelector('#btnAddress')
        let btnPhone = document.querySelector('#btnPhone')
        btnAddress.onclick = (e)=>{
            diachi.removeAttribute('readonly')
            diachi.focus()
        }
        btnPhone.onclick = (e)=>{
            sdt.removeAttribute('readonly')
            sdt.focus()
        }
    </script>
</body>
</html>