@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="margin: 0;">Daftar Kegiatan</h2>
        <a href="{{ route('activities.create') }}" style="background: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-weight: 600;">+ Tambah Kegiatan</a>
    </div>

    @if (session('success'))
        <div style="background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; gap: 1rem;">
        @forelse ($activities as $activity)
            <article style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.25rem;">
                <h3 style="margin: 0 0 0.5rem 0;">
                    <a href="{{ route('activities.show', $activity) }}" style="color: #1d4ed8; text-decoration: none;">
                        {{ $activity->title }}
                    </a>
                </h3>
                <p style="margin: 0 0 0.5rem 0; color: #6b7280; font-size: 0.875rem;">
                    {{ is_string($activity->activity_date) ? $activity->activity_date : $activity->activity_date->format('d M Y') }}
                    @if($activity->category)
                        | <span style="background: #f3f4f6; padding: 0.2rem 0.5rem; border-radius: 4px; font-weight: 500;">{{ $activity->category }}</span>
                    @endif
                </p>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.875rem; font-weight: 600;">Status: {{ $activity->status }}</span>
                    <a href="{{ route('activities.show', $activity) }}" style="font-size: 0.875rem; color: #4b5563; text-decoration: underline;">Lihat Detail &rarr;</a>
                </div>
            </article>
        @empty
            <p style="color: #6b7280;">Belum ada kegiatan yang tersimpan.</p>
        @endforelse
    </div>
@endsection