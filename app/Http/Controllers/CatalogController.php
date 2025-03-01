<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\DeleteDetail;
use App\Models\DeleteReason;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function public_path;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $products = Product::query()->get();
        $catalog = new Catalog();
        $catalogs = $catalog->query()->paginate(10);
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
        //  Menampilkan web create
        
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
            'stok' => 'required|numeric|min:0',
            'jenis_katalog' => 'required|in:baju,celana anak,baju keluarga',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'required|file|mimes:jpeg,png,jpg,gif|max:10240', // Max 10MB
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $fileName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads'), $fileName);
        } else {
            return back()->withErrors(['gambar' => 'File gambar tidak ditemukan.']);
        }
        // Find the maximum catalog_id and increment it
        $catalog = Catalog::create([
            'nama_katalog' => $request->nama_katalog,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'tipe_bahan' => $request->tipe_bahan,
            'jenis_katalog' => $request->jenis_katalog,
            'harga' => $request->harga,
            'gambar' => 'uploads/' . $fileName, // Sertakan path yang benar
        ]);
        if ($catalog->wasRecentlyCreated) {
            return redirect()->route('catalog.indexAdmin')->with('success', 'Catalog created successfully.');
        } else {
            return redirect()->route('catalog.indexAdmin')->with('error', 'Failed to create catalog.');
        }
        // return redirect()->route('admin.catalog.index')->with('success', 'Catalog created successfully.');
    }

    public function editAdmin(Request $request, $id)
    {
        $catalog = Catalog::find($id);
        if (!$catalog) {
            return redirect()->route('catalog.indexAdmin')->with('error', 'Catalog not found.');
        }

        $request->validate([
            'nama_katalog' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_bahan' => 'required|in:kain,plastik,kertas',
            'jenis_katalog' => 'required|in:baju,celana anak,baju keluarga',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $fileName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads'), $fileName);
            $catalog->gambar = 'uploads/' . $fileName; // Sertakan path yang benar
        }
        $catalog->update([
            'nama_katalog' => $request->nama_katalog,
            'deskripsi' => $request->deskripsi,
            'tipe_bahan' => $request->tipe_bahan,
            'jenis_katalog' => $request->jenis_katalog,
            'harga' => $request->harga,
        ]);

        return redirect()->route('catalog.indexAdmin')->with('success', 'Catalog updated successfully.');
    }
    /**
     * Display the specified resource.
     */

    public function addStockCatalog(Request $request, $id)
    {
        $catalog = Catalog::find($id);
        if (!$catalog) {
            return redirect()->route('catalog.indexAdmin')->with('error', 'Catalog not found.');
        }

        $request->validate([
            'stok' => 'required|numeric|min:0',
        ]);

        $catalog->stok += $request->stok;
        $catalog->save();

        return redirect()->route('catalog.indexAdmin')->with('success', 'Stock added successfully.');
    }

   public function destroyItems(Request $request, $id)
    {
        $catalog = Catalog::find($id);
        if (!$catalog) {
            return redirect()->route('catalog.indexAdmin')->with('error', 'Catalog not found.');
        }

        $request->validate([
            'reason' => 'required|string',
            'catalog_id' => 'required|exists:catalogs,id',
            'nama_katalog' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $detailDelete = DeleteDetail::create([
            'reason' => $request->reason,
            'catalog_id' => $request->catalog_id,
            'nama_katalog' => $request->$catalog->nama_katalog,
            'deskripsi' => $request->$catalog->deskripsi,
        ]);
        
        $catalog->delete();
        return redirect()->route('catalog.indexAdmin')->with('success', 'Catalog deleted successfully.');
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

