<?php

namespace App\Traits;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification as NN;
use App\Models\User;

trait EmailTrait
{
    protected function sendRegistration(User $user){
        $emailData = [
            'subject' => 'Laravel Training Registration',
            'greeting' => 'Welcome to Laravel Training',
            'line' => [
                'Thank you '.$user->name.' for register with Laravel Tarining .',
            ],
            'url' => 'home',
            'wording' => 'eSWIS Login',
        ];
        NN::route('mail', $user->email)->notify(new EmailNotification($emailData, null, $user));
    }
}
