<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DXTradeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subjectEmail;
    public $nameUser;
    public $accountEmail;
    public $typeEmail;
    public $fromEmail;
    public $newPassword;
    public $fromName;

    public function __construct($subj,$name,$account,$type,$emailfrom,$newpassword,$namefrom)
    {
        //
        $this->subjectEmail = $subj;
        $this->nameUser = $name;
        $this->accountEmail = $account;
        $this->typeEmail = $type;
        $this->fromEmail = $emailfrom;
        $this->newPassword = $newpassword;
        $this->fromName = $namefrom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'name'=>$this->nameUser,
            'account'=>$this->accountEmail,
            'newpassword'=>$this->newPassword,
            'type'=>$this->typeEmail,
        ];
        return $this->from($this->fromEmail,$this->fromName)
            ->subject($this->subjectEmail) // <- just add this line
            ->text('emailTextPlain')
            ->view('emailTemplate')
            ->with($data);
    }
}
