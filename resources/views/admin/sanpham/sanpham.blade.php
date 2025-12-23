<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        a { text-decoration: none; }
        
        /* Button Styles */
        .btn { padding: 6px 10px; color: #fff; border-radius: 4px; display: inline-block; font-size: 13px; transition: 0.2s; border: none; cursor: pointer;}
        .btn-add { background: #28a745; padding: 8px 12px; font-weight: 600; } .btn-add:hover { background: #218838; }
        .btn-edit { background: #007bff; } .btn-edit:hover { background: #0056b3; }
        .btn-del { background: #dc3545; } .btn-del:hover { background: #c82333; }
        .btn-eye { min-width: 30px; text-align: center; }

        /* Filter Box */
        .filter-box { background: white; padding: 15px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;}
        select.filter-select { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; outline: none; font-size: 14px;}

        /* Table Styles */
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05); font-size: 14px; }
        th { background: #343a40; color: white; padding: 12px; text-align: left; font-weight: 600; text-transform: uppercase; font-size: 12px;}
        td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: top; color: #444; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #f8f9fa; }

        /* Spec List Styles */
        .spec-box { font-size: 13px; line-height: 1.6; }
        .spec-item { margin-bottom: 4px; display: flex; }
        .spec-label { font-weight: 700; color: #555; width: 90px; flex-shrink: 0; }
        .spec-val { color: #333; }
        
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-block; margin-top: 5px;}
        .badge-type { background: #e2e6ea; color: #495057; }
        .badge-brand { background: #d1ecf1; color: #0c5460; }

        .price-text { color: #d63384; font-weight: 700; font-size: 15px; }
    </style>
</head>
<body>

    <h2 style="color: #333; margin-bottom: 5px;">Quản lý sản phẩm</h2>
    <a href="{{ route('admin.home') }}" style="color: #6c757d; font-size: 14px;"><i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ</a>
    <br><br>

    @if(session('success'))
        <div style="padding: 10px; background: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 15px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="filter-box">
        <div>
            <span style="font-weight: 600; margin-right: 10px;">🔍 Lọc sản phẩm:</span>
            <form action="{{ route('admin.product') }}" method="GET" style="display: inline-block;">
                <select name="category" class="filter-select" onchange="this.form.submit()">
                    <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>-- Tất cả loại --</option>
                    @foreach($categories as $cate)
                        <option value="{{ $cate->id_loai_sp }}" {{ request('category') == $cate->id_loai_sp ? 'selected' : '' }}>
                            {{ $cate->ten_loai_sp }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <a href="{{ route('admin.product.create') }}" class="btn btn-add"><i class="fa-solid fa-plus"></i> Thêm mới</a>
    </div>

    <table>
        <thead>
            <tr>
                <th width="80" style="text-align: center;">Ảnh</th>
                <th width="200">Sản phẩm</th>
                <th width="350">Thông số kỹ thuật chi tiết</th>
                <th width="120">Giá bán</th>
                <th width="80" style="text-align: center;">Kho</th>
                <th width="140" style="text-align: center;">Hành động</th> </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td style="text-align: center;">
                    <img src="{{ asset('asset/images/' . $product->src_anh) }}" 
                         style="width: 60px; height: 60px; object-fit: contain; border: 1px solid #eee; border-radius: 4px; background: white;">
                </td>
                
                <td>
                    <div style="font-weight: 700; color: #007bff; margin-bottom: 4px;">{{ $product->ten }}</div>
                    <div style="font-size: 12px; color: #888;">Năm SX: {{ $product->nam_phat_hang }}</div>
                    <div>
                        <span class="badge badge-brand">{{ $product->ten_hang }}</span>
                        <span class="badge badge-type">{{ $product->ten_loai_sp }}</span>
                    </div>
                </td>

                <td>
                    <div class="spec-box">
                    @if($product->thong_so)
                        
                        @if($product->id_loai_sp == 1)
                            <div class="spec-item"><span class="spec-label">Màn hình:</span> <span class="spec-val">{{ $product->thong_so->kich_thuoc_man_hinh ?? '?' }} inch ({{ $product->thong_so->do_phan_giai_mh ?? '' }})</span></div>
                            <div class="spec-item"><span class="spec-label">Cấu hình:</span> <span class="spec-val">{{ $product->thong_so->chip_set ?? '?' }} / {{ $product->thong_so->cpu ?? '' }}</span></div>
                            <div class="spec-item"><span class="spec-label">Bộ nhớ:</span> <span class="spec-val">RAM {{ $product->thong_so->ram ?? '?' }}GB - ROM {{ $product->thong_so->bo_nho_trong ?? '?' }}GB</span></div>
                            <div class="spec-item"><span class="spec-label">Camera:</span> <span class="spec-val">Sau {{ $product->thong_so->camera_sau ?? '?' }} - Trước {{ $product->thong_so->camera_truoc ?? '?' }}</span></div>
                            <div class="spec-item"><span class="spec-label">Pin/OS:</span> <span class="spec-val">{{ $product->thong_so->pin ?? '?' }} mAh - {{ $product->thong_so->he_dieu_hanh ?? '' }}</span></div>
                            <div class="spec-item">
                                <span class="spec-label">Khác:</span> 
                                <span class="spec-val">
                                    {{ $product->thong_so->the_sim ?? '' }} 
                                    @if(isset($product->thong_so->cong_nghe_nfc))
                                        | NFC: {{ $product->thong_so->cong_nghe_nfc == 1 ? 'Có' : 'Không' }}
                                    @endif
                                </span>
                            </div>

                        @elseif($product->id_loai_sp == 2)
                            <div class="spec-item"><span class="spec-label">Kết nối:</span> <span class="spec-val">{{ $product->thong_so->cong_ket_noi ?? '?' }}</span></div>
                            <div class="spec-item"><span class="spec-label">Micro:</span> <span class="spec-val">{{ ($product->thong_so->mirco ?? 0) == 1 ? 'Có hỗ trợ' : 'Không' }}</span></div>
                            <div class="spec-item"><span class="spec-label">Điều khiển:</span> <span class="spec-val">{{ $product->thong_so->dieu_kien ?? '?' }}</span></div>

                        @elseif($product->id_loai_sp == 3)
                            <div class="spec-item"><span class="spec-label">Thời lượng:</span> <span class="spec-val">{{ $product->thong_so->thoi_gian_su_dung ?? '?' }} giờ</span></div>
                            <div class="spec-item"><span class="spec-label">Công nghệ:</span> <span class="spec-val">{{ $product->thong_so->cong_nghe_am_thanh ?? '?' }}</span></div>
                            <div class="spec-item"><span class="spec-label">Micro:</span> <span class="spec-val">{{ ($product->thong_so->micro ?? 0) == 1 ? 'Có hỗ trợ' : 'Không' }}</span></div>
                            <div class="spec-item"><span class="spec-label">Điều khiển:</span> <span class="spec-val">{{ $product->thong_so->dieu_khien ?? '?' }}</span></div>

                        @elseif($product->id_loai_sp == 4)
                            <div class="spec-item"><span class="spec-label">Dung lượng:</span> <span class="spec-val">{{ number_format($product->thong_so->dung_luong ?? 0) }} mAh</span></div>
                            <div class="spec-item"><span class="spec-label">Công suất:</span> <span class="spec-val">{{ $product->thong_so->cong_suat_sac ?? '?' }} W</span></div>
                            <div class="spec-item"><span class="spec-label">Cổng vào:</span> <span class="spec-val">{{ $product->thong_so->cong_sac_vao ?? '?' }}</span></div>
                            <div class="spec-item"><span class="spec-label">Cổng ra:</span> <span class="spec-val">{{ $product->thong_so->cong_sac_ra ?? '?' }}</span></div>
                        
                        @else
                            <span style="color: #999;">Loại sản phẩm chưa cập nhật hiển thị</span>
                        @endif

                    @else
                        <span style="color: red; font-size: 12px; font-style: italic;"><i class="fa-solid fa-circle-exclamation"></i> Chưa có thông số (Lỗi dữ liệu)</span>
                    @endif
                    </div>
                </td>

                <td class="price-text">{{ number_format($product->gia_ban*1000, 0, ',', '.') }}đ</td>
                
                <td style="text-align: center;">
                    <span style="{{ 'font-weight: bold;' . ($product->so_luong_ton_kho == 0 ? ' color:red;' : '') }}">
                        {{ $product->so_luong_ton_kho }}
                    </span>
                </td>
                
                <td style="text-align: center;">
                    <div style="display: flex; gap: 5px; justify-content: center;">
                        <a href="{{ route('admin.product.toggle', $product->id_chi_tiet_thiet_bi) }}" 
                           class="btn btn-eye" 
                           style="background: {{ $product->trang_thai == 1 ? '#17a2b8' : '#6c757d' }};"
                           title="{{ $product->trang_thai == 1 ? 'Đang hiện (Bấm để ẩn)' : 'Đang ẩn (Bấm để hiện)' }}">
                           
                           @if($product->trang_thai == 1)
                               <i class="fa-solid fa-eye"></i>
                           @else
                               <i class="fa-solid fa-eye-slash"></i>
                           @endif
                        </a>

                        <a href="{{ route('admin.product.edit', $product->id_chi_tiet_thiet_bi) }}" class="btn btn-edit" title="Sửa">
                            <i class="fa-solid fa-pen"></i>
                        </a> 
                        
                        <a href="{{ route('admin.product.delete', $product->id_chi_tiet_thiet_bi) }}" 
                           class="btn btn-del" title="Xóa"
                           onclick="return confirm('Cảnh báo: Xóa sản phẩm này sẽ xóa luôn thông số kỹ thuật kèm theo. Bạn có chắc không?')">
                           <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $products->links() }}
    </div>

</body>
</html>