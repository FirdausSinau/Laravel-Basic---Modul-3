@extends('layouts.app')

@section('content')
<h2>Daftar Kegiatan</h2>

@forelse ($activities as $activity)
    <article class="card">
        <h3>
            <a href="{{ route('activities.show', $activity) }}">
                {{ $activity->title }}
            </a>
        </h3>
        <p>{{ $activity->activity_date->format('d M Y') }} | <span class="badge">{{ $activity->category }}</span></p>
        <p>Status: <strong>{{ $activity->status }}</strong></p>
    </article>
@empty
    <p>Belum ada kegiatan.</p>
@endforelse
@endsection