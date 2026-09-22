<div style="margin-bottom: 1rem;">
    <label for="title" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Judul Kegiatan (5–100 karakter) *</label>
    <input type="text" name="title" id="title" value="{{ old('title', $activity->title ?? '') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;" required>
    @error('title')
        <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 1rem;">
    <label for="activity_date" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Tanggal Pelaksanaan *</label>
    <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date', isset($activity->activity_date) ? $activity->activity_date->format('Y-m-d') : '') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;" required>
    @error('activity_date')
        <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 1rem;">
    <label for="status" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Status *</label>
    <select name="status" id="status" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;" required>
        <option value="Planned" {{ old('status', $activity->status ?? 'Planned') === 'Planned' ? 'selected' : '' }}>Planned</option>
        <option value="Ongoing" {{ old('status', $activity->status ?? '') === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
        <option value="Done" {{ old('status', $activity->status ?? '') === 'Done' ? 'selected' : '' }}>Done</option>
    </select>
    @error('status')
        <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
    @enderror
</div>

<div style="margin-bottom: 1rem;">
    <label for="category" style="display: block; font-weight: 600; margin-bottom: 0.25rem;">Kategori</label>
    <input type="text" name="category" id="category" value="{{ old('category', $activity->category ?? '') }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box;">
    @error('category')
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