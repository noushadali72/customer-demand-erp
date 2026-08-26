<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'request_number',
        'status',
        'notes',
    ];

    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }
}