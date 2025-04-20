<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaketModel extends Model
{
    use HasFactory;

    protected $table = 'paket';
    protected $primaryKey = 'id_paket';
    protected $fillable = ['kode_paket', 'nama_paket', 'jenis', 'harga'];

    public function detail_transaksi(): HasMany
    {
        return $this->hasMany(DetailTransaksiModel::class);
    }
}
