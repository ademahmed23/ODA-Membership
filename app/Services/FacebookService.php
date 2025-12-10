<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class FacebookService
{
    public function getPageInfo()
    {
        $pageId = env('FACEBOOK_PAGE_ID');
        $token  = env('FACEBOOK_PAGE_TOKEN');

        $response = Http::get("https://graph.facebook.com/v24.0/{$pageId}", [
            'fields' => 'followers_count,name',
            'access_token' => $token,
        ]);

       if ($response->successful()) {
            return [
                'name' => $response->json()['name'] ?? 'Unknown',
                'followers' => $response->json()['followers_count'] ?? 0,
            ];
        }

        return ['name' => 'Unavailable', 'followers' => 0];

    // fallback if API fails
    }
}
