<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $trxID;
    public $name;
    public $city;
    public $address;
    public $country;
    public $orderStatus;
    public $productsData;
    public $unit_total_price;
    public $total;
    public $number;
    public $headerTrans;
    public $header;
    public $bodyTrans;
    public $footerTrans;
    public $socialLinks;
    public $locale;
    public $SlHead;
    public $SlPays;
    public $SlDetailData;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($number,$trxID,$name,$email,$city,$address,$country,$orderStatus,$productsData,$unit_total_price,$total,$socialLinks,$header,$headerTrans,$bodyTrans,$footerTrans,$locale,$SlPays,$SlHead,$SlDetailData)
    {
        $this->name = $name;
        $this->trxID = $trxID;
        $this->city = $city;
        $this->number = $number;
        $this->address = $address;
        $this->country = $country;
        $this->orderStatus = $orderStatus;
        $this->productsData = $productsData;
        $this->unit_total_price = $unit_total_price;
        $this->total = $total;
        $this->socialLinks = $socialLinks;
        $this->header = $header;
        $this->headerTrans = $headerTrans;
        $this->bodyTrans = $bodyTrans;
        $this->footerTrans = $footerTrans;
        $this->locale = $locale;
        $this->SlHead = $SlHead;
        $this->SlPays = $SlPays;
        $this->SlDetailData = $SlDetailData;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $subject = 'Order Placed';
         $title = 'Orde COnfirmation';
         return $this->from(config('mail.from.address'),config('mail.from.name'))->subject($subject)->markdown('emails.OrderEmail')->with(['data' => $this->productsData,"socialLinks"=>$this->socialLinks, 'header' => $this->header, 'headerTrans' => $this->headerTrans, 'bodyTrans' => $this->bodyTrans, 'footerTrans' => $this->footerTrans,'SlHead'=>$this->SlHead,'emailData'=>$this->SlPays,'SlDetailData'=>$this->SlDetailData,'locale'=>$this->locale]);
    }
}
