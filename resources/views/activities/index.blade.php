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

    {{-- Form Filter Status via Query String --}}
    <form method="GET" action="{{ route('activities.index') }}" style="margin-bottom: 1.5rem; display: flex; gap: 0.75rem; align-items: center; background: #f9fafb; padding: 0.75rem 1rem; border-radius: 6px; border: 1px solid #e5e7eb;">
        <label for="status-filter" style="font-weight: 600; font-size: 0.875rem; color: #374151;">Filter Status:</label>
        <select name="status" id="status-filter" onchange="this.form.submit()" style="padding: 0.4rem 0.75rem; border-radius: 4px; border: 1px solid #d1d5db; font-size: 0.875rem;">
            <option value="" {{ empty($status) ? 'selected' : '' }}>Semua</option>
            <option value="Planned" {{ $status === 'Planned' ? 'selected' : '' }}>Planned</option>
            <option value="Ongoing" {{ $status === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
            <option value="Done" {{ $status === 'Done' ? 'selected' : '' }}>Done</option>
        </select>
        @if(!empty($status))
            <a href="{{ route('activities.index') }}" style="color: #ef4444; font-size: 0.875rem; text-decoration: none; font-weight: 500;">&times; Reset Filter</a>
        @endif
    </form>

    <div style="display: grid; gap: 1rem;">
        @forelse ($activities as $activity)
            <article style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.25rem;">
                <h3 style="margin: 0 0 0.5rem 0;">
                    <a href="{{ route('activities.show', $activity) }}" style="color: #1d4ed8; text-decoration: none;">
                        {{ $activity->title }}
                    </a>
                </h3>
                <p style="margin: 0 0 0.5rem 0; color: #6b7280; font-size: 0.875rem;">
                    {{ $activity->activity_date->format('d M Y') }}
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
            <p style="color: #6b7280;">Belum ada kegiatan yang cocok dengan kriteria filter.</p>
        @endforelse
    </div>
@endsection