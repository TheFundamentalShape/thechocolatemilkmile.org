<?php

namespace App\Console\Commands;

use App\Mail\RegistrationDetails;
use Illuminate\Console\Command;
use App\Models\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;

class SendConfirmationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registrations:send {event}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a confirmation email with a QR code to the email address listed on every registration in the specified event.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public $event;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // if in production, confirm this action was intended.
        if(env('APP_ENV') == 'production') {
            $this->alert("Your application is in production!");
            if(!$this->confirm("Are you sure you want to continue with this action? Doing so will send an email to every registrant participating in this event (Yes/No)")){
                return 1;
            }
        }

        // find the event passed in, ensure it exists
        try {
            $this->event = Event::findOrFail($this->argument('event'));
        } catch (ModelNotFoundException $exception) {
            $this->warn("The event with an ID of " . $this->argument("event") . " does not exist.");
            return 1;
        }

        // for each registration, find the email address associated with it, and send a confirmation mailable.
        foreach($this->event->registrations as $registration){
            Mail::to($registration->user->email)
                ->send(new RegistrationDetails($registration));
        }

        return 0;
    }
}
