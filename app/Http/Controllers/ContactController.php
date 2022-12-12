<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "content" => "required",
        ]);

        Contact::create($request->all());

        return response([
            "message" => "We recived your message successfully",
            "status" => 200
        ]);
    }
}
