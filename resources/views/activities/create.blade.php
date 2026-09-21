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

        <div style="margin-bottom: 1rem;">
            <label for="title" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Judul Kegiatan (5–100 karakter) *</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;" required>
            @error('title')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="activity_date" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Tanggal Pelaksanaan *</label>
            <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;" required>
            @error('activity_date')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="status" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Status *</label>
            <select name="status" id="status" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;" required>
                <option value="Planned" {{ old('status') === 'Planned' ? 'selected' : '' }}>Planned</option>
                <option value="Ongoing" {{ old('status') === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="Done" {{ old('status') === 'Done' ? 'selected' : '' }}>Done</option>
            </select>
            @error('status')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="category" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Kategori</label>
            <input type="text" name="category" id="category" value="{{ old('category') }}" placeholder="Contoh: Workshop, Review, Competition" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">
            @error('category')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="description" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Deskripsi</label>
            <textarea name="description" id="description" rows="4" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">{{ old('description') }}</textarea>
            @error('description')
                <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" style="background: #2563eb; color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">Simpan Kegiatan</button>
    </form>
@endsection