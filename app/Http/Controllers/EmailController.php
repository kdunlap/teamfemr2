<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use App\User;
class EmailController extends Controller
{
    public function index( )
    {
        Mail::send('emails.test', ['name' => 'fEMR Admin'], function($message)
        {
            $message->to('femrsquad@gmail.com','Admin')->from('femrsquad@gmail.com')->subject('Please approve fEMR survey.');
        });
        return view('tripdatabase');
    }

}