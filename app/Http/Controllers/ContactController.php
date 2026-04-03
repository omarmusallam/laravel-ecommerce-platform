<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('front.contact');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'subject' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'numeric', 'digits:10'],
            'message' => ['required', 'string'],
        ]);
        $data = [
            'name' => $request->name,
            'subject' => $request->subject,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];

        $recipient = Setting::query()->value('email') ?: config('mail.from.address');

        Mail::to($recipient)->send(new ContactMail($data));

        return view('front.mail')->with('success', trans('Message sent successfully!'));
    }
}
