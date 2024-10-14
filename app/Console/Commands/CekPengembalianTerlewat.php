<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\pinjambuku;
use Illuminate\Support\Facades\Mail;
use App\Mail\PeringatanPengembalian;
use App\Mail\PeringatanSebelumPengembalian;
use Carbon\Carbon;

class CekPengembalianTerlewat extends Command
{
    protected $signature = 'cek:pengembalian';
    protected $description = 'Cek batas pengembalian yang terlewat dan kirim email notifikasi';

    public function handle()
    {
    }
}
