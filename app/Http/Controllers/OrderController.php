<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(){
      
        $data = [];
        $donHang = DB::table('donhang')
                        ->join('trangthaidonhang','trangthaidonhang.id_trang_thai','donhang.trang_thai_don_hang')
                        ->join('loaithanhtoan','loaithanhtoan.id_loai_thanh_toan','donhang.loai_thanh_toan')
                        ->select('id_don_hang','tong_tien','ten_trang_thai','ten_loai_thah_toan','trang_thai_don_hang')
                        ->where('id_khach_hang','=',session('user_id'))
                        ->whereBetWeen('trang_thai_don_hang',[1,5])
                        ->orderBy('ngay_dat','desc')
                        ->get();

        $data["donHang"] = $donHang;
        return view('myOrder')->with('data',$data);
       
    }

    public function order(){
        if(isset($_POST["thanhtoan"]) && isset($_POST["ptThanhToan"]) && isset($_POST["amount"]) && isset($_POST["idDonHang"])){
            if($_POST["diachi"] == "" || $_POST["sdt"] == "")
                return redirect()->route('cart.index')->with('error','Chưa có địa chỉ hoặc số điện thoại');

            // bug chua test sdt
            // if(!preg_match("/^0[0-9]{9}$/",trim($_POST["sdt"])))
            //     return redirect()->route('cart.index')->with('error','Sai định dạng số điện thoại !');

            $t = DB::table('khachhang')
                ->where('id_khach_hang','=',session('user_id'))
                ->update([
                    'dia_chi' => $_POST["diachi"],
                    'sdt' => $_POST["sdt"]
                ]);

            $cod = $_POST["ptThanhToan"];
            $total = $_POST["amount"];
            $idDonHang = $_POST["idDonHang"];
            //cod
            if($cod == "1"){
                $data = DB::table('donhang')
                            ->where('id_don_hang','=',$idDonHang)
                            ->update([
                                'tong_tien' => ($total/1000),
                                'ngay_dat' => date('Y-m-d H:i:s'),
                                'loai_thanh_toan' => 1,
                                'trang_thai_don_hang' => 1
                            ]);

                if($data > 0) 
                  return redirect()->route('order.index')->with('success','Đã đặt hàng thành công !');
            }
            
        }
        return redirect()->route('order.index')->with('error','Đã có lỗi xảy ra, vui lòng thử lại sau !');
    }
    //9704198526191432198
}