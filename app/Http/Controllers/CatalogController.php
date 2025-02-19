<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $products = Product::query()->get();
        $catalog = new Catalog();
        $catalogs = $catalog->query()->get();
        return view('guest.catalog', ['catalog' => $catalogs]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function indexAdmin()
    {
        $catalog = new Catalog();
        $catalogs = $catalog->query()->get();
        return view('admin.catalog.index', ['catalogs' => $catalogs],compact('catalogs'));

    }
    public function createAdmin(Request $request)
    {
        //  
        
        return view('admin.catalog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nama_katalog' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_bahan' => 'required|in:kain,plastik,kertas',
            'jenis_katalog' => 'required|in:baju,celana anak,baju keluarga',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $fileName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads'), $fileName);
        } else {
            return back()->withErrors(['gambar' => 'File gambar tidak ditemukan.']);
        }
        // Find the maximum catalog_id and increment it
        $maxCatalogId = Catalog::max('catalog_id');
        $newCatalogId = $maxCatalogId ? $maxCatalogId + 1 : 1;

        $catalog = new Catalog();
        $catalog->catalog_id = $newCatalogId;
        $catalog->nama_katalog = $request->nama_katalog;
        $catalog->deskripsi = $request->deskripsi;
        $catalog->tipe_bahan = $request->tipe_bahan;
        $catalog->jenis_katalog = $request->jenis_katalog;
        $catalog->harga = $request->harga;
        $catalog->gambar = 'uploads/' . $fileName; // Sertakan path yang benar
        
        $catalog->save();
        if ($catalog->wasRecentlyCreated) {
            return redirect()->route('catalog.indexAdmin')->with('success', 'Catalog created successfully.');
        } else {
            return redirect()->route('catalog.indexAdmin')->with('error', 'Failed to create catalog.');
        }
        // return redirect()->route('admin.catalog.index')->with('success', 'Catalog created successfully.');
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

