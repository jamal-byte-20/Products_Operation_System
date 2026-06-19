<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterController extends Controller
{
        public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email'
        ]);
        
        // حفظ البريد الإلكتروني
        // Newsletter::create(['email' => $request->email]);
        
        return redirect()->back()->with('success', 'تم الاشتراك في النشرة البريدية بنجاح!');
    }
}
