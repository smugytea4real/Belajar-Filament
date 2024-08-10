<?php

namespace App\Filament\Auth;


use Filament\Http\Responses\Auth\Contracts\LogoutResponse as Responsable;
use Illuminate\Http\RedirectResponse;

class MyLogoutResponse implements Responsable
{

    public function toResponse($request)
    {
        return redirect()->route('welcome');
    }
}