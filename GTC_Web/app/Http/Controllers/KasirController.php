<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Kasir;
use Illuminate\Support\Facades\File;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kasirs = Kasir::orderBy('id','asc')->paginate(2);
        // $kasirs = Kasir::paginate(2);
        return view("menu", ['kasirs'=>$kasirs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tambahFotoProduk'=> 'mimes:jpg,jpeg,png|max:5000',
            'tambahNamaProduk'=>'required',
            'tambahHargaProduk'=> 'required|numeric',
            'tambahStokProduk'=> 'required|numeric',
        ]);
        $kasir = new Kasir();
        $kasir->foto = pathinfo($data['tambahFotoProduk']->getClientOriginalName(), PATHINFO_FILENAME) . '.' . pathinfo($data['tambahFotoProduk']->getClientOriginalName(), PATHINFO_EXTENSION);
        $kasir->nama_produk = $data['tambahNamaProduk'];
        $kasir->harga_produk = $data['tambahHargaProduk'];
        $kasir->stok_produk = $data['tambahStokProduk'];

        $request->tambahFotoProduk->move(public_path('file'), $request->tambahFotoProduk->getClientOriginalName());
        $kasir->save();
        return redirect('/kasir')->with('success','Produk Telah Ditambahkan');
    }

    /**
     * Display the specified resource.
     */

    public function show(Kasir $kasir)
    {
        $kasir = Kasir::where('id', $kasir->id)->first();

        if($kasir){
            return response()->json([
                'namaproduk'=>$kasir->nama_produk,
                'hargaproduk'=>$kasir->harga_produk,
                'stokproduk'=>$kasir->stok_produk
            ]) ;
        }

        return response()->json(['error'=> 'Data Not Found'] ,404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Kasir $kasir)
    {
        $kasirs = Kasir::where('id', $kasir->id)->first();

        $data = $request->validate([
            'suntingFotoProduk'=> 'mimes:jpg,jpeg,png|max:5000',
            'suntingNamaProduk'=>'required',
            'suntingHargaProduk'=> 'required|numeric',
            'suntingStokProduk'=> 'required|numeric',
        ]);

        $file = public_path('file/'.$kasirs->foto);
        $kasirs->nama_produk = $data['suntingNamaProduk'];
        $kasirs->harga_produk = $data['suntingHargaProduk'];
        $kasirs->stok_produk = $data['suntingStokProduk'];
        $kasirs->foto = isset($data['suntingFotoProduk']) ? pathinfo($data['suntingFotoProduk']->getClientOriginalName(), PATHINFO_FILENAME) . '.' . pathinfo($data['suntingFotoProduk']->getClientOriginalName(), PATHINFO_EXTENSION) : $kasirs->foto;
    
        if($request->file('suntingFotoProduk')){
            File::delete($file);
            $request->suntingFotoProduk->move(public_path('file'), $request->suntingFotoProduk->getClientOriginalName());
        }

        $kasirs->save();
        return redirect('/kasir')->with('success','Menu Telah Disunting');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function login(Request $request)
    {
        $request->validate([
            'username_kasir' => 'required',
            'password_kasir' => 'required|string',
        ], [
            'username_kasir.required' => 'Silahkan mengisi username terlebih dahulu',
            'password_kasir.required' => 'Silahkan mengisi password terlebih dahulu',    
        ]
        );

        $kasir = Kasir::where('username_kasir', $request->username_kasir)->first();

        if (!$kasir || !Hash::check($request->password_kasir, $kasir->password_kasir)) {
            return back()->with('error', 'Username or password invalid');
        }
        
        $request->session()->regenerate();
        return redirect()->route('kasir.confirm');
    }

    public function showLoginForm()
    {
        return view('login_kasir'); 
    }
  
    public function showConfirmPage()
    {
        return view('Confirm');

    public function destroy(Kasir $kasir)
    {
        $kasirs = Kasir::where('id', $kasir->id)->first();
        $file = public_path('file/'.$kasirs->foto);
        File::delete($file);
        Kasir::destroy($kasir->id);

        return redirect('/kasir')->with('success','Hapus berhasil');
    }
}
