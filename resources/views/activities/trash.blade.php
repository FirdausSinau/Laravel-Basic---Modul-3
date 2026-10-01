@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="margin: 0;">Data Kegiatan Terhapus</h2>
        <a href="{{ route('activities.index') }}" style="text-decoration: none; color: #4b5563; font-weight: 500;">&larr; Kembali ke Daftar</a>
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
        Kegiatan di halaman ini hanya dihapus secara logis (soft delete). Record masih tersimpan di database
        dan dapat dipulihkan melalui tombol <strong>Pulihkan</strong>.
    </p>

    <div style="display: grid; gap: 1rem;">
        @forelse ($trashedActivities as $activity)
            <article style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.25rem;">
                <h3 style="margin: 0 0 0.5rem 0; color: #9ca3af;">
                    {{ $activity->title }}
                </h3>
                <p style="margin: 0 0 0.75rem 0; color: #6b7280; font-size: 0.875rem;">
                    @if ($activity->code)
                        <span style="font-family: monospace; font-weight: 600; color: #1e293b;">[{{ $activity->code }}]</span> |
                    @endif
                    {{ $activity->activity_date->format('d M Y') }}
                    @if ($activity->category)
                        | <span style="background: #f3f4f6; padding: 0.2rem 0.5rem; border-radius: 4px; font-weight: 500;">
                            {{ $activity->category->name }}
                          </span>
                    @endif
                    | Status: <strong>{{ $activity->status }}</strong>
                </p>
                <p style="margin: 0 0 0.75rem 0; color: #991b1b; font-size: 0.8rem;">
                    Dihapus pada: {{ $activity->deleted_at->format('d M Y H:i') }}
                </p>
                <form action="{{ route('activities.restore', $activity->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" style="background: #16a34a; color: white; padding: 0.45rem 0.9rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.875rem; font-weight: 600;">
                        Pulihkan
                    </button>
                </form>
            </article>
        @empty
            <p style="color: #6b7280;">Belum ada kegiatan yang dihapus.</p>
        @endforelse
    </div>

    <div style="margin-top: 1.5rem;">
        <style>
            nav[role="navigation"] svg {
                width: 1.25rem !important;
                height: 1.25rem !important;
            }
            nav[role="navigation"] > div:first-child {
                display: none;
            }
            nav[role="navigation"] > div:last-child {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 1rem;
            }
        </style>

        {{ $trashedActivities->links() }}
    </div>
@endsection
