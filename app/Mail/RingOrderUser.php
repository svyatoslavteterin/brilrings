<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\RingOptionValue;
use App\RingOption;
use App\Http\Controllers\RingImageController;

class RingOrderUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $data;
     public $session;
     public $ringOptionValues;
     public $result_img;
     public $total_price;

    public function __construct($data)
    {
        //

        $this->data=$data;

        $session=$data['store']['session'];
        $ring_option_values=RingOptionValue::where('enabled','=',1)->get();

        $output=array();


        foreach ($ring_option_values as $ring_option_value) {

        $ring_option_value->price=json_decode($ring_option_value->price);
          $c=clone $ring_option_value;
          $ring_option=$c->ringOption;

          $output[$ring_option->key][$c->value]=$ring_option_value;

        }

        $result_img=RingImageController::getResultImg($session['base'],$session['material'],$session['shape'],$session['weight'],'array');

       $this->result_img='http://brilliantrings.ru/'.$result_img->image[0];
       $this->total_price=$data['store']['totalPrice'];
        $this->ringOptionValues=$output;

        $this->session=$session;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('service@brilliantrings.ru')->subject('Детали вашего заказа')->view('emails.orderring.user');
    }
}
