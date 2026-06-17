@extends('admin.layout')
@section('title', 'Randevular')

@section('content')
<table class="table-a">
    <thead><tr><th>Ad Soyad</th><th>Telefon</th><th>Tarih/Saat</th><th>Not</th><th>Durum</th><th></th></tr></thead>
    <tbody>
    @forelse($appointments as $a)
        <tr>
            <td><strong>{{ $a->name }}</strong>@if($a->email)<br><small class="text-muted">{{ $a->email }}</small>@endif</td>
            <td>{{ $a->phone }}</td>
            <td>{{ optional($a->date)->format('d.m.Y') }} {{ $a->time }}</td>
            <td><small>{{ \Illuminate\Support\Str::limit($a->note, 50) }}</small></td>
            <td>
                <form action="{{ route('admin.appointments.update', $a) }}" method="POST" class="d-flex gap-1">
                    @csrf @method('PATCH')
                    <select name="status" onchange="this.form.submit()" style="padding:.3rem .5rem;border:1px solid var(--aline);border-radius:7px;font-size:.82rem">
                        @foreach(['yeni'=>'Yeni','arandi'=>'Arandı','tamamlandi'=>'Tamamlandı','iptal'=>'İptal'] as $k=>$v)
                            <option value="{{ $k }}" @selected($a->status==$k)>{{ $v }}</option>
                        @endforeach
                    </select>
                </form>
            </td>
            <td><small class="text-muted">{{ $a->created_at->format('d.m.Y') }}</small></td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center text-muted py-4">Randevu talebi yok.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="mt-3">{{ $appointments->links() }}</div>
@endsection
