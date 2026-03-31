<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PublicSettingsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => [
                'shop_name' => config('shop.name'),
                'shop_tagline' => config('shop.tagline'),
                'whatsapp_number' => config('shop.whatsapp_number'),
                'currency' => config('shop.currency', 'USD'),
            ],
        ]);
    }
}
