<?php

namespace App\Http\Controllers;

use App\RingSession;
use App\User;
use App\Order;

use App\Mail\RingOrderManager;
use App\Mail\RingOrderUser;

class RingSessionController extends Controller
{


    public function index(){

      $ring_sessions=RingSession::all();

      return $ring_sessions;
    }

    public function create(){

      $data=request()->all();

      $total_price=$data['store']['totalPrice'];

      $contents=json_encode($data['store']['session']);

      $session_params['contents']=$contents;

      $user_params['name']=$data['data'][1]['value'];
      $user_params['email']=$data['data'][2]['value'];
      $user_params['password']=md5('2313');

      if (! $user=User::where('email',$user_params['email'] )->first()){
        $user=User::create($user_params);
      }

      $session=RingSession::create($session_params);

      $order_params['user_id']=$user->id;
      $order_params['ring_session_id']=$session->id;
      $order_params['totalprice']=$total_price;

      $order=Order::create($order_params);

      $manager_email='info@brilliantrings.ru';

      $store=$data['store'];
      $formdata=$data['data'];


        $store=$data['store'];


      //to manager
      \Mail::to($manager_email)->send(new RingOrderManager($data));

      //to user

      \Mail::to($user_params['email'])->send(new RingOrderUser($data));
    }
}
