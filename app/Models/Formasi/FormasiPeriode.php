<?php

namespace App\Models\Formasi;

use App\Models\Maintenance\Jabatan;
use App\Models\Siap\UnitKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FormasiPeriode extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tbl_formasi_periode';

    protected $fillable = [
        'periode',
        'file_surat_undangan',
    ];
}
