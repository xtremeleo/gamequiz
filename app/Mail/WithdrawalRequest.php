<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\WithdrawalRequest as WLRT;

class WithdrawalRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $user;
    public $wlrt;
    public $verificationLink;
    
    public function __construct(User $user, WLRT $wlrt)
    {
        //
        $this->user = $user;
        $this->wlrt = $wlrt;
        $this->verificationLink = sha1($wlrt->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Withdrawal Request Verification')->view('email.bank.wlrt_verify');
    }
}
