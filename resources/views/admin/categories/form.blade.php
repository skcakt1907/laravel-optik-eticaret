@extends('admin.layout')
@section('title', $category->exists ? 'Kategori Düzenle' : 'Yeni Kategori')

@section('content')
@php
$iconlar = [
    'bi-eyeglasses'       => 'Gözlük (numaralı)',
    'bi-sun'              => 'Güneş Gözlüğü',
    'bi-eye'              => 'Göz',
    'bi-eye-fill'         => 'Göz (dolu)',
    'bi-circle'           => 'Kontakt Lens',
    'bi-circle-half'      => 'Lens (yarım)',
    'bi-droplet'          => 'Lens Solüsyonu',
    'bi-droplet-half'     => 'Nem / Bakım',
    'bi-emoji-smile'      => 'Çocuk Gözlüğü',
    'bi-emoji-sunglasses' => 'Şık / Trend',
    'bi-bullseye'         => 'Numara / Görüş',
    'bi-binoculars'       => 'Uzak Görüş',
    'bi-brightness-high'  => 'Mavi Işık / Parlama',
    'bi-palette'          => 'Renkli Lens',
    'bi-stars'            => 'Premium',
    'bi-gem'              => 'Lüks / Marka',
    'bi-bag-heart'        => 'Aksesuar',
    'bi-shield-check'     => 'Garanti',
    'bi-heart-pulse'      => 'Göz Sağlığı',
    'bi-tags'             => 'Genel',
];
$seciliIkon = old('icon', $category->icon);
// Listede olmayan mevcut bir ikon varsa kaybolmasın
if ($seciliIkon && ! isset($iconlar[$seciliIkon])) {
    $iconlar = [$seciliIkon => 'Mevcut (' . $seciliIkon . ')'] + $iconlar;
}
@endphp
<form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" class="form-a">
    @csrf
    @if($category->exists)@method('PUT')@endif
    <div class="row">
        <div class="col-lg-6">
            <div class="card-a">
                <label>Kategori Adı *</label>
                <input name="name" value="{{ old('name', $category->name) }}" required>

                <label>İkon</label>
                <div style="display:flex;align-items:center;gap:.6rem">
                    <span id="iconPrev" style="width:44px;height:44px;border:1px solid var(--aline);border-radius:10px;display:inline-flex;align-items:center;justify-content:center;font-size:1.4rem;color:var(--ap-text);background:#fdf6d6;flex-shrink:0">
                        <i class="bi {{ $seciliIkon ?: 'bi-eyeglasses' }}"></i>
                    </span>
                    <select name="icon" id="iconSel" style="flex:1">
                        @foreach($iconlar as $cls => $ad)
                            <option value="{{ $cls }}" @selected($seciliIkon === $cls)>{{ $ad }} — {{ $cls }}</option>
                        @endforeach
                    </select>
                </div>
                <small class="text-muted">Kategoriye uygun ikonu seçin; soldaki kutuda önizlenir.</small>

                <label>Sıra</label>
                <input type="number" name="sira" value="{{ old('sira', $category->sira ?? 0) }}">

                <label>Açıklama</label>
                <textarea name="description" rows="3">{{ old('description', $category->description) }}</textarea>

                <label class="mt-2"><input type="checkbox" name="durum" value="1" @checked(old('durum', $category->durum ?? true)) style="width:auto"> Aktif</label>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn-a"><i class="bi bi-check-lg"></i> Kaydet</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn-a sec">Vazgeç</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
(function () {
    var sel = document.getElementById('iconSel'),
        prev = document.getElementById('iconPrev');
    if (sel && prev) {
        sel.addEventListener('change', function () {
            prev.innerHTML = '<i class="bi ' + sel.value + '"></i>';
        });
    }
})();
</script>
@endsection
