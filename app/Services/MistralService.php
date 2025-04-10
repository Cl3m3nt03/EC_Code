<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MistralService
{
    protected $endpoint = 'https://api.mistral.ai/v1/chat/completions';

    public function generateText($prompt)
    {
        $response = Http::withToken(env('MISTRAL_API_KEY'))
            ->post($this->endpoint, [
                'model' => 'mistral-tiny',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.5,
            ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'];
        }

        return 'Erreur: ' . $response->body();
    }
}