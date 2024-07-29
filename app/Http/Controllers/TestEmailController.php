<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

use Illuminate\Http\Request;

class TestEmailController extends Controller
{
     public function sendTestEmail()
    {
        $to_email = 'test@example.com';
        Mail::to($to_email)->send(new TestEmail());
        return 'Test email sent';
    }
}
