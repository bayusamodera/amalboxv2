<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\IsiCart;
use App\Helpers\CartHelper;
use App\Veritrans\Veritrans;

class CartController extends Controller
{
    public function __construct(){   
            Veritrans::$serverKey = 'SB-Mid-server-xSr5LsE1H-g3XCxCgONGHUSB';
            Veritrans::$isProduction = false;
        }
    
    public function show() {
        
        $cart = CartHelper::getCart();      
        
        $isicart = $cart->isiCart;       
        
        return view('cart.show', compact('isicart'));
    }

    public function tambahprogram(Request $req) {
        $cart = CartHelper::getCart(); 
        // $req->session()->forget('listprogram');
        
        $cart->program()->syncWithoutDetaching([$req->id =>['value' => str_replace('.','',$req->jumlah), 'comment' => $req->comment]]);  

        return redirect()->route('umum.cart.show');
    }

    public function pembayaran() {
        $cart = CartHelper::getCart(); 
        
       $isicart = $cart->isiCart;

       if($isicart->count() == 0) {
            return redirect()->route('umum.cart.show');
         }
      
        return view('cart.pembayaran', compact('isicart'));
    }

    public function destroy($id)
    {   
        $cart = CartHelper::getCart(); 
        $program = IsiCart::where('id', $id)->where('cart_id', $cart->id);
        $program->delete();
        return redirect()->back();
    }
}
