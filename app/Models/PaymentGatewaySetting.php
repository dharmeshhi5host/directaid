<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewaySetting extends Model
{
    public $timestamps = false;
    protected $table = "payment_gateway_settings";
    protected $guarded = [];


}
