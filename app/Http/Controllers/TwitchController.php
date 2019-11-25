<?php

namespace App\Http\Controllers;

use App\Jobs\ResubscribeTwitchWebhook;
use App\Jobs\UpdateTwitchStream;
use Illuminate\Http\Request;

class TwitchController extends Controller
{
    public function subscribe(Request $request, int $twitch_id)
    {
        $challenge = $request->get('hub_challenge');

        \Log::info('Twitch confirm subscription for: ' . $twitch_id);
        ResubscribeTwitchWebhook::dispatch($twitch_id)->delay(now()->addDays(10));

        return response($challenge);
    }

    public function update(Request $request, int $twitch_id)
    {
        UpdateTwitchStream::dispatch($request->get('data'), $twitch_id);

        return response('ok');
    }
}
