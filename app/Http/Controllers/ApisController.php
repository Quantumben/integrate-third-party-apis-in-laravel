<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApisController extends Controller
{
    public function fetchData()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.example.com/data', [
                'key' => 'value',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data); // Return the data as JSON
            } else {
                Log::error('API request returned non-200 status: ' . $response->status());
                return response()->json(['error' => 'Failed to fetch data'], 500);
            }
        } catch (\Exception $e) {
            Log::error('API Request Failed: ' . $e->getMessage());
            return response()->json(['error' => 'API request failed'], 500);
        }
    }
}
