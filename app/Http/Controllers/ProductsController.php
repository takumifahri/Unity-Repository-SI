<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $products = Product::query()->get();
        $products = new Product();
        $products = $products->query()->get();
        return view('product', ['products' => $products]);
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
        //
        $products = new Product();
        $request->validate([
            'product_id' => 'required',
            'nama_produk' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required'
        ]);
        try{
            $products->product_id = $request->product_id;
            $products->nama_produk = $request->nama_produk;
            $products->harga = $request->harga;
            $products->stok = $request->stok;
            $products->deskripsi = $request->deskripsi;
            $products->gambar = $request->gambar;
            $products->save();
            return redirect()->route('produk')->with('success', 'Data berhasil ditambahkan');
        }
        catch(\Exception $e){
            return redirect()->route('produk')->with('error', 'Data gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
