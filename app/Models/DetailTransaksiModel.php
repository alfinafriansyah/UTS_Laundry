<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksiModel extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';
    protected $fillable = ['id_trans', 'id_paket', 'quantity', 'harga_satuan', 'subtotal'];

    public function paket(): BelongsTo
    {
        return $this->belongsTo(PaketModel::class, 'id_paket', 'id_paket');
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(TransaksiModel::class, 'id_trans', 'id_trans');
    }
}
