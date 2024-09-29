<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kategori;

class KategoriController extends Controller
{
    public function import(Request $request)
    {
        $data = $request->input('data_kategori');

        $rows = explode(PHP_EOL, $data);

        foreach ($rows as $row) {
            $kategori = trim($row);
            
            if (!empty($kategori)) {
                kategori::updateOrCreate(
                    ['nama' => $kategori],
                    ['nama' => $kategori]
                );
            }
        }

        return redirect()->back()->with('success', 'Kategori berhasil diimport!');
    }
}
