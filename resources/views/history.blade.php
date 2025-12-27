<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('asset/css/cssCart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Giỏ hàng</title>
    <style>
        main{
            padding:20px;
        }
    </style>
</head>
<body>
    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif
    <div class="navbar">
        <h1>📱 Lịch sử mua hàng</h1>
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
    <main>
        @if(isset($data["order"]))
            @if(count($data["order"]))
                <?php $dh = $data["order"]?>
                <div class="cart-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Tổng tiền</th>
                                <th>Phương thức thanh toán</th>
                                <th>Ngày đặt hàng</th>
                                <th>Ngày giao</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dh as $v)
                                <tr>
                                    <td>{{ strtoupper($v->id_don_hang) }}</td>
                                    <td>{{ number_format($v->tong_tien*1000,0,',','.') }}đ</td>
                                    <td>{{ ($v->loai_thanh_toan==1) ?"Thanh toán khi nhận  hàng" :"BANKING"}}</td>
                                    <td>{{ $v->ngay_dat}}</td>
                                    @if($v->trang_thai_don_hang == 7)
                                        <td>Đã hủy</td>
                                    @elseif($v->trang_thai_don_hang == 4)
                                        <td>Đã hủy do thiếu thông tin</td>
                                    @else
                                        <td>{{ $v->ngay_giao }}</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('order.history-detail',$v->id_don_hang) }}">
                                            <i class="fa-solid fa-eye" style="color:blue;"></i>Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h1>Bạn chưa có đơn hàng !</h1>
            @endif
        @elseif(isset($data["donHang"]))
            <?php $dh = $data["donHang"][0]?>
            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tổng tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Ngày đặt</th>
                            <th>Địa chỉ</th>
                            <th>SDT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $dh->id_don_hang }}</td>
                            <td>{{ number_format($dh->tong_tien*1000,0,',','.') }}đ</td>
                            <td>{{ ($dh->loai_thanh_toan==1) ?"Thanh toán khi nhận hàng" :"BANKING (đã thanh toán)"}}</td>
                            <td>{{$dh->ngay_dat}}</td>
                            <td>{{ $dh->dia_chi }}</td>
                            <td>{{ $dh->sdt }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <h2>Chi tiết đơn hàng</h2>
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
                    @foreach($data["chitiet"] as $item)
                    <tr>
                        <td>
                            <div class="product-info">
                                <span class="product-name">{{ $item->ten }}</span>
                                <img class="product-meta" src=" {{ asset('asset/images/'.$item->src_anh) }} "/>
                            </div>
                        </td>
                        <td>{{ number_format($item->gia_ban*1000, 0, ',', '.') }}₫</td>
                        <td>{{ $item->so_luong}}</td>
                        <td style="font-weight: 600; color: #667eea;">{{ number_format($item->tong_tien*1000, 0, ',', '.') }}₫</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </main>
</body>
</html>