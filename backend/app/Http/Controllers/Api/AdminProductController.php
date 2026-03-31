<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Product::query()
                ->orderByDesc('is_active')
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->orderBy('brand')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'data' => $product,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validatedData($request);
        $data = $this->prepareData($request, $data);

        $product = Product::create($data);

        return response()->json([
            'message' => 'Product created successfully.',
            'data' => $product,
        ], 201);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $data = $this->validatedData($request, $product->id);
        $data = $this->prepareData($request, $data, $product);

        $product->update($data);

        return response()->json([
            'message' => 'Product updated successfully.',
            'data' => $product->fresh(),
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->deleteLocalImageIfNeeded($product->image_url);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }

    protected function validatedData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'brand' => ['required', 'string', 'max:120'],
            'name' => ['required', 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:180', Rule::unique('products', 'slug')->ignore($ignoreId)],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'is_featured' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    protected function prepareData(Request $request, array $data, ?Product $product = null): array
    {
        if (blank($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['brand'] . ' ' . $data['name']);
        }

        $data['slug'] = $this->uniqueSlug($data['slug'], $product?->id);
        $data['remove_image'] = (bool) ($data['remove_image'] ?? false);

        if ($data['remove_image'] && $product) {
            $this->deleteLocalImageIfNeeded($product->image_url);
            $data['image_url'] = null;
        }

        if ($request->hasFile('image_file')) {
            if ($product) {
                $this->deleteLocalImageIfNeeded($product->image_url);
            }

            $file = $request->file('image_file');
            $extension = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'jpg');
            $filename = Str::random(40) . '.' . $extension;
            $path = $file->storeAs('products', $filename, 'public');

            $data['image_url'] = Storage::url($path);
        } elseif (array_key_exists('image_url', $data) && blank($data['image_url'])) {
            $data['image_url'] = $product?->image_url;
        }

        unset($data['image_file'], $data['remove_image']);

        return $data;
    }

    protected function deleteLocalImageIfNeeded(?string $imageUrl): void
    {
        if (! $imageUrl || ! str_starts_with($imageUrl, '/storage/')) {
            return;
        }

        $relativePath = Str::after($imageUrl, '/storage/');

        if ($relativePath && Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }

    protected function uniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug;
        $counter = 1;

        while (
            Product::query()
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}