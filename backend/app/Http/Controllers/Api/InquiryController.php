<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Inquiry::query()
                ->with('product:id,brand,name,slug')
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:160'],
            'message' => ['required', 'string', 'max:2000'],
            'source' => ['nullable', 'string', 'max:50'],
        ]);

        $inquiry = Inquiry::create($data);

        $product = null;

        if (! empty($data['product_id'])) {
            $product = Product::query()->find($data['product_id']);
        }

        $lines = [
            'New fragrances.guru inquiry',
            'Name: ' . $data['name'],
            'Phone: ' . $data['phone'],
        ];

        if (! empty($data['email'])) {
            $lines[] = 'Email: ' . $data['email'];
        }

        if ($product) {
            $lines[] = 'Product: ' . $product->brand . ' - ' . $product->name;
        }

        $lines[] = 'Message: ' . $data['message'];

        $whatsAppNumber = preg_replace('/\D+/', '', (string) config('shop.whatsapp_number'));
        $whatsAppUrl = $whatsAppNumber
            ? 'https://wa.me/' . $whatsAppNumber . '?text=' . rawurlencode(implode("\n", $lines))
            : null;

        return response()->json([
            'message' => 'Inquiry saved successfully.',
            'data' => $inquiry,
            'whatsapp_url' => $whatsAppUrl,
        ], 201);
    }
}
