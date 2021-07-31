@component('mail::message')
# Hi there, {{ $registration->name }}.

We're so glad you registered for <b>{{ $registration->event->title }}</b>, and we can't wait to see you tomorrow. 
We just wanted to go over a couple of things with you prior to the event.

First things first, here's a copy of the information you gave us when you registered. Double check your information 
is correct. If anything looks wrong please let us know <a href="{{ route('landing.contact') }}?confirmationNumber={{ $registration->confirmation_number }}">here</a>,
and we'll update your registration.

@component('mail::table')
| Name       | Email         | Mile Time  | Confirmation #  |
| :-------------: |:-------------:| :--------:| :--------:|
| {{ $registration->name }}      | {{ $registration->email }}      | {{ $registration->mile_time }}      | {{ $registration->confirmation_number }}     |
@endcomponent

We also wanted to reiterate and finalize some of the event details with you.

@component('mail::panel')
1. This event will be held at <b>{{ $registration->event->location }}</b>.
    
    - You'll want to park in the lot near Freedom Circle, as check-in is going to be stationed near the gate heading towards the track.

2. Check in is tomorrow, <b>July 31st at 2:00 PM</b>. The race will begin shortly after that. We reccomend that you get here a couple minutes early so we can check everyone in, in a timely manner. 

3. You will need your <b>confirmation number to check in</b>!

4. If you added a t-shirt onto your order, we'll give this to you at check-in.
@endcomponent

And lastly, your confirmation number for your registration is <b>{{ $registration->confirmation_number }}.</b> We use this number to check you in. 
To make your experience fast and efficient, we reccomend you bring the QR code at the bottom of this email with you on the day of the event.

{!! QrCode::size(250)->generate("$registration->confirmation_number") !!}

@component('mail::subcopy')
    Some email clients don't always load the QR code correctly. If your QR code isn't visible in this email, 
    please click the button below that says "View your Registrations" and log into your Chocolate Milk Mile account.
    If you forgot your password, please <a href="{{ route('landing.contact') }}?confirmationNumber={{ $registration->confirmation_number }}">reach out</a> to us and we can get you back into your account.
@endcomponent

@component('mail::button', ['url' => route('registration.index')])
    View your Registrations
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
