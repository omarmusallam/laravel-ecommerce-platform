<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SendSms extends Controller
{
    public function send(): JsonResponse
    {
        abort_unless(App::environment('local'), Response::HTTP_NOT_FOUND);

        $key = config('services.vonage.key');
        $secret = config('services.vonage.secret');
        $from = config('services.vonage.from');
        $recipient = config('services.vonage.test_to');

        abort_unless($key && $secret && $recipient, Response::HTTP_SERVICE_UNAVAILABLE);

        $basic = new \Vonage\Client\Credentials\Basic($key, $secret);
        $client = new \Vonage\Client($basic);

        $client->sms()->send(
            new \Vonage\SMS\Message\SMS($recipient, $from, 'Test message from the local environment.')
        );

        return response()->json([
            'message' => 'SMS was sent successfully.',
        ]);
    }
}
