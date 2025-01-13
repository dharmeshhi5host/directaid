<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;

class WelcomeJobSeekerEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $socialLinks;
    private $name;
    private $id;
    private $emailData;
    private $langtxt;
    private $user_type;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param $name
     * @param $id
     * @param $socialLinks
     * @param $header
     * @param $headerTrans
     * @param $bodyTrans
     * @param $footerTrans
     * @param $langtxt
     */
    public function __construct($name,$id,$socialLinks,$emailData,$langtxt,$user_type,$email)
    {
        $this->id = $id;
        $this->langtxt = $langtxt;
        $this->name = $name;
        $this->socialLinks = $socialLinks;
        $this->emailData = $emailData;
        $this->user_type = $user_type;
        $this->email = $email;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

//       $url = route('verifyUser',[$this->id]);
        $encrypted = Crypt::encryptString($this->email);
        $url = asset('/verifyEmail?email='.$encrypted);

        $subject = $this->emailData->subject;
        return $this->subject($subject)->from(config('mail.from.address'),config('mail.from.name'))->view('emails.welcomeJobSeeker',
            ['name'=>$this->name,'id'=>$this->id,"socialLinks"=>$this->socialLinks,
                'emailData' => $this->emailData,'url' => $url,'locale'=>$this->langtxt]);
        }
}
