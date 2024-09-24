<?php

namespace App\Imports;

use App\Models\kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KategoriImport implements ToModel, WithHeadings
{
    public function model(array $row)
    {
        // Buat kategori baru dari data Excel
        return new kategori([
            'nama_kategori' => $row[0],  // Kolom pertama Excel diisi nama kategori
        ]);
    }
}
