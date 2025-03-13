<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\connect_model;
use App\Mail\connect_mail;
use App\Mail\connect_subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class contactus extends Controller
{
    //
    public function index()
    {
        return view('web.contactus');
    }

    public function connect_subscribe(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'purpose' => 'MATIX Subscription',
            'message' => 'guest has subscribed to the newsletter mailing list.',
        ];
        
        $subscriber = connect_model::create($data);
        
        try {
            Mail::to($subscriber->email)
                ->send(new connect_subscribe($subscriber));
                
            return redirect()->back()->with('success', 'Thank you for subscribing! We\'re excited to have you on board.');
        } catch (\Exception $e) {
            
            \Log::error('Failed to send subscription confirmation email: ' . $e->getMessage());
            
            return redirect()->back()->with('warning', 'You\'re subscribed, but email confirmation is unavailable. Hang tight!');
        }
    }

    public function connect_submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'purpose' => 'required|string|max:200',
            'message' => 'required|string',
        ]);
        
        $connect = connect_model::create($validated);
        
        try {
            Mail::to(config('mail.admin_email', 'matix.upcebu@up.edu.ph'))
                ->send(new connect_mail($connect));
                
            return redirect()->back()->with('success', 'Thanks for reaching out. We will contact you soon!');
        } catch (\Exception $e) {

            \Log::error('Failed to send contact form email: ' . $e->getMessage());
            
            return redirect()->back()->with('warning', 'Sorry, something\'s wrong. Our team will still receive your message.');
        }
    }
}
