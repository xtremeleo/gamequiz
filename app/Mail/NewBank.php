<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\Account;

class NewBank extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $account;
    public $verificationLink;
    
    public function __construct(User $user, Account $account)
    {
        //
        $this->user = $user;
        $this->account = $account;
        $this->verificationLink = sha1($account->number);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bank Account Verification')->view('email.bank.verify');
    }
}
