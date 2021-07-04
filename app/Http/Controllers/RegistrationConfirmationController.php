<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Event;
use Illuminate\Http\Request;

class RegistrationConfirmationController extends Controller
{
    public function get(Event $event, Registration $registration)
    {
        return view('event.confirmation', [
            'event' => $event,
            'registration' => $registration
        ]);
    }
}
