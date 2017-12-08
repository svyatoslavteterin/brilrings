<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\RingOptionValue;
use App\RingOption;
use App\Http\Controllers\RingImageController;

class ResultSaved extends Mailable
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
    public function __construct($store)
    {
        //

        $session=$store['session'];
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
       $this->total_price=$store['totalPrice'];
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


      return $this->from('info@brilliantrings.ru')->subject('Сохраненный вариант кольца')->view('emails.saved.result');
    }
}
