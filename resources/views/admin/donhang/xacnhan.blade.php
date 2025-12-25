<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
    <link rel="stylesheet" href="{{ asset('asset/css/cssCart.css') }}">
    <style>
        body { font-family: Arial; background: #fafafa;}
        .box { background: white; padding: 20px; border-radius: 6px; margin:20px 0;}
        .btn { padding: 10px 15px; border-radius: 4px; color: #fff; cursor: pointer; }
        main{padding:20px;}
        .btn-ok { background: #28a745; }
        .btn-cancel { background: #dc3545; }  
        h1,h2,h3{margin: 16px 0;}
        .back:hover{
            color:red;
        }
        .d-flex{
            display:flex;
            gap:20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
    <a href="{{route('admin.home')}}"><h1> Quản lý đơn hàng</h1> </a>
        <div class="nav-links">
            <a href="{{ route('admin.logout') }}">Đăng xuất</a>
        </div>
    </div>
    <main>
        @if(isset($data["order"][0]) && isset($data["detail"][0]) && !$data["vanchuyen"])
            <a href="{{ route('admin.order') }}" class="back">⬅ Quay lại danh sách đơn hàng</a>
            <?php $dh = $data["order"][0]?>
            <h1>Xác nhận đơn hàng</h1>

            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Kkhách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Địa chỉ</th>
                            <th>SDT</th>
                        </tr>
                    </thead>
                    <tbody>
                       <tr>
                            <td>{{ $dh->id_don_hang }}</td>
                            <td>{{ $dh->fullname }}</td>
                            <td>{{ number_format($dh->tong_tien*1000,0,',','.') }}đ</td>
                            <td>{{ ($dh->loai_thanh_toan==1) ?"COD" :"BANKING (đã thanh toán)"}}</td>
                            <td>{{ $dh->dia_chi }}</td>
                            <td>{{ $dh->sdt }}</td>
                       </tr>
                    </tbody>
                </table>
                <div class="d-flex">
                    <form action="{{ route('admin.confirmStep2') }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="idDonHang" value="{{$dh->id_don_hang }}">
                        <button class="btn btn-ok">Xác nhận</button>
                    </form>
                    <form action="{{ route('admin.huyDonByAdmin') }}" method="post">
                        @csrf
                        <input type="hidden" name="idDonHang" value="{{$dh->id_don_hang}}">
                        <button class="btn" style="background-color:red;color:white;">Hủy đơn</button>
                    </form>
                </div>
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
                        @foreach($data["detail"] as $item)
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
        @elseif($data["vanchuyen"] == 1)
        <a href="{{ route('admin.order',3) }}" class="back">⬅ Quay lại</a>
        <?php $dh = $data["order"][0]?>
            <h1>Xác nhận vận chuyển</h1>

            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Kkhách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Địa chỉ</th>
                            <th>SDT</th>
                        </tr>
                    </thead>
                    <tbody>
                       <tr>
                            <td>{{ $dh->id_don_hang }}</td>
                            <td>{{ $dh->fullname }}</td>
                            <td>{{ number_format($dh->tong_tien*1000,0,',','.') }}đ</td>
                            <td>{{ ($dh->loai_thanh_toan==1) ?"COD" :"BANKING (đã thanh toán)"}}</td>
                            <td>{{ $dh->dia_chi }}</td>
                            <td>{{ $dh->sdt }}</td>
                       </tr>
                    </tbody>
                </table>
                <div class="d-flex">
                    <form action="{{ route('admin.confirm-delivery') }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="idDonHang" value=" {{$dh->id_don_hang }} ">
                        <button class="btn btn-ok">Xác nhận vận chuyển</button>
                    </form>
                </div>
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
                        @foreach($data["detail"] as $item)
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
        @elseif($data["vanchuyen"] == 2)
        <a href="{{ route('admin.order',5) }}" class="back">⬅ Quay lại</a>
        <?php $dh = $data["order"][0]?>

            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Kkhách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Ngày hoàn thành</th>
                            <th>Địa chỉ</th>
                            <th>SDT</th>
                        </tr>
                    </thead>
                    <tbody>
                       <tr>
                            <td>{{ $dh->id_don_hang }}</td>
                            <td>{{ $dh->fullname }}</td>
                            <td>{{ number_format($dh->tong_tien*1000,0,',','.') }}đ</td>
                            <td>{{ ($dh->loai_thanh_toan==1) ?"COD" :"BANKING (đã thanh toán)"}}</td>
                            <td>{{$dh->ngay_giao}}</td>
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
                        @foreach($data["detail"] as $item)
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
        @else
            <a href="{{ route('admin.home') }}" class="back">⬅ Quay lại trang chu</a>
            <h1>Vui lòng thử lại sau !</h1>
        @endif
        
    </main>
</body>
</html>
