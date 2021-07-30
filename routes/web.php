<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ContactSubmissionController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\RegistrationConfirmationController;
use App\Http\Controllers\ManagementPageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrantController;
use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Auth;

use App\Models\Registration;
use App\Models\Event;

use App\Events\RegistrantCheckedIn;

use App\Mail\RegistrationConfirmed;

use App\Exceptions\AlreadyCheckedInException;
use App\Mail\RegistrationDetails;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name("landing.home");
Route::get('/contact', [ContactSubmissionController::class, 'create'])->name("landing.contact");
Route::post('/contact', [ContactSubmissionController::class, 'post'])->name("landing.contact.post");
Route::get('/about', function () {
    return view('about');
})->name("landing.about");
Route::get('/photos', function () {
    return view('photos');
})->name("landing.photos");

// User End
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/registrations', [EventRegistrationController::class, 'index'])->name('registration.index');
Route::get('/events/{event}/register', [EventRegistrationController::class, 'get'])->name('registration');
Route::post('/events/{event}/register', [EventRegistrationController::class, 'post'])->name('registration.post');
Route::get('/events/{event}/registrations/{registration}/confirmation', [RegistrationConfirmationController::class, 'get'])->name('registration.confirmation');

Route::get('/user/api/registrations', function(){
    return Auth::user()->registrations;
});

Route::get('/getreg/{registration}', function(Registration $registration){
    return (new RegistrationDetails($registration))->render();
});

Auth::routes();
Broadcast::routes();

// Admin End
Route::middleware(['manager'])->group(function (){
    Route::get('/manager', [ManagementPageController::class, 'index']);

    Route::get('/manager/support', [ContactSubmissionController::class, 'index']);
    Route::post('/manager/support/{contactSubmission}/delete', [ContactSubmissionController::class, 'delete']);

    Route::get('/manager/events/create', [EventController::class, 'create']);
    Route::post('/manager/events/create', [EventController::class, 'post']);

    Route::get('/manager/registrants', [RegistrantController::class, 'index']);
    Route::post('/manager/registrants', function (Request $request){
        return Registration::confirmed()->where('event_id', $request->event_id)->get();
    });

    Route::get('/manager/check-in', [ManagementPageController::class, 'checkin']);
    Route::post('/manager/check-in', function (Request $request){
        try {

            $registration = Registration::where('confirmation_number', $request->confirmation_number)
                ->firstOrFail()
                ->checkIn();

            $event = $registration->event;

            event(new RegistrantCheckedIn($registration));

            return [
                'registration' => $registration,
                'event' => $event
            ];
        } catch (AlreadyCheckedInException $exception){
            return response([
                'error' => 'This registrant is already checked in.',
            ], 422);
        }
    });

    Route::get('/manager/api/event/{event}/registrants', function(Event $event){
        return $event->registrations;
    });
    Route::get('/manager/api/confirmation/{confirmationNumber}', function ($confirmationNumber){
        return Registration::where('confirmation_number', $confirmationNumber)->firstOrFail();
    });

});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
