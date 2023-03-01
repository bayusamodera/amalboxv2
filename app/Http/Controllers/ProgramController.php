<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\ProgramPicture;
use App\Models\Category;
use App\Models\Cart;
use Auth;
use App\Models\ProgramDonatur;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\CartHelper;

class ProgramController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */     
    public function index()
    {
        $programs = Program::all();
        return view('program.all', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Category::all();
        return view('program.create', compact( 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user();
        $program = new Program();
        $program->user_id = Auth::user()->id;
        $program->idx_program_category_id = $request->category;
        $program->title = $request->title;
        $program->detail = $request->detail;
        $program->target_donation = $request->targetdonation;
        $program->short_description = $request->short_description;
        $program->location = $request->location;
        $program->status = Program::STATUS_PUBLISH;
        $program->date_end = $request->dateend;
        $program->gambar_cover = $request->gambarcover;        
        $program->save();

        $req = $request->all();
        foreach ($req as $key => $value) {
            if(explode('_', $key)[0] == 'gambar' && !empty($value)) {
                $gambar = new ProgramPicture();
                $gambar->program_profile_id = $program->id;
                $gambar->path =   $value;
                $gambar->detail = "";
                $gambar->save();
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $listprogram = session('listprogram', []);
        $program = Program::findorfail($id);
        $data['program'] = $program;
        $jumlah = 0;
        foreach(Cart::JENIS_ZAKAT as $zakat) {            
            $jumlah = $jumlah + session($zakat,0);
        }        
        $data['jumlah'] = $jumlah;
        $tersalurkan = 0;
        foreach ($listprogram as $value) {
            $tersalurkan = $tersalurkan + $value['jumlah'];
        }
        $data['tersalurkan'] = $tersalurkan;
        return view('program.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program = Program::findorfail($id);
        $kategori = Category::all();
        return view('program.edit', compact('program', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $program = Program::findorfail($id);
        $program->user_id = Auth::user()->id;
        $program->idx_program_category_id = $request->category;
        $program->title = $request->title;
        $program->detail = $request->detail;
        $program->target_donation = $request->targetdonation;
        $program->location = $request->location;
        $program->short_description = $request->short_description;
        $program->status = Program::STATUS_PUBLISH;
        $program->date_end = $request->dateend;
        $program->gambar_cover = $request->gambarcover;        
        $program->save();
        $program->images()->delete();

        $req = $request->all();
        foreach ($req as $key => $value) {
            if(explode('_', $key)[0] == 'gambar' && !empty($value)) {
                $gambar = new ProgramPicture();
                $gambar->program_profile_id = $program->id;
                $gambar->path =   $value;
                $gambar->detail = "";
                $gambar->save();
            }
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $program = Program::findorfail($id);
        $program->delete();
        return redirect()->back();
    }

    public function amal($id) {
        
        return view('program.amal', compact('id'));
    }

    public function donasi($id) {
        $donatur = ProgramDonatur::where('program_profile_id', $id)->where('status', ProgramDonatur::STATUS_KONFIRMASI)->get();        
        return view('program.donasi', compact('donatur'));
    }

    public function zakatall(Request $req) {   
        $filter = [];    
        $filter['cari'] = $req->cari;
        $filter['category'] = $req->category;
        $filter['urutkan'] = $req->urutkan;
        $programs = Program::getZakat()
        //->with('pembuat')
        ->join('users', 'program_profile.user_id' , '=' , 'users.id')
        ->where(function ($query) use($filter) {
            $query->where('title','like', '%'.$filter['cari'].'%')
            ->orwhere('short_description','like', '%'.$filter['cari'].'%')
            ->orwhere('location','like', '%'.$filter['cari'].'%')
           // ->orwhere('pembuat.name','like', '%'.$filter['cari'].'%')
            ->orwhere('name','like', '%'.$filter['cari'].'%')
         ;
        })
        ->where('program_profile.status', Program::STATUS_PUBLISH);
       
        if($filter['category']) {
            $programs = $programs->wherein('idx_program_category_id', $filter['category']);
        }else {
        $filter['category'] = [];
        }
        
        $programs = $programs->get([(new Program)->getTable().'.*']);   

        if($filter['urutkan'] == 'kurang_dana') {
            $programs = $programs->sortBy(function ($program, $key) {
                return $program->jumlahDonasi();
            });
        }else if($filter['urutkan'] == 'hampir_berhasil') {
            $programs = $programs->sortByDesc(function ($program, $key) {
                return $program->jumlahDonasi();
            });
        }else if($filter['urutkan'] == 'terpopuler') {
            $programs = $programs->sortByDesc(function ($program, $key) {
                return $program->donasilunas()->count();
            });
        }else if($filter['urutkan'] == 'hampir_berakhir') {
            $programs = $programs->sortBy(function ($program, $key) {
                return $program->waktuTersisa();
            });
        }
        $perPage = 9;

        $page = Paginator::resolveCurrentPage() ?: 1;
        $programs = new LengthAwarePaginator($programs->forPage($page, $perPage), $programs->count(), $perPage, $page,  ['path'=>route('umum.program.zakatall')]);
       
        $jumlah = $programs->count();
        $category = Category::getZakat();
        $jenis = Category::ZAKAT;
        
        return view('program.zakat', compact('programs', 'category', 'filter', 'jumlah', 'jenis'));
    }

    public function amalall(Request $req) {
        $filter = [];    
        $filter['cari'] = $req->cari;
        $filter['category'] = $req->category;
        $filter['urutkan'] = $req->urutkan;
        $programs = Program::getAmal()
        //->with('pembuat')
        ->join('users', 'program_profile.user_id' , '=' , 'users.id')
        ->where(function ($query) use($filter) {
            $query->where('title','like', '%'.$filter['cari'].'%')
            ->orwhere('short_description','like', '%'.$filter['cari'].'%')
            ->orwhere('location','like', '%'.$filter['cari'].'%')
           // ->orwhere('pembuat.name','like', '%'.$filter['cari'].'%')
            ->orwhere('name','like', '%'.$filter['cari'].'%')
         ;
        })
        ->where('program_profile.status', Program::STATUS_PUBLISH);
       
        if($filter['category']) {
            $programs = $programs->wherein('idx_program_category_id', $filter['category']);
        }else {
        $filter['category'] = [];
        }
        
        $programs = $programs->get([(new Program)->getTable().'.*']);   

        if($filter['urutkan'] == 'kurang_dana') {
            $programs = $programs->sortBy(function ($program, $key) {
                return $program->jumlahDonasi();
            });
        }else if($filter['urutkan'] == 'hampir_berhasil') {
            $programs = $programs->sortByDesc(function ($program, $key) {
                return $program->jumlahDonasi();
            });
        }else if($filter['urutkan'] == 'terpopuler') {
            $programs = $programs->sortByDesc(function ($program, $key) {
                return $program->donasilunas()->count();
            });
        }else if($filter['urutkan'] == 'hampir_berakhir') {
            $programs = $programs->sortBy(function ($program, $key) {
                return $program->waktuTersisa();
            });
        }
        $perPage = 9;

        $page = Paginator::resolveCurrentPage() ?: 1;
        $programs = new LengthAwarePaginator($programs->forPage($page, $perPage), $programs->count(), $perPage, $page,  ['path'=>route('umum.program.amalall')]);
       
        $jumlah = $programs->count();
        $category = Category::getAmal();
        $jenis = Category::AMAL;
        
        return view('program.amal', compact('programs', 'category', 'filter', 'jumlah', 'jenis'));
    }

    public function publish($id) {
        $program = Program::findorfail($id);
        $program->status = Program::STATUS_PUBLISH;
        $program->save();
        return redirect()->back();
    }

    public function unpublish($id) {
        $program = Program::findorfail($id);
        $program->status = Program::STATUS_UNPUBLISH;
        $program->save();
        return redirect()->back();
    }

    public function salurkanotomatis(Request $req) {
        $cart = CartHelper::getCart(); 
        // $req->session()->forget('listprogram');
        
        $cart->program()->syncWithoutDetaching([$req->programid =>['value' => CartHelper::getJumlahWajibZakat() - CartHelper::getJumlahZakatTersalurkan(), 'comment' => '']]);  

        return redirect()->route('umum.cart.show');
    }
}
