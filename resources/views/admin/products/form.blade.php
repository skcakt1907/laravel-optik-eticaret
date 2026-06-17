@extends('admin.layout')
@section('title', $product->exists ? 'Ürün Düzenle' : 'Yeni Ürün')

@section('content')
<form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="form-a">
    @csrf
    @if($product->exists)@method('PUT')@endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-a">
                <label>Ürün Adı *</label>
                <input name="name" value="{{ old('name', $product->name) }}" required>

                <label>Kısa Açıklama</label>
                <input name="short_desc" value="{{ old('short_desc', $product->short_desc) }}">

                <label>Detaylı Açıklama</label>
                <textarea name="description" rows="6">{{ old('description', $product->description) }}</textarea>

                <label>Özellikler (her satır <code>anahtar: değer</code>)</label>
                <textarea name="attributes_raw" rows="5" placeholder="Çerçeve Tipi: Asetat&#10;Renk: Siyah&#10;Cinsiyet: Unisex">{{ old('attributes_raw', $product->attributes ? collect($product->attributes)->map(fn($v,$k)=>"$k: $v")->implode("\n") : '') }}</textarea>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-a">
                <label>Kategori</label>
                <select name="category_id">
                    <option value="">— Seçiniz —</option>
                    @foreach($categories as $c)<option value="{{ $c->id }}" @selected(old('category_id', $product->category_id)==$c->id)>{{ $c->name }}</option>@endforeach
                </select>

                <label>Marka</label>
                <input name="brand" value="{{ old('brand', $product->brand) }}">

                <label>SKU / Stok Kodu</label>
                <input name="sku" value="{{ old('sku', $product->sku) }}">

                <div class="row">
                    <div class="col-6"><label>Fiyat (₺) *</label><input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required></div>
                    <div class="col-6"><label>İndirimli (₺)</label><input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}"></div>
                </div>

                <label>Stok Adedi *</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required>

                <label class="mt-3"><input type="checkbox" name="featured" value="1" @checked(old('featured', $product->featured)) style="width:auto"> Öne çıkan ürün</label>
                <label><input type="checkbox" name="durum" value="1" @checked(old('durum', $product->durum ?? true)) style="width:auto"> Yayında (aktif)</label>
            </div>

            <div class="card-a mt-3">
                <label>Görsel</label>
                @if($product->image_url)<img src="{{ $product->image_url }}" style="width:100%;border-radius:10px;margin-bottom:.6rem">@endif
                <label>Görsel URL</label>
                <input name="cover" value="{{ old('cover', $product->cover) }}" placeholder="https://...">
                <label>veya Dosya Yükle</label>
                <input type="file" name="image_file" accept="image/*">
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button class="btn-a"><i class="bi bi-check-lg"></i> Kaydet</button>
        <a href="{{ route('admin.products.index') }}" class="btn-a sec">Vazgeç</a>
    </div>
</form>
@endsection
