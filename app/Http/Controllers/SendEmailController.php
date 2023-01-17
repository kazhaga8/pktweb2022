<?php

namespace App\Http\Controllers;
 
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
 

class SendEmailController extends Mailable
{
    use Queueable, SerializesModels;
 
    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sent = $this->subject($this->data->subject)
                ->view($this->data->view)
                ->with((array) $this->data->body);
        // if(isset($this->data->attach)){
        //     $sent->attach(public_path('/hubungkan-ke-lokasi-file').'/demo.jpg', [
        //       'as' => 'demo.jpg',
        //       'mime' => 'image/jpeg',
        //     ]);
        // }
        return $sent;
    }
}
