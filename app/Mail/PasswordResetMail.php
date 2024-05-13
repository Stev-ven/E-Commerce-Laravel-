<?php

namespace App\Mail;
use App\Models\Admin;
use App\Models\Admins;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    
    public function build()
    {
        return $this->subject('Reset Password')
                    ->view('emails.passreset');
    }
    
     
    
     
}
