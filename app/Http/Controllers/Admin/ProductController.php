<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();
        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }
        if ($request->filled('kategori')) {
            $query->where('category_id', $request->kategori);
        }

        return view('admin.products.index', [
            'products'   => $query->paginate(20)->withQueryString(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.products.form', [
            'product'    => new Product(['durum' => true, 'stock' => 0]),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['cover'] = $this->resolveImage($request, $data['cover'] ?? null);
        $data['images'] = $data['cover'] ? [$data['cover']] : null;
        $data['attributes'] = $this->parseAttributes($request->input('attributes_raw'));

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Ürün eklendi.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product);
        if ($data['name'] !== $product->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        }
        $data['cover'] = $this->resolveImage($request, $data['cover'] ?? $product->cover);
        $data['images'] = $data['cover'] ? [$data['cover']] : null;
        $data['attributes'] = $this->parseAttributes($request->input('attributes_raw'));

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Ürün güncellendi.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Ürün silindi.');
    }

    protected function validateData(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'name'        => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'brand'       => 'nullable|string|max:100',
            'sku'         => 'nullable|string|max:60',
            'cover'       => 'nullable|string|max:500',
            'short_desc'  => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'featured'    => 'nullable',
            'durum'       => 'nullable',
            'image_file'  => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]) + [
            'featured' => $request->boolean('featured'),
            'durum'    => $request->boolean('durum'),
        ];
    }

    protected function resolveImage(Request $request, ?string $current): ?string
    {
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            // Uzantıyı istemciden değil, doğrulanmış dosya içeriğinden türet (polyglot/.php yükleme önlemi)
            $allowed = ['jpg' => 'jpg', 'jpeg' => 'jpg', 'png' => 'png', 'webp' => 'webp', 'gif' => 'gif'];
            $ext = $allowed[strtolower($file->guessExtension() ?: '')] ?? 'jpg';
            $name = Str::random(20).'.'.$ext;
            $dir = public_path('uploads/products');
            if (! is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }
            $file->move($dir, $name);
            return asset('uploads/products/'.$name);
        }
        return $current ?: null;
    }

    protected function parseAttributes(?string $raw): ?array
    {
        if (! $raw) {
            return null;
        }
        $attrs = [];
        foreach (preg_split('/\r?\n/', $raw) as $line) {
            if (! str_contains($line, ':')) {
                continue;
            }
            [$k, $v] = array_map('trim', explode(':', $line, 2));
            if ($k !== '' && $v !== '') {
                $attrs[$k] = $v;
            }
        }
        return $attrs ?: null;
    }

    protected function uniqueSlug(string $name, ?int $ignore = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;
        while (Product::where('slug', $slug)->when($ignore, fn ($q) => $q->where('id', '<>', $ignore))->exists()) {
            $slug = $base.'-'.(++$i);
        }
        return $slug;
    }
}
