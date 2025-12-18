<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>
    <style>
        /* (Giữ nguyên style cũ của bạn) */
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
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .spec-section {
            display: none;
            background: #e9f7fe;
            padding: 15px;
            border: 1px dashed #007bff;
            border-radius: 5px;
            margin-top: 20px;
        }

        .section-title {
            color: #007bff;
            margin-top: 0;
            border-bottom: 1px solid #bcdbf3;
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
        <h2>Thêm sản phẩm mới</h2>
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col"><label>Tên sản phẩm:</label><input type="text" name="ten" required></div>
                <div class="col"><label>Năm phát hành:</label><input type="number" name="nam" value="2025"></div>
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
                <div class="col"><label>Kho:</label><input type="number" name="soluong" value="100" required></div>
            </div>
            <div class="row">
                <div class="col"><label>Hãng:</label>
                    <select name="hang">
                        @foreach($hangs as $h) <option value="{{ $h->id_hang }}">{{ $h->ten_hang }}</option> @endforeach
                    </select>
                </div>
                <div class="col"><label>Loại sản phẩm:</label>
                    <select name="loai" id="loaiSelect" onchange="showSpecFields()">
                        @foreach($loais as $l) <option value="{{ $l->id_loai_sp }}">{{ $l->ten_loai_sp }}</option> @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col form-group">
                    <label>Hình ảnh:</label>
                    <input type="file" name="anh" accept="image/*" required>
                </div>

                <div class="col form-group">
                    <label>Trạng thái ban đầu:</label>
                    <select name="trang_thai">
                        <option value="1">Hiển thị ngay</option>
                        <option value="0">Tạm ẩn (Nháp)</option>
                    </select>
                </div>
            </div>

            <div id="spec-1" class="spec-section">
                <h4 class="section-title">Cấu hình Điện Thoại</h4>
                <div class="row">
                    <div class="col"><label>RAM (GB):</label><input type="number" name="dt_ram"></div>
                    <div class="col"><label>ROM (GB):</label><input type="number" name="dt_rom"></div>
                    <div class="col"><label>Pin (mAh):</label><input type="number" name="dt_pin"></div>
                </div>
                <div class="row">
                    <div class="col"><label>Màn hình (inch):</label><input type="text" name="dt_manhinh"></div>
                    <div class="col"><label>Độ phân giải:</label><input type="text" name="dt_dophangiai" placeholder="VD: 2796 x 1290"></div>
                </div>
                <div class="row">
                    <div class="col"><label>Chipset:</label><input type="text" name="dt_chip"></div>
                    <div class="col"><label>CPU:</label><input type="text" name="dt_cpu" placeholder="VD: 6 nhân"></div>
                </div>
                <div class="row">
                    <div class="col"><label>Cam sau:</label><input type="text" name="dt_camsau" placeholder="VD: 48MP"></div>
                    <div class="col"><label>Cam trước:</label><input type="text" name="dt_camtruoc" placeholder="VD: 12MP"></div>
                </div>
                <div class="row">
                    <div class="col"><label>Hệ điều hành:</label><input type="text" name="dt_os" placeholder="VD: iOS 17"></div>
                    <div class="col"><label>Thẻ SIM:</label><input type="text" name="dt_sim"></div>
                    <div class="col">
                        <label>NFC:</label>
                        <select name="dt_nfc">
                            <option value="1">Có hỗ trợ</option>
                            <option value="0">Không</option>
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
                            <option value="1">Có</option>
                            <option value="0">Không</option>
                        </select>
                    </div>
                    <div class="col">
                        <label>Điều khiển:</label><input type="text" name="tn_dieukhien" placeholder="VD: Cảm ứng chạm">
                    </div>
                </div>
                <div class="row" id="tn-day">
                    <div class="col"><label>Cổng kết nối:</label><input type="text" name="tn_ketnoi" placeholder="VD: Type-C"></div>
                </div>
                <div class="row" id="tn-koday" style="display:none;">
                    <div class="col"><label>Thời lượng pin (h):</label><input type="text" name="tn_thoigian"></div>
                    <div class="col"><label>Công nghệ âm thanh:</label><input type="text" name="tn_amthanh"></div>
                </div>
            </div>

            <div id="spec-4" class="spec-section">
                <h4 class="section-title">Thông số Sạc dự phòng</h4>
                <div class="row">
                    <div class="col"><label>Dung lượng (mAh):</label><input type="number" name="sdp_dungluong"></div>
                    <div class="col"><label>Công suất sạc (W):</label><input type="text" name="sdp_congsuat"></div>
                </div>
                <div class="row">
                    <div class="col"><label>Cổng sạc ra:</label><input type="text" name="sdp_cong_ra" placeholder="VD: 1 USB-A, 1 Type-C"></div>
                    <div class="col"><label>Cổng sạc vào:</label><input type="text" name="sdp_cong_vao" placeholder="VD: Type-C"></div>
                </div>
            </div>

            <button type="submit">Lưu sản phẩm</button>
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
        function showSpecFields() {
            var loaiId = document.getElementById('loaiSelect').value;
            document.querySelectorAll('.spec-section').forEach(el => el.style.display = 'none');

            if (loaiId == 1) {
                document.getElementById('spec-1').style.display = 'block';
            } else if (loaiId == 2) {
                document.getElementById('spec-headphone').style.display = 'block';
                document.getElementById('tn-day').style.display = 'flex';
                document.getElementById('tn-koday').style.display = 'none';
            } else if (loaiId == 3) {
                document.getElementById('spec-headphone').style.display = 'block';
                document.getElementById('tn-day').style.display = 'none';
                document.getElementById('tn-koday').style.display = 'flex';
            } else if (loaiId == 4) {
                document.getElementById('spec-4').style.display = 'block';
            }
        }
        window.onload = showSpecFields;
    </script>

</body>

</html>