{{-- Input Kode Kegiatan (Syarat Unik Task 1) --}}
<div style="margin-bottom: 1rem;">
    <label for="code" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Kode Kegiatan *</label>
    <input type="text" name="code" id="code" value="{{ old('code', $activity->code ?? '') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;" required>
    @error('code')
        <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
    @enderror
</div>

{{-- Dropdown Kategori (Syarat Relasi Task 1) --}}
<div style="margin-bottom: 1rem;">
    <label for="category_id" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Kategori *</label>
    <select name="category_id" id="category_id" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $activity->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 1rem;">
    <label for="title" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Judul Kegiatan (5–100 karakter) *</label>
    <input type="text" name="title" id="title" value="{{ old('title', $activity->title ?? '') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;" required>
    @error('title')
        <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 1rem;">
    <label for="activity_date" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Tanggal Pelaksanaan *</label>
    <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date', isset($activity->activity_date) ? (is_string($activity->activity_date) ? substr($activity->activity_date, 0, 10) : $activity->activity_date->format('Y-m-d')) : '') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;" required>
    @error('activity_date')
        <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 1.5rem;">
    <label for="description" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Deskripsi</label>
    <textarea name="description" id="description" rows="4" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description')
        <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
    @enderror
</div>

{{-- Lokasi Kegiatan --}}
<div style="margin-bottom: 1rem;">
    <label for="location" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Lokasi</label>
    <input type="text" name="location" id="location" value="{{ old('location', $activity->location ?? '') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">
    @error('location')
        <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
    @enderror
</div>

{{-- Kapasitas (1 - 500) --}}
<div style="margin-bottom: 1rem;">
    <label for="capacity" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Kapasitas Peserta (1 - 500)</label>
    <input type="number" name="capacity" id="capacity" min="1" max="500" value="{{ old('capacity', $activity->capacity ?? '') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">
    @error('capacity')
        <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
    @enderror
</div>

{{-- Waktu Mulai & Selesai --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
    <div>
        <label for="start_at" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Waktu Mulai</label>
        <input type="datetime-local" name="start_at" id="start_at" value="{{ old('start_at', isset($activity->start_at) ? (is_string($activity->start_at) ? date('Y-m-d\TH:i', strtotime($activity->start_at)) : $activity->start_at->format('Y-m-d\TH:i')) : '') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">
        @error('start_at')
            <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="end_at" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Waktu Selesai</label>
        <input type="datetime-local" name="end_at" id="end_at" value="{{ old('end_at', isset($activity->end_at) ? (is_string($activity->end_at) ? date('Y-m-d\TH:i', strtotime($activity->end_at)) : $activity->end_at->format('Y-m-d\TH:i')) : '') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">
        @error('end_at')
            <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
    </div>
</div>