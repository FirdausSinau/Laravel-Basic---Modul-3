@extends('layouts.app')

@section('content')
<p><a href="{{ route('activities.index') }}">&larr; Kembali ke Daftar</a></p>

<article class="card">
    <h2>{{ $activity->title }}</h2>
    <p><strong>Kategori:</strong> {{ $activity->category }}</p>
    <p><strong>Tanggal:</strong> {{ $activity->activity_date->format('d M Y') }}</p>
    <p><strong>Status:</strong> {{ $activity->status }}</p>
    <hr>
    <p>{{ $activity->description ?? 'Tidak ada deskripsi.' }}</p>
</article>
@endsection