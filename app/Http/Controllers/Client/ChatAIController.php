<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatAIController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        if (!$message) {
            return response()->json(['reply' => 'Vui lòng nhập tin nhắn!'], 400);
        }

        $apiKey = env('GOOGLE_GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['reply' => 'Chưa cấu hình API key!'], 500);
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $apiKey,
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
                'contents' => [
                    ['parts' => [['text' => $message]]]
                ]
            ]);

            $data = $response->json();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Lỗi khi gọi Google Gemini: ' . $e->getMessage()], 500);
        }
    }
}