@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('activities.index') }}" style="text-decoration: none; color: #4b5563;">&larr; Kembali ke Daftar</a>
        <h2 style="margin-top: 0.5rem;">Tambah Kegiatan Baru</h2>
    </div>

    @if ($errors->any())
        <div style="background-color: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px;">
            <p style="font-weight: bold; margin: 0 0 0.5rem 0;">Periksa kembali inputan Anda:</p>
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('activities.store') }}" method="POST" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #e5e7eb; max-width: 600px;">
        @csrf

        @include('activities._form')

        <button type="submit" style="background: #2563eb; color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">Simpan Kegiatan</button>
    </form>
@endsection