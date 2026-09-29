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
    <form method="GET" action="{{ route('activities.index') }}" style="margin-bottom: 1.5rem; background: #f9fafb; padding: 1rem; border-radius: 8px; border: 1px solid #e5e7eb; display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center;">
        
        <!-- Search code / title -->
        <input type="text" name="search" placeholder="Cari kode atau judul..." value="{{ $filters['search'] ?? '' }}" style="padding: 0.45rem 0.75rem; border-radius: 4px; border: 1px solid #d1d5db; font-size: 0.875rem; min-width: 180px;">

        <!-- Filter Kategori -->
        <select name="category_id" style="padding: 0.45rem 0.75rem; border-radius: 4px; border: 1px solid #d1d5db; font-size: 0.875rem;">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <!-- Filter Status -->
        <select name="status" style="padding: 0.45rem 0.75rem; border-radius: 4px; border: 1px solid #d1d5db; font-size: 0.875rem;">
            <option value="">Semua Status</option>
            <option value="Draft" {{ ($filters['status'] ?? '') === 'Draft' ? 'selected' : '' }}>Draft</option>
            <option value="Published" {{ ($filters['status'] ?? '') === 'Published' ? 'selected' : '' }}>Published</option>
            <option value="Completed" {{ ($filters['status'] ?? '') === 'Completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <!-- Sort Tanggal -->
        <select name="sort" style="padding: 0.45rem 0.75rem; border-radius: 4px; border: 1px solid #d1d5db; font-size: 0.875rem;">
            <option value="latest" {{ ($filters['sort'] ?? '') === 'latest' ? 'selected' : '' }}>Terbaru</option>
            <option value="oldest" {{ ($filters['sort'] ?? '') === 'oldest' ? 'selected' : '' }}>Terlama</option>
        </select>

        <button type="submit" style="background: #2563eb; color: white; padding: 0.45rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.875rem; font-weight: 600;">
            Terapkan
        </button>

        @if(!empty(array_filter($filters)))
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
                    @if($activity->code)
                        <span style="font-family: monospace; font-weight: 600; color: #1e293b;">[{{ $activity->code }}]</span> | 
                    @endif
                    {{ $activity->activity_date->format('d M Y') }}
                    @if($activity->category)
                        | <span style="background: #f3f4f6; padding: 0.2rem 0.5rem; border-radius: 4px; font-weight: 500;">
                            {{ $activity->category->name }}
                          </span>
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
    {{-- Pagination Links --}}
    <div style="margin-top: 1.5rem;">
        <style>
            nav[role="navigation"] svg {
                width: 1.25rem !important;
                height: 1.25rem !important;
                display: inline-block;
                vertical-align: middle;
            }
            nav[role="navigation"] > div:first-child {
                display: none; /* Sembunyikan duplikasi teks navigasi bawaan mobile */
            }
            nav[role="navigation"] > div:last-child {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 1rem;
            }
        </style>

        {{ $activities->links() }}
    </div>
@endsection