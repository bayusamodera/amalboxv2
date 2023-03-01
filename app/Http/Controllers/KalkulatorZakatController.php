<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CartHelper;
use App\Models\Cart;
use App\Models\Program;

class KalkulatorZakatController extends Controller
{
    public function index(Request $req) {
        $program = Program::find($req->id);
        $jumlahwajibzakat = CartHelper::getJumlahWajibZakat();
        return view('kalkulatorzakat', compact('jumlahwajibzakat', 'program'));
    }

    public function tambahzakat(Request $req) {
        $cart = CartHelper::getCart();    
        $data = $req->all();
        $cart->fill([$data['jenis']=> $data['jumlah']]);
        $cart->save();
        $jumlah = CartHelper::getJumlahWajibZakat();
        return $jumlah;
    }
    public function semuazakat() {
        $cart = CartHelper::getCart(); 
        return response()->json(['data' => $cart]);
    }
}
