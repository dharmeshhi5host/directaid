<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;



    private $name;
    private $token;
    private $url;
    private $email;
    private $id;
    private $socialLinks;
    private $emailData;
    private $langtxt;
    private $user_type;
    private $route;




    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$token,$url,$email,$id,$socialLinks,$emailData,$langtxt,$user_type, $route = null)
    {

        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
        $this->url = $url;
        $this->id = $id;
        $this->langtxt = $langtxt;
        $this->socialLinks = $socialLinks;
        $this->emailData = $emailData;
        $this->user_type = $user_type;
        $this->route = $route;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {         
        return $this->subject($this->emailData->subject)->from(config('mail.from.address'),config('mail.from.name'))
            ->view('emails.forgotPassword',['name'=>$this->name,'token'=>$this->token,'url'=>$this->url,'email'=>$this->email,'id'=>$this->id,"socialLinks"=>$this->socialLinks,
                'emailData' => $this->emailData,'locale'=>$this->langtxt, 'route' => $this->route]);
    }
}
