<?php

namespace App\Services;

use App\Models\SoilAnalysis;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RecommendationService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
        $this->client = new Client([
            'base_uri' => 'https://api.groq.com/openai/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function generateRecommendation(SoilAnalysis $analysis)
    {
        $prompt = $this->buildPrompt($analysis);

        try {
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        [
                            'role' => 'system', 
                            'content' => 'Siz malakali agronom mutaxassissiz. Tuproq va atrof-muhit ma\'lumotlarini tahlil qiling va o\'zbek tilida batafsil qishloq xo\'jaligi tavsiyalarini bering (Markdown formatida). Shuningdek, oxirida "recommended_crops" (massiv) va "fertilizer_plan" (obyektlar massivi: "type" va "amount" maydonlari bilan) kalitlari bo\'lgan JSON blokini qaytaring.'
                        ],
                        [
                            'role' => 'user', 
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 4000,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            if (!isset($data['choices'][0]['message']['content'])) {
                throw new \Exception('Unexpected Groq API response structure');
            }

            $content = $data['choices'][0]['message']['content'];

            return $this->parseResponse($content);
        } catch (\Exception $e) {
            Log::error('Groq API Error: ' . $e->getMessage());
            return [
                'content' => 'Unable to generate recommendation at this time. Please try again later.',
                'recommended_crops' => [],
                'fertilizer_plan' => []
            ];
        }
    }

    protected function buildPrompt(SoilAnalysis $analysis)
    {
        $farm = $analysis->farm;
        $soilType = ($farm->soil_type && $farm->soil_type !== 'Unknown') ? $farm->soil_type : "Noma'lum (tahlil ma'lumotlariga qarab aniqlashga harakat qiling)";
        $cropInfo = $analysis->target_crop ? "Ekilgan/Ekilmoqchi bo'lgan ekin: {$analysis->target_crop}" : "Ekin turi ko'rsatilmagan (eng mos ekinlarni tavsiya qiling)";
        
        return "Iltimos, quyidagi xo'jalik uchun tuproq va atrof-muhit tahlili ma'lumotlarini tahlil qiling:
        Xo'jalik nomi: {$farm->name}
        Joylashuvi: {$farm->location}
        Tuproq turi: {$soilType}
        {$cropInfo}
        
        Tahlil ma'lumotlari:
        - pH darajasi: {$analysis->ph}
        - Unumdorlik (Fertility): {$analysis->fertility} (3000 dan)
        - Namlik: {$analysis->moisture}%
        - Harorat: {$analysis->temperature}°C
        - Quyosh nuri (Sunlight): {$analysis->sunlight} LUX
        - Namlik (Humidity): {$analysis->humidity}%
        
        Quyidagilarni taqdim eting:
        1. Atrof-muhit va tuproq holatini baholash.
        2. " . ($analysis->target_crop ? "Ushbu ekin ({$analysis->target_crop}) uchun ushbu sharoit qanchalik mos ekanligini baholang va uni yetishtirish bo'yicha maxsus maslahatlar bering." : "Ushbu sharoitda yaxshi o'sadigan tavsiya etilgan ekinlar.") . "
        3. Maxsus parvarish va o'g'itlash rejasi.
        4. Quyosh nuri yoki namlikni optimallashtirish bo'yicha maslahatlar.
        
        MUHIM: Barcha tavsiyalar aynan ko'rsatilgan ekinga ({$analysis->target_crop}) qaratilgan bo'lishi kerak.";
    }

    protected function parseResponse($content)
    {
        // Extract JSON if present
        $jsonPattern = '/```json\s*(\{.*?\})\s*```/s';
        if (preg_match($jsonPattern, $content, $matches)) {
            $jsonData = json_decode($matches[1], true);
            $cleanContent = preg_replace($jsonPattern, '', $content);
        } else {
            $jsonData = [
                'recommended_crops' => [],
                'fertilizer_plan' => []
            ];
            $cleanContent = $content;
        }

        return [
            'content' => trim($cleanContent),
            'recommended_crops' => $jsonData['recommended_crops'] ?? [],
            'fertilizer_plan' => $jsonData['fertilizer_plan'] ?? []
        ];
    }
}
