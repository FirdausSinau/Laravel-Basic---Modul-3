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

    @if (session('error'))
        <div style="background: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px;">
            {{ session('error') }}
        </div>
    @endif

    <article style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; max-width: 700px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <h2 style="margin: 0;">{{ $activity->title }}</h2>
            <span style="background: #e0f2fe; color: #0369a1; padding: 0.3rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                {{ $activity->status }}
            </span>
        </div>

        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1rem;">
            @if ($activity->code)
                Kode: <strong>{{ $activity->code }}</strong> |
            @endif
            Tanggal: {{ $activity->activity_date ? (is_string($activity->activity_date) ? substr($activity->activity_date, 0, 10) : $activity->activity_date->format('d M Y')) : '-' }}
            @if ($activity->category)
                | Kategori: <strong>{{ $activity->category->name }}</strong>
            @endif
        </p>

        {{-- Detail Informasi Task 2 (Lokasi, Kapasitas, & Jadwal Waktu) --}}
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 0.85rem 1rem; margin-bottom: 1.5rem; font-size: 0.875rem; color: #334155; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.5rem;">
            <div><strong>Lokasi:</strong> {{ $activity->location ?: '-' }}</div>
            <div><strong>Kapasitas:</strong> {{ $activity->capacity ? $activity->capacity . ' orang' : '-' }}</div>
            <div><strong>Mulai:</strong> {{ $activity->start_at ? (is_string($activity->start_at) ? $activity->start_at : $activity->start_at->format('d M Y H:i')) : '-' }}</div>
            <div><strong>Selesai:</strong> {{ $activity->end_at ? (is_string($activity->end_at) ? $activity->end_at : $activity->end_at->format('d M Y H:i')) : '-' }}</div>
        </div>

        <div style="border-top: 1px solid #f3f4f6; padding-top: 1rem; margin-bottom: 2rem;">
            <h4 style="margin: 0 0 0.5rem 0; color: #374151;">Deskripsi:</h4>
            <p style="margin: 0; line-height: 1.6; color: #4b5563; white-space: pre-line;">
                {{ $activity->description ?: 'Tidak ada deskripsi.' }}
            </p>
        </div>

        {{-- Form Pendaftaran Peserta (Independent Challenge) --}}
        <div style="border-top: 1px solid #f3f4f6; padding-top: 1.25rem; margin-bottom: 1.5rem;">
            <h4 style="margin: 0 0 0.5rem 0; color: #374151;">Pendaftaran Peserta</h4>
            <p style="margin: 0 0 0.75rem 0; color: #6b7280; font-size: 0.85rem;">
                Terdaftar: <strong>{{ $registeredCount }}</strong>
                dari kapasitas <strong>{{ $activity->capacity }}</strong> orang.
            </p>

            <form action="{{ route('registrations.store', $activity) }}" method="POST" style="display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: flex-start;">
                @csrf
                <div>
                    <label for="participant_name" style="display: block; font-size: 0.8rem; color: #4b5563; margin-bottom: 0.2rem;">Nama Peserta</label>
                    <input type="text" name="participant_name" id="participant_name" value="{{ old('participant_name') }}"
                           style="padding: 0.45rem 0.75rem; border-radius: 4px; border: 1px solid #d1d5db; font-size: 0.875rem;">
                    @error('participant_name')
                        <div style="color: #b91c1c; font-size: 0.8rem; margin-top: 0.2rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="email" style="display: block; font-size: 0.8rem; color: #4b5563; margin-bottom: 0.2rem;">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           style="padding: 0.45rem 0.75rem; border-radius: 4px; border: 1px solid #d1d5db; font-size: 0.875rem;">
                    @error('email')
                        <div style="color: #b91c1c; font-size: 0.8rem; margin-top: 0.2rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="padding-top: 1.25rem;">
                    <button type="submit" style="background: #7c3aed; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                        Daftar
                    </button>
                </div>
            </form>
        </div>

        {{-- Tombol Aksi & Transisi Status --}}
        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; border-top: 1px solid #f3f4f6; padding-top: 1.25rem;">
            @if ($activity->status === 'Draft')
                <form action="{{ route('activities.publish', $activity) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" style="background: #16a34a; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                        Publikasikan Kegiatan
                    </button>
                </form>
            @elseif ($activity->status === 'Published')
                <form action="{{ route('activities.complete', $activity) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" style="background: #2563eb; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                        Selesaikan Kegiatan
                    </button>
                </form>
            @endif

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
