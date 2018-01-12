<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\RingOptionValue;
use App\RingOption;

class OrderGift extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


     public $data;
     public $store;
     public $giftOptionValues;

    public function __construct($data)
    {

      $this->data=$data;


        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from('service@brilliantrings.ru')->subject('Заказ подарка')->view('emails.ordergift');
    }
}
