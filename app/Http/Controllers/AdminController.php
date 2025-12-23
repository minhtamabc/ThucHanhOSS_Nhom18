<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    function index(){
        $data = [];

        $choDuyet = DB::table('donhang')
                    ->select('id_don_hang')
                    ->where('trang_thai_don_hang','=',1)
                    ->get();
        $tongSP = DB::table('chitietthietbi')
                    ->select('id_chi_tiet_thiet_bi')
                    ->get();
        $data["choDuyet"] = count($choDuyet);
        $data["tongSP"] = count($tongSP);

        return view('admin.index')->with('data',$data);
    }
    function login(){
        return view('admin.login');
    }

    function handleLogin(){
        if(isset($_POST["username"]) && isset($_POST["password"])){
            if($_POST["username"] != "" || $_POST["password"] != ""){

                $username = strip_tags(trim($_POST["username"]));
                $password = strip_tags(trim($_POST["password"]));

                if(preg_match("/^[a-zA-Z0-9\.]{6,}$/",$username) && (strlen($password) > 5)){
                    $admin = DB::table('userhethong')
                                ->select('id_he_thong','username','password','fullname')
                                ->where('username','=',$username)
                                ->get();
                    if(count($admin) != 0){
                        if(Hash::check($password,$admin[0]->password)){
                            session(["admin_id" => $admin[0]->id_he_thong]);
                            session(["admin_name" => $admin[0]->fullname]);
                            return  redirect('/trang-chu')->with('success', 'Đăng nhập thành công !');
                        }
                    }
                }
            }  
        }
        return redirect('/trang-chu/login')->with('error', 'Có lỗi xảy ra khi đăng nhập: ');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/trang-chu/login')->with('success', 'Đăng xuất thành công!');
    }

    // Quản lý sản phẩm (Có lọc và hiển thị thông số)
    function productManagement(Request $request){
        // 1. Lấy danh sách loại để làm bộ lọc
        $categories = DB::table('loaisanpham')->get();

        // 2. Query cơ bản lấy thông tin chung
        $query = DB::table('chitietthietbi')
                    ->join('hang', 'chitietthietbi.id_hang', '=', 'hang.id_hang')
                    ->join('loaisanpham', 'chitietthietbi.id_loai', '=', 'loaisanpham.id_loai_sp')
                    ->select(
                        'chitietthietbi.*', 
                        'hang.ten_hang', 
                        'loaisanpham.ten_loai_sp', 
                        'loaisanpham.tenbangthongso',
                        'loaisanpham.id_loai_sp'
                    )
                    ->orderBy('nam_phat_hang', 'desc');

        // 3. Xử lý bộ lọc
        if($request->has('category') && $request->category != 'all'){
            $query->where('chitietthietbi.id_loai', $request->category);
        }

        $products = $query->paginate(10);

        // 4. Vòng lặp lấy thông số chi tiết cho từng sản phẩm
        foreach($products as $product){
            if(!empty($product->tenbangthongso)){
                // XỬ LÝ KHÁC BIỆT TÊN CỘT ID
                // Bảng sạc dự phòng dùng 'id_chitiet_thiet_bi', các bảng khác dùng 'id_chi_tiet_thiet_bi'
                $foreignKey = ($product->id_loai_sp == 4) ? 'id_chitiet_thiet_bi' : 'id_chi_tiet_thiet_bi';

                // Lấy dòng thông số
                $spec = DB::table($product->tenbangthongso)
                          ->where($foreignKey, $product->id_chi_tiet_thiet_bi)
                          ->first();
                
                $product->thong_so = $spec;
            } else {
                $product->thong_so = null;
            }
        }

        $products->appends(['category' => $request->category]);

        return view('admin.sanpham.sanpham', compact('products', 'categories'));
    }
}
