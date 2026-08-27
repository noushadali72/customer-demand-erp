<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'request_number',
        'status',
        'notes',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($purchaseRequest) {
    //         if (empty($purchaseRequest->request_number)) {
    //             $purchaseRequest->request_number = random_int(100000, 999999);
    //         }
    //     });
    // }

    public function items()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

      public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}