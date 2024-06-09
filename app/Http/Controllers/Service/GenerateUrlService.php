<?php

namespace App\Http\Controllers\Service;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PengumumanService
{
    public function generate($targetUrl)
    {
        $expirationDays = 30;
        $secretKey = 'your_secret_key'; // Replace with your secret key

        // Generate expiration timestamp
        $expirationTime = Carbon::now()->addDays($expirationDays)->timestamp;

        // Append expiration timestamp to the URL
        $urlWithExpiration = $targetUrl . '?expires=' . $expirationTime;

        // Generate token
        $token = Hash::make($urlWithExpiration . $secretKey);

        // Encode token and expiration timestamp
        $encodedToken = urlencode($token);

        // Generate temporary URL
        $temporaryUrl = $targetUrl . '?expires=' . $expirationTime . '&token=' . $encodedToken;

        return $temporaryUrl;
    }
}
