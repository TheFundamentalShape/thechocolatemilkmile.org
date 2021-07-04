<?php

namespace App\Billing;


use App\Models\Registration;

interface PaymentGateway
{
    public function charge(Registration $registration, $token);
}