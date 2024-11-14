<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function fetchData()
    {
        // Create Guzzle client
        $client = new Client();

        try {
            $response = $client->request('POST', 'https://api.example.com/data', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'key' => 'value',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);
                return response()->json($data); // Return response data
            } else {
                Log::error('API request returned non-200 status: ' . $response->getStatusCode());
                return response()->json(['error' => 'Failed to fetch data'], 500);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('API Request Failed: ' . $e->getMessage());
            return response()->json(['error' => 'API request failed'], 500);
        }
    }
}
