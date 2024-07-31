<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AutocompleteController extends Controller
{
    public function getCompletion(Request $request)
    {
        $code = $request->input('code');
        $language = $request->input('language'); 
        
        $apiKey = config('services.openai.api_key');

        
        if (!$apiKey) {
            return response()->json(['error' => 'API key not configured.'], 500);
        }

       
        $prompt = "Complete the following $language code:\n\n$code\n\n";

       
        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false, 
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'max_tokens' => 150,
            'temperature' => 0.5,
            'top_p' => 1,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        // Check for successful response
        if ($response->failed()) {
            return response()->json(['error' => 'API request failed.', 'details' => $response->json()], $response->status());
        }

        return response()->json($response->json());
    }
}
