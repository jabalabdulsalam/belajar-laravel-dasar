<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function createSession(Request $request): string
    {
        $request->session()->put("userId", "jabal");
        $request->session()->put("isMember", true);
        return "Oke";
    }

    public function getSession(Request $request)
    {
        $userId = $request->session()->get('userId', 'guest');
        $isMember = $request->session()->get('isMember', 'false');

        return "User ID : ${userId}, Is Member : ${isMember}";
    }
}
