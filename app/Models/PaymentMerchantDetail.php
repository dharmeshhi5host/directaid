<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMerchantDetail extends Model
{

    protected $table = 'payment_merchant_details';
    public $translatedAttributes = [
        'center_id',
        'title',
        'merchant_id',
        'description',
    ];
    protected $guarded = [];
}
