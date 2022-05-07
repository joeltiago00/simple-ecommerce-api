<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     */
    private string $token;
    /**
     * @var int
     */
    private int $ttl_to_expire_password_reset_token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, string $token)
    {
        $this->name = $name;
        $this->token = $token;
        $this->ttl_to_expire_password_reset_token = config('app.ttl_to_expire_password_reset_token');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}
