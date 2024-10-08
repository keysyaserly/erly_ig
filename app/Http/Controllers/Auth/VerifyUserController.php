<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VerifyUserController extends Controller
{
    // Menampilkan form untuk verifikasi email
    public function __invoke(Request $request)
    {
        if (! $request->user()->hasVerifiedEmail()) {
            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }

            return redirect()->route('verification.notice');
        }

        return redirect()->route('home');
    }
}
