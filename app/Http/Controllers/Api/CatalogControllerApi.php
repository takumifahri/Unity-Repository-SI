<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog;
use App\Models\DeleteDetail;
use App\Models\DeleteReason;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\error;
use function public_path;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CatalogControllerApi extends Controller
{

    /**
     * Show the form for creating a new resource.
     */

    public function index()
    {
        $catalogs = Catalog::all();
        
        
        if($catalogs->isEmpty()){
            return response()->json([
                'message' => 'Catalog not found',
            ], 404);
        }
        return response()->json([
            'message' => 'Success',
            'data' => $catalogs,
        ], 200);
        
    }

    public function store(Request $request) 
    {
        $validate = Validator::make($request->all(), [
            'nama_katalog' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_bahan' => 'required',
            'stok' => 'required|numeric|min:0',
            'jenis_katalog' => 'required|in:baju,celana anak,baju keluarga',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'required|file|mimes:jpeg,png,jpg,gif|max:10240', // Max 10MB
        ]);
        
        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()
            ], 422);
        }
        
        if ($request->hasFile('gambar')) {
            $fileName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads'), $fileName);
        } else {
            return response()->json([
                'message' => 'File gambar tidak ditemukan.'
            ], 404);
        }

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
            return response()->json([
                'message' => 'Catalog created successfully',
                'data' => $catalog,
                'status' => 201
            ] );
        } else {
            return response()->json([
                'message' => 'Failed to create catalog',
                'detail message' => $validate->errors(),
                'status' => 500
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function updateCatalog(Request $request, $id)
    {
        $catalog = Catalog::find($id);
        if (!$catalog) {
            return response()->json('Catalog not found.', 404);
        }
        try{
            $validate = $request->validate([
                'nama_katalog' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'tipe_bahan' => 'nullable|in:kain,plastik,kertas',
                'jenis_katalog' => 'nullable|in:baju,celana anak,baju keluarga',
                'harga' => 'nullable|numeric|min:0',
                'gambar' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
    
            // Handle file upload
            if ($request->hasFile('gambar')) {
                $fileName = time() . '.' . $request->gambar->extension();
                $request->gambar->move(public_path('uploads'), $fileName);
                $catalog->gambar = 'uploads/' . $fileName; // Sertakan path yang benar
            }
            $catalog->update([
                'nama_katalog' => $validate['nama_katalog'] ?? $catalog->nama_katalog,
                'deskripsi' => $validate['deskripsi'] ?? $catalog->deskripsi,
                'tipe_bahan' => $validate['tipe_bahan'] ?? $catalog->tipe_bahan,
                'jenis_katalog' => $validate['jenis_katalog'] ?? $catalog->jenis_katalog,
                'harga' => $validate['harga'] ?? $catalog->harga,
                'gambar' => $validate['gambar'] ? 'uploads/' . $fileName : $catalog->gambar,
            ]);
            return response()->json([
                'message' => 'Catalog updated successfully',
                'data' => $catalog,
                'status' => 'success'
            ],200);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to update catalog',
                'detail message' => $e->getMessage(),
                'status' => 'failed'
            ],500);
        }
        

        
        // return redirect()->route('catalog.indexAdmin')->with('success', 'Catalog updated successfully.');
    }

    /**
     * Display the specified resource.
     */

    public function addStockCatalog(Request $request, $id)
    {
        $catalog = Catalog::find($id);
        if (!$catalog) {
            return response()->json('Catalog not found.', 404);
        }
        
        try{
            $validate = $request->validate([
                'stok' => 'required|numeric|min:0',
            ]);
    
            $catalog->update([
                'stok' => $catalog->stok + $validate['stok'],
            ]);
            return response()->json([
                'message' => 'Stock added successfully',
                'data' => $catalog,
                'status' => 'success'
            ],200);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to add stock',
                'detail message' => $e->getMessage(),
                'status' => 'failed'
            ],500);
        }
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
