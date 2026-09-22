@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('activities.index') }}" style="text-decoration: none; color: #4b5563;">&larr; Kembali ke Daftar</a>
    </div>

    @if (session('success'))
        <div style="background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <article style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; max-width: 700px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <h2 style="margin: 0;">{{ $activity->title }}</h2>
            <span style="background: #e0f2fe; color: #0369a1; padding: 0.3rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                {{ $activity->status }}
            </span>
        </div>

        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1.5rem;">
            Tanggal: {{ $activity->activity_date->format('d M Y') }}
            @if ($activity->category)
                | Kategori: <strong>{{ $activity->category }}</strong>
            @endif
        </p>

        <div style="border-top: 1px solid #f3f4f6; padding-top: 1rem; margin-bottom: 2rem;">
            <h4 style="margin: 0 0 0.5rem 0; color: #374151;">Deskripsi:</h4>
            <p style="margin: 0; line-height: 1.6; color: #4b5563; white-space: pre-line;">
                {{ $activity->description ?: 'Tidak ada deskripsi.' }}
            </p>
        </div>

        <div style="display: flex; gap: 0.75rem; border-top: 1px solid #f3f4f6; padding-top: 1.25rem;">
            <a href="{{ route('activities.edit', $activity) }}" style="background: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-weight: 600;">
                Ubah Kegiatan
            </a>

            <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                    Hapus
                </button>
            </form>
        </div>
    </article>
@endsection