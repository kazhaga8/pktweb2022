<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SendEmailController;

class ApiController extends Controller
{
    public function tesemail(Request $request)
    {
        $body = [];
        $body['name'] = "tesemail";
        $body['email'] = "tesemail";
        $body['password'] = "tesemail";
        
        $dataEmail = [];
        $dataEmail['body'] = $body;
        $dataEmail['view'] = "mail.forgotpassword";
        $dataEmail['subject'] = "[PKT WEB] - Password Baru Anda";
        $dataEmail = json_decode(json_encode($dataEmail));
        $mailto = "sangrezha@gmail.com";
        Mail::to($mailto)->send(new SendEmailController($dataEmail));
    }

}
