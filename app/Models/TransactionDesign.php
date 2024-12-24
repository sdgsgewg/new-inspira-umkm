<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDesign extends Model
{
    use HasFactory;

    protected $table = 'transaction_designs';
    protected $guarded = ['id'];
    protected $with = ['transaction', 'design'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function updateStatus($newStatus)
    {
        $this->transactionStatus = $newStatus;
        $this->save();
    }
}
