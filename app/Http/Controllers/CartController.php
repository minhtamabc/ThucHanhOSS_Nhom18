<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $idProducts = DB::table('donhang')
                        ->join('chitietdonhang','chitietdonhang.id_don_hang','donhang.id_don_hang')
                        ->join('khachhang','khachhang.id_khach_hang','donhang.id_khach_hang')
                        ->select('chitietdonhang.id_chi_tiet_thiet_bi','chitietdonhang.so_luong','chitietdonhang.tong_tien','donhang.id_don_hang','dia_chi','sdt')
                        ->where('khachhang.id_khach_hang','=',session('user_id'))
                        ->where('donhang.trang_thai_don_hang',6)
                        ->get();

        $cartItems = [];
        $total = 0;
        $i = 0;
        foreach($idProducts as $id){
            $item = DB::table('chitietthietbi')
                            ->select('ten','gia_ban','id_chi_tiet_thiet_bi','so_luong_ton_kho','src_anh')
                            ->where('id_chi_tiet_thiet_bi','=',$id->id_chi_tiet_thiet_bi)
                            ->get();
            $cartItems[$i] = new \stdClass();

            $cartItems[$i]->name = $item[0]->ten;
            $cartItems[$i]->ton_kho = $item[0]->so_luong_ton_kho;
            $cartItems[$i]->id = $item[0]->id_chi_tiet_thiet_bi;
            $cartItems[$i]->gia_ban = $item[0]->gia_ban*1000;
            $cartItems[$i]->src_anh = $item[0]->src_anh;
           
            $cartItems[$i]->quantity = $id->so_luong;
            $cartItems[$i]->price = (int)$id->tong_tien*1000; 
            $cartItems[$i]->idDonHang = $id->id_don_hang;
            $cartItems[$i]->dia_chi = $id->dia_chi;
            $cartItems[$i]->sdt = $id->sdt;

           
            $total += $cartItems[$i]->price;
            
            $i++;
        }

        return view('cart', compact('cartItems', 'total'));
    }

}