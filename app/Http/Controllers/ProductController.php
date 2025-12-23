<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;

class ProductController extends Controller
{
      // Trang danh sách sản phẩm
      public function products()
      {
        //$cart = new CartController();
        $data = [];
        $products = DB::table('chitietthietbi')
                    ->select('id_chi_tiet_thiet_bi','ten','gia_ban','src_anh')
                    ->where('trang_thai', 1)
                    ->get();
        try{
          $branch = DB::table('hang')
                ->select('ten_hang')
                ->get();
                
          $bestSeller = DB::table('thietbibanchay')
                    ->join('chitietthietbi','thietbibanchay.id_chi_tiet_thiet_bi','chitietthietbi.id_chi_tiet_thiet_bi')
                    ->select('thietbibanchay.id_chi_tiet_thiet_bi','chitietthietbi.ten','chitietthietbi.gia_ban','chitietthietbi.src_anh')
                    ->where('chitietthietbi.trang_thai', 1)
                    ->limit(5)
                    ->offset(0)
                    ->get();
                    
          $data["products"] = $products;
          $data["branch"] = $branch; 
          $data["bestSeller"] = $bestSeller;
          //$data["donHang"] = $cart->countCart(session('user_id'));
        }
        catch(Exception $e){
          $data["products"] = [];
          $data["branch"] = []; 
          $data["bestSeller"] = [];
          $data["donHang"] = 0;
        }
        return view('home')->with('data',$data);
      }
}
