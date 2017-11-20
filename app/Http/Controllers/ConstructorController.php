<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConstructorController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($base,$material)
    {
      return view('constructor/base',compact('material','base'));
    }
    public function getprice($shape,$weight,$color,$clarity){



        $weights=\App\RingOptionValue::where('ring_option_id','=',7)->get();

        foreach ($weights->toArray() as $weight_arr){
          if ($weight_arr['value']==$weight){

            $weight=$weight_arr['title'];
          }
        }


        $shape_aliases=array(
          1=>'round',
          2=>'princess',
          3=>'oval',
          4=>'asscher',
          5=>'heart',
          6=>'pear',
          7=>'cushion',
          8=>'emerald'
        );


        $color_aliases=array(
          1=>'d',
          2=>'e',
          3=>'f',
          4=>'g',
          5=>'h',
          6=>'i',
          7=>'j',
          8=>'k-n',
          9=>'o-z'
        );

        $clarity_aliases=array(
          1=>'if',
          2=>'vvs1',
          3=>'vvs1',
          4=>'vvs2',
          5=>'vs1',
          6=>'vs2',
          7=>'si1',
          8=>'si3',
          9=>'i1',
          10=>'i2',
          11=>'i3',
          12=>'i3'
        );


        //use nusoap library: http://sourceforge.net/projects/nusoap/
        //tested with php 5, nusoap version 0.9.5
        require_once('lib/nusoap.php');


        //prepare soap request to Rapaport:
        $rap_soapUrl = "https://technet.rapaport.com/webservices/prices/rapaportprices.asmx?wsdl";
        $soap_Client = new \nusoap_client($rap_soapUrl, 'wsdl');
        $rap_credentials['Username'] = "qucawnvvxoe0aeueyhbgc1hwkkejgb";
        $rap_credentials['Password'] = "vcR3jGQ3";

        //do login, and save authentication ticket for further use:
        $result = $soap_Client->call('Login', $rap_credentials);
        $rap_auth_ticket = $soap_Client->getHeaders();

        //get price for single diamond
        $paramsA["shape"] = $shape_aliases[$shape];
        $paramsA["size"] = $weight;
        $paramsA["color"] = $color_aliases[$color];
        $paramsA["clarity"] = $clarity_aliases[$clarity];
        $soap_Client->setHeaders($rap_auth_ticket);
        $result = $soap_Client->call('GetPrice', $paramsA);

        if (count($result)==1) {

            return $result['GetPriceResult'];


        }
    }
}
