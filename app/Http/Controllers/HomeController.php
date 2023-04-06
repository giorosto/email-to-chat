<?php

namespace App\Http\Controllers;

use App\Mail\NewMessage;
use App\Models\EmailMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'message' => 'required',
        ]);

        EmailMessage::create([
            'body' => $request->message,
            'from' => auth()->id(),
            'to' => $request->user_id,
            'was_replied' => 0,
        ]);
        $email = User::where('id',$request->input('user_id'))
            ->first()->email;
        Mail::to($email)->send(new NewMessage($email,$request->message));

        return back()->with('message_sent', 'Email has been sent!');
    }
}
