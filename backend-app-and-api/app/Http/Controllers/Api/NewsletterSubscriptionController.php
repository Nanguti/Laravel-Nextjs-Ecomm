<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:newsletter_subscriptions',
        ]);

        $subscriber = NewsletterSubscription::create([
            'email' => $validatedData['email'],
            'country' => $request->country ? $request->countyr : 'Kenya'
        ]);

        return response()->json([
            'message' => 'Subscription successful',
            'subscriber' => $subscriber
        ]);
    }
}
