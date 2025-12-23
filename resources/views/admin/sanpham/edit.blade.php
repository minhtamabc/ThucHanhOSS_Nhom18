<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cập nhật sản phẩm</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background: #f7f7f7;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background: #ffc107;
            color: black;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .spec-section {
            display: none;
            background: #fff8e1;
            padding: 15px;
            border: 1px dashed #ffc107;
            border-radius: 5px;
            margin-top: 20px;
        }

        .section-title {
            color: #d39e00;
            margin-top: 0;
            border-bottom: 1px solid #ffeeba;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .row {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }

        .col {
            flex: 1;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Cập nhật sản phẩm</h2>
        <form action="{{ route('admin.product.update', $product->id_chi_tiet_thiet_bi) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col"><label>Tên sản phẩm:</label><input type="text" name="ten" value="{{ $product->ten }}" required></div>
                <div class="col"><label>Năm phát hành:</label><input type="number" name="nam" value="{{ $product->nam_phat_hang }}"></div>
            </div>
            <div class="row">
                <div class="col form-group">
                    <label>Giá bán (nghìn đồng):</label>
                    <input type="text" name="gia_display" id="gia_display" required
                        placeholder="VD: 22.000 (tức là 22 triệu)"
                        onkeyup="formatCurrency(this)">

                    <input type="hidden" name="gia" id="gia_real">

                    <small style="color: #666; font-style: italic;">
                        * Nhập 22000 sẽ hiển thị là 22.000.000đ ngoài trang chủ
                    </small>
                </div>
                <div class="col"><label>Kho:</label><input type="number" name="soluong" value="{{ $product->so_luong_ton_kho }}" required></div>
            </div>
            <div class="row">
                <div class="col"><label>Hãng:</label>
                    <select name="hang">
                        @foreach($hangs as $h)
                        <option value="{{ $h->id_hang }}" {{ $h->id_hang == $product->id_hang ? 'selected' : '' }}>{{ $h->ten_hang }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <input type="hidden" name="loai" id="loaiSelect" value="{{ $product->id_loai }}">

            <div class="form-group">
                <label>Hình ảnh (Để trống nếu không đổi):</label>
                <input type="file" name="anh" accept="image/*">
                <br><img src="{{ asset('asset/images/' . $product->src_anh) }}" width="80" style="margin-top:5px; border:1px solid #ddd">
            </div>

            <div id="spec-1" class="spec-section">
                <h4 class="section-title">Cấu hình Điện Thoại</h4>
                <div class="row">
                    <div class="col"><label>RAM:</label><input type="number" name="dt_ram" value="{{ $spec->ram ?? '' }}"></div>
                    <div class="col"><label>ROM:</label><input type="number" name="dt_rom" value="{{ $spec->bo_nho_trong ?? '' }}"></div>
                    <div class="col"><label>Pin:</label><input type="number" name="dt_pin" value="{{ $spec->pin ?? '' }}"></div>
                </div>
                <div class="row">
                    <div class="col"><label>Màn hình:</label><input type="text" name="dt_manhinh" value="{{ $spec->kich_thuoc_man_hinh ?? '' }}"></div>
                    <div class="col"><label>Độ phân giải:</label><input type="text" name="dt_dophangiai" value="{{ $spec->do_phan_giai_mh ?? '' }}"></div>
                </div>
                <div class="row">
                    <div class="col"><label>Chipset:</label><input type="text" name="dt_chip" value="{{ $spec->chip_set ?? '' }}"></div>
                    <div class="col"><label>CPU:</label><input type="text" name="dt_cpu" value="{{ $spec->cpu ?? '' }}"></div>
                </div>
                <div class="row">
                    <div class="col"><label>Cam sau:</label><input type="text" name="dt_camsau" value="{{ $spec->camera_sau ?? '' }}"></div>
                    <div class="col"><label>Cam trước:</label><input type="text" name="dt_camtruoc" value="{{ $spec->camera_truoc ?? '' }}"></div>
                </div>
                <div class="row">
                    <div class="col"><label>Hệ điều hành:</label><input type="text" name="dt_os" value="{{ $spec->he_dieu_hanh ?? '' }}"></div>
                    <div class="col"><label>Thẻ SIM:</label><input type="text" name="dt_sim" value="{{ $spec->the_sim ?? '' }}"></div>
                    <div class="col">
                        <label>NFC:</label>
                        <select name="dt_nfc">
                            <option value="1" {{ ($spec->cong_nghe_nfc ?? 0) == 1 ? 'selected' : '' }}>Có hỗ trợ</option>
                            <option value="0" {{ ($spec->cong_nghe_nfc ?? 0) == 0 ? 'selected' : '' }}>Không</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="spec-headphone" class="spec-section">
                <h4 class="section-title">Thông số Tai nghe</h4>
                <div class="row">
                    <div class="col">
                        <label>Micro:</label>
                        <select name="tn_micro">
                            <option value="1" {{ ($spec->mirco ?? $spec->micro ?? 0) == 1 ? 'selected' : '' }}>Có</option>
                            <option value="0" {{ ($spec->mirco ?? $spec->micro ?? 0) == 0 ? 'selected' : '' }}>Không</option>
                        </select>
                    </div>
                    <div class="col">
                        <label>Điều khiển:</label>
                        <input type="text" name="tn_dieukhien" value="{{ $spec->dieu_khien ?? $spec->dieu_kien ?? '' }}">
                    </div>
                </div>
                <div class="row" id="tn-day">
                    <div class="col"><label>Kết nối:</label><input type="text" name="tn_ketnoi" value="{{ $spec->cong_ket_noi ?? '' }}"></div>
                </div>
                <div class="row" id="tn-koday">
                    <div class="col"><label>Thời lượng (h):</label><input type="text" name="tn_thoigian" value="{{ $spec->thoi_gian_su_dung ?? '' }}"></div>
                    <div class="col"><label>CN Âm thanh:</label><input type="text" name="tn_amthanh" value="{{ $spec->cong_nghe_am_thanh ?? '' }}"></div>
                </div>
            </div>

            <div id="spec-4" class="spec-section">
                <h4 class="section-title">Thông số Sạc dự phòng</h4>
                <div class="row">
                    <div class="col"><label>Dung lượng:</label><input type="number" name="sdp_dungluong" value="{{ $spec->dung_luong ?? '' }}"></div>
                    <div class="col"><label>Công suất:</label><input type="text" name="sdp_congsuat" value="{{ $spec->cong_suat_sac ?? '' }}"></div>
                </div>
                <div class="row">
                    <div class="col"><label>Cổng ra:</label><input type="text" name="sdp_cong_ra" value="{{ $spec->cong_sac_ra ?? '' }}"></div>
                    <div class="col"><label>Cổng vào:</label><input type="text" name="sdp_cong_vao" value="{{ $spec->cong_sac_vao ?? '' }}"></div>
                </div>
            </div>

            <button type="submit">Lưu thay đổi</button>
            <a href="{{ route('admin.product') }}" style="display:block; text-align:center; margin-top:15px;">Hủy bỏ</a>
        </form>
    </div>

    <script>
        function formatCurrency(input) {
        // Xóa hết ký tự không phải số
        let value = input.value.replace(/\D/g, '');
        
        // Cập nhật giá trị thực vào input ẩn để gửi đi
        document.getElementById('gia_real').value = value;
        
        // Format hiển thị có dấu chấm (VD: 22.000)
        input.value = new Intl.NumberFormat('vi-VN').format(value);
    }
        window.onload = function() {
            var loaiId = document.getElementById('loaiSelect').value;
            if (loaiId == 1) {
                document.getElementById('spec-1').style.display = 'block';
            } else if (loaiId == 2) {
                document.getElementById('spec-headphone').style.display = 'block';
                document.getElementById('tn-day').style.display = 'flex';
            } else if (loaiId == 3) {
                document.getElementById('spec-headphone').style.display = 'block';
                document.getElementById('tn-koday').style.display = 'flex';
            } else if (loaiId == 4) {
                document.getElementById('spec-4').style.display = 'block';
            }
        };
    </script>

</body>

</html>