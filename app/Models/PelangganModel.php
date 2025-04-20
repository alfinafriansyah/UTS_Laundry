<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PelangganModel extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['nama_pelanggan', 'telp', 'alamat'];

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiModel::class);
    }
}
