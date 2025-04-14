<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MistralController extends Controller
{
    
    public function ask(Request $request) {

        $prompt = $request -> input('prompt');

        $apiKey = env('MISTRAL_API_KEY');

        // Send the prompt to the Mistral API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.mistral.ai/v1/chat/completions', [
            'model' => 'mistral-small',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        
       
        if ($response->successful()) {
            $data = $response->json();


            // Process the data received from the API
            dd($data);

            return redirect()->back()->with('success', 'Prompt sent successfully!');
        } else {
            return redirect()->back()->with('error', 'Error while sending the prompt.');
        }
    }

    public static function askMistral(string $prompt, string $model = 'mistral-small'): ?string
    {
        $apiKey = env('MISTRAL_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.mistral.ai/v1/chat/completions', [
            'model' => $model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.5
        ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'];
        }

        return null;
    }


    
}
