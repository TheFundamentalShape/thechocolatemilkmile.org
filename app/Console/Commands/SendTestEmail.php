<?php

namespace App\Console\Commands;

use App\Models\Registration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationDetails;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to the email address provided as the argument.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(env('APP_ENV') == 'production') {
            $this->alert("Your application is in production!");
            if(!$this->confirm("Are you sure you want to continue with this action? This will send an email with PII to whatever address you specified. (Yes/No)")){
                return 1;
            }
        }

        $email = $this->argument('email');

        try {
            $registration = Registration::where('email', $email)->firstOrFail();
            Mail::to($registration->email)
                        ->send(new RegistrationDetails($registration));
        } catch (\Exception $exception) {
            $this->warn('Could not send email.');
        } catch (ModelNotFoundException $exception){
            $this->warn("No entry exists with that email address.");
        }

        return 0;
    }
}
