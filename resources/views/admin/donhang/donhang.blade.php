<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="{{ asset('asset/css/cssCart.css') }}">
    <style>
        body { font-family: Arial; background: #f7f7f7;}
        table { width: 100%; background: #fff; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 12px; text-align: center; }
        th { background: #eee; }
        .btn { padding: 6px 12px; color: white; border-radius: 4px; }
        .btn-xacnhan { background: #007bff; cursor: pointer;}
        a { text-decoration: none;}
        main{ padding:20px;}  
        .back{
            margin:16px;
        } 
        .back:hover{
            color:red;
        }
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
         </style>
</head>
<body>
    <div class="navbar">
        <a href="{{route('admin.home')}}"><h1>Quản lý đơn hàng </h1> </a>
        <div class="nav-links">
            @if(isset($data["orders"]))
                <a href="{{ route('admin.order',2) }}">Đơn hàng đã duyệt</a>
                <a href="{{ route('admin.order',3) }}">Đơn hàng đang vận chuyển</a>
                <a href="{{ route('admin.order',5) }}">Đơn hàng đã hoàn thành</a>
            @elseif(isset($data["confirm"]))
                <a href="{{ route('admin.order',1) }}">Đơn hàng chờ duyệt</a>
                <a href="{{ route('admin.order',3) }}">Đơn hàng đang vận chuyển</a>
                <a href="{{ route('admin.order',5) }}">Đơn hàng đã hoàn thành</a>
            @elseif(isset($data["delivery"]))
                <a href="{{ route('admin.order',1) }}">Đơn hàng chờ duyệt</a>
                <a href="{{ route('admin.order',2) }}">Đơn hàng đã duyệt </a>
                <a href="{{ route('admin.order',5) }}">Đơn hàng đã hoàn thành</a>
            @elseif(isset($data["finish"]))
                <a href="{{ route('admin.order',1) }}">Đơn hàng chờ duyệt</a>
                <a href="{{ route('admin.order',2) }}">Đơn hàng đã duyệt </a>
                <a href="{{ route('admin.order',3) }}">Đơn hàng đang vận chuyển</a>
            @endif
                <a href="{{ route('admin.logout') }}">Đăng xuất</a>
        </div>
    </div>
    <main>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        @if(isset($data["orders"]))
            @if(count($data["orders"]) > 0)
                <a href=" {{ route('admin.home') }} " class="back">⬅ Quay lại trang chủ</a>
                <h2>Danh sách đơn hàng chờ duyệt</h2>
                <table>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức thanh toán</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                    @foreach($data["orders"] as $item)
                            @if($item->trang_thai_don_hang == 1)
                            <tr>
                                <td>{{ $item->id_don_hang }}</td>
                                <td>{{ $item->fullname }}</td>
                                <td>{{ number_format($item->tong_tien*1000,0,'.','.') }}đ</td>
                                <td>{{ ($item->loai_thanh_toan == 1) ? "Thanh toán khi nhận hàng" : "BANKING"}}</td>
                                <td>Chở xác nhận</td>
                                <td>
                                    <form action="{{ route('admin.confirm') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idDonHang" value="{{ $item->id_don_hang }}">
                                        <button  class="btn btn-xacnhan">Xác nhận</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                    @endforeach
                </table>
            @else
                <a href="{{ route('admin.home') }}" class="back">⬅ Quay lại trang chu</a>
                <h2>0 đơn cần duyệt.</h2>
            @endif
        @elseif(isset($data["confirm"]) )
            @if(count($data["confirm"]) > 0)
                <a href=" {{ route('admin.order',1) }} " class="back">⬅ Quay lại</a>
                <h2>Danh sách cần chuẩn bị hàng</h2>
                <table>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức thanh toán</th>
                        <th>Thu hộ</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                    @foreach($data["confirm"] as $item)
                            @if($item->trang_thai_don_hang == 2)
                            <tr>
                                <td>{{ $item->id_don_hang }}</td>
                                <td>{{ $item->fullname }}</td>
                                <td>{{ number_format($item->tong_tien*1000,0,'.','.') }}đ</td>
                                <td>{{ ($item->loai_thanh_toan == 1) ? "Thanh toán khi nhận hàng" : "BANKING (đã  thanh toán)"}}</td>
                                <td>{{ ($item->loai_thanh_toan == 1) ? number_format($item->tong_tien*1000,0,'.','.')."đ" : "0đ"}}</td>
                                <td>Chuẩn bị hàng</td>
                                <td>
                                    <form action=" {{ route('admin.detail-order') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idDonHang" value="{{ $item->id_don_hang }}">
                                        <button  class="btn btn-xacnhan">Chi tiết</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                    @endforeach
                </table>
            @else
                <a href="{{ route('admin.home') }}" class="back">⬅ Quay lại trang chu</a>
                <h2>0 đơn cần chuẩn bị hàng.</h2>
            @endif
        @elseif(isset($data["delivery"]))
            @if(count($data["delivery"]) > 0)
            <a href=" {{ route('admin.order',2) }} " class="back">⬅ Quay lại</a>
            <h2>Danh sách đơn hàng đang vận chuyển vận chuyển</h2>
                <table>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức thanh toán</th>
                        <th>Thu hộ</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                    @foreach($data["delivery"] as $item)
                            @if($item->trang_thai_don_hang == 3)
                            <tr>
                                <td>{{ $item->id_don_hang }}</td>
                                <td>{{ $item->fullname }}</td>
                                <td>{{ number_format($item->tong_tien*1000,0,'.','.') }}đ</td>
                                <td>{{ ($item->loai_thanh_toan == 1) ? "Thanh toán khi nhận hàng" : "BANKING (đã thanh toán)"}}</td>
                                <td>{{ ($item->loai_thanh_toan == 1) ? number_format($item->tong_tien*1000,0,'.','.')."đ": "0đ"}}</td>
                                <td>Đang vận chuyển</td>
                                <td>
                                    <form action="{{ route('admin.finish-order') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idDonHang" value="{{ $item->id_don_hang }}">
                                        <button  class="btn btn-xacnhan">Xác nhận giao hàng thành công</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                    @endforeach
                </table>
            @else
                <a href="{{ route('admin.home') }}" class="back">⬅ Quay lại trang chu</a>
                <h2>0 đơn đang vận chuyển</h2>
            @endif
        @elseif(isset($data["finish"]))
            @if(count($data["finish"]) > 0)
                <a href=" {{ route('admin.order',1) }} " class="back">⬅ Quay lại</a>
                <h2>Danh sách đơn hàng đã hoàn thành</h2>
                <table>
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức thanh toán</th>
                        <th>Thu hộ</th>
                        <th>Ngày giao</th>
                        <th></th>
                    </tr>
                    @foreach($data["finish"] as $item)
                            @if($item->trang_thai_don_hang == 8)
                            <tr>
                                <td>{{ $item->id_don_hang }}</td>
                                <td>{{ $item->fullname }}</td>
                                <td>{{ number_format($item->tong_tien*1000,0,'.','.') }}đ</td>
                                <td>{{ ($item->loai_thanh_toan == 1) ? "Thanh toán khi nhận hàng" : "BANKING (đã thanh toán)"}}</td>
                                <td>{{ ($item->loai_thanh_toan == 1) ? number_format($item->tong_tien*1000,0,'.','.')."đ": "0đ"}}</td>
                                <td>{{ $item->ngay_giao }}</td>
                                <td>
                                    <form action="{{ route('admin.detail', $item->id_don_hang) }}" method="get">
                                        @csrf
                                        <button  class="btn btn-xacnhan">Chi tiết</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                    @endforeach
                </table>
            @else
                <a href="{{ route('admin.home') }}" class="back">⬅ Quay lại trang chu</a>
                <h2>0 đơn hàng đã hoàn thành.</h2>
            @endif
        @else
            <a href="{{ route('admin.home') }}" class="back">⬅ Quay lại trang chu</a>
            <h3>Chưa có đơn hàng nào !</h3>
        @endif
    </main>

</body>
</html>
