<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiModel extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_trans';
    protected $fillable = ['kode_trans', 'id_pelanggan', 'tanggal', 'batas_waktu', 'status', 'pembayaran'];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(PelangganModel::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(DetailTransaksiModel::class, 'id_trans', 'id_trans');
    }
}
