<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MedicineController extends Controller
{ 
    protected $httpClient;
    protected $baseUrl;

    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = env('API_BASE_URL');
    }

    protected function getToken()
    {
        $cacheKey = 'api_token';

        if (Cache::has($cacheKey)) {
            $cachedData = Cache::get($cacheKey);
            $token = $cachedData['token'];
            $expiresAt = $cachedData['expires_at'];

            // Check if token is expired
            if ($expiresAt > now()->timestamp) {
                return $token; // Return token if it's still valid
            }
        }

        // Fetch a new token if not cached or expired
        try {
            $response = $this->httpClient::post($this->baseUrl.'/auth', [
                'email' => env('API_AUTH_EMAIL'),
                'password' => env('API_AUTH_PASSWORD')
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // dd($data);
                $token = $data['access_token'];
                $expiresIn = $data['expires_in']; // Token expiration time in seconds

                // Store the new token and expiration time in the cache
                Cache::put($cacheKey, [
                    'token' => $token,
                    'expires_at' => now()->addSeconds($expiresIn)->timestamp
                ], now()->addSeconds($expiresIn)); // Expire the cache at token's expiration

                return $token;
            } else {
                Log::error('Failed to fetch API token', ['response' => $response->body()]);
                return null; // Return null if token fetching failed
            }
        } catch (\Exception $e) {
            Log::error('Error fetching API token', ['error' => $e->getMessage()]);
            return null;
        }
    }


    public function getMedicines(Request $request)
    {
        $token = $this->getToken();
        // dd($token);
        if ($token) {
            $response = $this->httpClient::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get($this->baseUrl.'/medicines');

            return $this->apiResponse($response);
        } else {
            return response()->json(['error' => 'Unable to fetch token'], 500);
        }
    }

    public function getMedicinePrices(Request $request, $medicineId)
    {
        $token = $this->getToken();

        if ($token) {
            $response = $this->httpClient::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get($this->baseUrl."/medicines/{$medicineId}/prices");

            return $this->apiResponse($response);
        } else {
            return response()->json(['error' => 'Unable to fetch token'], 500);
        }
    }

    protected function apiResponse($response)
    {
        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => $response->body()], $response->status());
    }

}
