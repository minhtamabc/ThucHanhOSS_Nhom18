<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('asset/css/banDienThoaiGlobal.css') }}"/>
    <link rel="stylesheet" href="{{ asset('asset/css/banDienThoai_Header.css') }}"/>
    <link rel="stylesheet" href="{{ asset('asset/css/cssMobile.css') }}"/>
    <link rel="stylesheet" href="{{ asset('asset/css/reponsive-grid.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Chi tiet san pham</title>
</head>
<body>
<header>
        <div class="wrap-menu-header">
            <nav class="tim-kiem-dang-nhap-gio-hang d-flex">
                <span class="logo"><a href="{{route('home')}}">TechSTU</a></span>
                <div class="dang-nhap-gio-hang d-flex">
                    <div class="tim-kiem flex-1">
                        <!-- <input type="text" placeholder="... tim kiem">
                        <button>
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button> -->
                    </div>
                    <!-- Giỏ hàng - Kiểm tra đăng nhập -->
                     @if(session('user_id') && $data["donHang"] != '0' && $data["donHang"] != '')
                        <a href="{{ route('cart.index') }}" class="gio-hang d-flex align-center">
                            <i class="fa-solid fa-cart-shopping" style="color:green;"></i>
                            <span class="bg-green" style="background-color:green;color:white;" id="gio-hang">{{ $data["donHang"] }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="gio-hang d-flex align-center">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="" id="gio-hang">0</span>
                        </a>
                    @endif
                    
                    <!-- Đăng nhập/Đăng xuất -->
                    @if(session('user_id'))
                        <div class="dang-nhap d-flex align-center" style="gap: 10px;">
                            <i class="fa-solid fa-circle-user"></i>
                            <span>{{ session('user_name') }}</span>
                            <a href="{{ route('logout') }}" style="margin-left: 10px; color: #dc3545;">Đăng xuất</a>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="dang-nhap d-flex align-center">
                            <i class="fa-solid fa-circle-user"></i>
                            <span>Log in</span>
                        </a>
                    @endif
                </div>
            </nav>
        </div>

        <nav class="danh-sach-loai-san-pham">
            <ul class="d-flex align-center list-menu">
                @if(isset($data["branch"]))
                    <li><a href="">SHOP ALL</a></li>
                    @foreach($data["branch"] as $ten_hang)
                        <li><a href="">{{$ten_hang->ten_hang}}</a></li>
                    @endforeach
                @endif
            </ul>
        </nav>

        <!-- menu cua dien thoai -->
        <nav class="menu-cua-dien-thoai">
            <div class="header-dien-thoai">
                <span class="logo">TechSTU</span>
            
                <div class="menu-mobile">
                    <div class="menu-mobile-tim-kiem">
                        <div class="tim-kiem">
                            <button>
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                        <div class="modal-mobile"></div>
                    </div>
                    <div class="menu-mobile-gio-hang">
                        <a href="" class="gio-hang display-center">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="" id="gio-hang">0</span>
                        </a>
                    </div>
                    <div class="menu-mobile-button">
                        <div class="menu-mobile-1"></div>
                        <div class="menu-mobile-1"></div>
                        <div class="menu-mobile-1"></div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="chi-tiet">
        @if(isset($data["chiTietThietBi"]))
            <?php
                //sp --> san pham
                //ct --> chi tiet cua san pham
                $sp =  $data["chiTietThietBi"][0];
                $ct = $data["thongSoThietBi"][0];
            ?>
        <div style="width: 900px;margin: auto;">
            <section style="padding: 3rem 0;font-size: 1.6rem;">
                <a href="{{route('home')}}">Home\</a>
                <span style="font-size: 1.2rem;opacity: 0.6;">{{ $sp->ten }}</sapn>
            </section>
    
            <section class="d-flex">
                <div style="margin-right:2rem;">
                    <img src="{{ asset('asset/images/'.$sp->src_anh) }}" alt="anh-san-pham" width="500px">
                </div>
                <div>
                    <p style="font-size: 2rem;font-weight: bold;">{{ $sp->ten }}</p>
                    <div style="font-size: 1rem; margin: 1rem 0;">
                        <span class=""> <strong>{{number_format($sp->gia_ban*1000,0,',','.')}}₫</strong></span>
                        <!-- <span>gia sale</span> -->
                    </div>

                    <form action="{{ route('cart.add') }}" method="post">
                        @csrf
                        <button class="btnShop txt-white bg-purple wid-100" name="btnThemVaoGio" value="{{$sp->id_chi_tiet_thiet_bi}}" id="btn-them">Thêm vào giỏ</button>
                    </form>
                    <form action="{{ route('cart.add') }}" method="post">
                        @csrf
                        <button class="btnShop txt-white bg-black wid-100" name="btnThemVaoGio" value="{{$sp->id_chi_tiet_thiet_bi}}">Mua ngay</button>
                    </form>

                    <div style="margin-top: 3rem;">
                        <div class="d-flex align-center justify-between" style="cursor: pointer;">
                            <h4>Thông tin sản phẩm</h4>
                            <span id="product-info" style="font-size: 2rem;">+</span>
                        </div>
                        
                        <p class="chi-tiet-mo-ta" id="chi-tiet-mo-ta">
                            I'm a product detail. 
                            I'm a great place to add more information about your product such as sizing, 
                            material, care and cleaning instructions. This is also a great space to 
                            write what makes this product special and how your customers can benefit from this item.
                        </p>
                    </div>
                    <div class="thong-bao"></div>
                </div>
            </section>
            <!-- table -->
            <section>
                <h2 style="margin:2rem 0">Thông số kỹ thuật</h2>
                <table style="width: 100%;">
                    @foreach($data["thongSoThietBi"] as $value)
                        <tr>
                            <td>{{$value->ten_goi}}</td>
                            <td>{{$value->value.' '.$value->ten_don_vi}}</td>
                        </tr>
                    @endforeach
                </table>
            </section>
        </div>
       <!-- có thể bạn quan tâm -->
       <section class="">
            <h2 class="" style="margin-left: 70px;">Có thể bạn quan tâm</h2>

            <div class="list-san-pham-gioi-thieu d-flex align-center">
                <div class="btn-pre" id="btn-next-2">&#10094;</div>
                
                <div class="list-sp-thuong d-flex">
                    @if(isset($data["hienThiThem"]))
                        @foreach($data["hienThiThem"] as $product)
                            <div class="san-pham-gioi-thieu">
                                <span class="logo-sale">
                                    SALE
                                </span>
                                <div class="d-flex flex-direction-col">
                                    <div class="bg-white wrap-img-san-pham">
                                        <a href="{{ route('product.detail',$product->id_chi_tiet_thiet_bi) }}" >
                                            <img src="{{ asset('asset/images/'.$product->src_anh) }}" alt="sanpham" class="" width="100%" style="display:block;margin: auto;">
                                        </a>
                                    </div>
                                    <div style="padding: 1rem;" class="flex-1">
                                        <p class="">{{ $product->ten}}</p>
                                        <div class="display-center justify-space-between">
                                            <p class="">
                                            <span class=""> <strong>{{number_format($product->gia_ban*1000,0,',','.')}}₫</strong></span>
                                                <!-- <span class="gia-sale">$70.00</span> -->
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
              
                <div class="btn-next" id="btn-pre-2">&#10095;</div>
            </div>
        </section>
        @endif
    </main>
    <footer class="bg-white">
        <section class="d-flex">
            <div class="vi-tri-shop item-footer d-flex flex-direction-col align-center">
                <h2>Vị trí shop</h2>
                
                <ul class="">

                </ul>
            </div>
            <div class="ho-tro item-footer d-flex flex-direction-col align-center">
                <h2 style="margin: 0 auto;">Hỗ trợ khách hàng</h2>
                
                <ul class="">
                    <li><a href="">Liên hệ với chúng tôi</a></li>
                    <li><a href="">Trung tâm hỗ trợ</a></li>
                    <li><a href="">Thông tin của chúng tôi</a></li>
                    <li><a href="">Ứng tuyển</a></li>
                </ul>
            </div>
            <div class="chinh-sach item-footer d-flex flex-direction-col align-center">
                <h2>Chính sách của shop</h2>
                
                <ul class="">
                    <li><a href="">Hoàn trả & ship</a></li>
                    <li><a href="">Chính sách & dịch vụ</a></li>
                    <li><a href="">Phương thức thanh toán</a></li>
                </ul>
            </div>
        </section>
        <section>
            <hr>
        </section>
       
        <section>
            <h4></h4>
            <div>
                
            </div>
        </section>
    </footer>
    <script src="{{ asset('asset/js/banDienThoai.js') }}"></script>
</body>
</html>