<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmailChangeRequestedMail extends Mailable
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
     * @var string
     */
    private string $new_email;
    /**
     * @var int
     */
    private int $time_to_expire_token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, string $token, string $new_email)
    {
        $this->name = $name;
        $this->token = $token;
        $this->new_email = $new_email;
        $this->time_to_expire_token = config('app.ttl_request_email_change');
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
