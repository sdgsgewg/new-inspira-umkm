<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPromotion extends Model
{
    use HasFactory;

    protected $table = 'transaction_promotions';
    protected $guarded = ['id'];
    protected $with = ['transaction', 'promotion'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function updateStatus($newStatus)
    {
        $this->transactionStatus = $newStatus;
        $this->save();
    }
}
