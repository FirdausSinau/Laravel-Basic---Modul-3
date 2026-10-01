@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="margin: 0;">Kategori Kegiatan</h2>
        <a href="{{ route('activities.index') }}" style="text-decoration: none; color: #4b5563; font-weight: 500;">&larr; Kembali ke Daftar Kegiatan</a>
    </div>

    @if (session('success'))
        <div style="background: #dcfce7; border-left: 4px solid #16a34a; color: #15803d; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px;">
            {{ session('error') }}
        </div>
    @endif

    <p style="background: #f0f9ff; border-left: 4px solid #0ea5e9; color: #075985; padding: 0.85rem 1rem; margin: 0 0 1.5rem 0; border-radius: 4px; font-size: 0.875rem;">
        Sesuai BR-08, kategori yang masih dipakai kegiatan tidak dapat dihapus. Aturan ini dijaga dua lapis:
        pemeriksaan di aplikasi dan foreign key <code>restrictOnDelete()</code> di database.
    </p>

    <div style="display: grid; gap: 1rem;">
        @forelse ($categories as $category)
            <article style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0 0 0.25rem 0; font-size: 1rem;">{{ $category->name }}</h3>
                    <p style="margin: 0; color: #6b7280; font-size: 0.85rem;">
                        <code>{{ $category->slug }}</code> &middot;
                        {{ $category->activities_count }} kegiatan
                    </p>
                </div>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #ef4444; color: white; padding: 0.45rem 0.9rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.875rem; font-weight: 600;">
                        Hapus
                    </button>
                </form>
            </article>
        @empty
            <p style="color: #6b7280;">Belum ada kategori.</p>
        @endforelse
    </div>
@endsection
