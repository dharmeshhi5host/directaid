<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantCenter extends Model
{

    protected $table = 'merchant_centers';
    public $translatedAttributes = [
        'payment_merchant_detail_id',
        'center_id',
    ];
    protected $guarded = [];
}

