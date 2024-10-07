<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TanggalResource extends JsonResource
{
    public function toArray($request)
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $bulan = $namaBulan[Carbon::parse($this->tanggal)->month];

        return [
            'tanggal' => $this->tanggal ? $this->tanggal->day . ' ' . $bulan . ' ' . $this->tanggal->year : null,
            // Tambahkan atribut lain sesuai kebutuhan
        ];

    }
}
