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

    

    function myHistory(){
        if(session('user_id')){
            $data = [];
            // danh sách order đã duyệt
            $orders = DB::table('donhang')
                        ->join('khachhang','khachhang.id_khach_hang','donhang.id_khach_hang')
                        ->select('id_don_hang','fullname','tong_tien','loai_thanh_toan','ngay_giao','ngay_dat','trang_thai_don_hang')
                        ->whereIn('trang_thai_don_hang',[7,8,4])
                        ->where('khachhang.id_khach_hang','=',session('user_id'))
                        ->orderBy('ngay_dat','desc')
                        ->get();
            $data["order"] = $orders;
            return view('history')->with('data',$data);
        }
        return  redirect()->route('order.index')->with('error','Không thể xem lịch sử, vui lòng thử lại sau !');
    }


}
