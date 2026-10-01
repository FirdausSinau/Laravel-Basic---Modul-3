<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Services\ActivityService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ActivityController extends Controller
{
    /**
     * Menampilkan daftar seluruh kegiatan.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category_id', 'status', 'sort']);

        $activities = Activity::query()
            // Eager loading kategori agar view daftar tidak memicu N+1 query.
            // Tanpa ini: 1 query daftar + 1 query kategori per baris.
            ->with('category')
            ->filter($filters)
            ->paginate(10)
            ->withQueryString();

        $categories = $this->categories();

        return view('activities.index', compact('activities', 'categories', 'filters'));
    }

    /**
     * Menampilkan formulir tambah kegiatan.
     */
    public function create(): View
    {
        $categories = $this->categories();

        return view('activities.create', compact('categories'));
    }

    /**
     * Menyimpan kegiatan baru ke database melalui Service.
     */
    public function store(StoreActivityRequest $request, ActivityService $service): RedirectResponse
    {
        $service->create($request->validated());

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Menampilkan rincian satu kegiatan (Route Model Binding).
     */
    public function show(Activity $activity): View
    {
        return view('activities.show', compact('activity'));
    }

    /**
     * Menampilkan formulir ubah kegiatan.
     */
    public function edit(Activity $activity): View
    {
        $categories = $this->categories();

        return view('activities.edit', compact('activity', 'categories'));
    }

    /**
     * Memperbarui data kegiatan di database melalui Service.
     */
    public function update(
        UpdateActivityRequest $request,
        Activity $activity,
        ActivityService $service
    ): RedirectResponse {
        try {
            $service->update($activity, $request->validated());
        } catch (DomainException $e) {
            throw ValidationException::withMessages([
                'status' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Menghapus kegiatan dari database.
     */
    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * Helper method terpusat untuk mengambil daftar kategori.
     */
    private function categories()
    {
        return Category::orderBy('name')->get();
    }

    /**
     * Menampilkan kegiatan yang sudah di-soft delete (Task 3, AC-10).
     *
     * Query bawaan Eloquent menyembunyikan record soft delete, sehingga
     * untuk melihatnya harus diminta secara eksplisit lewat onlyTrashed().
     */
    public function trash(): View
    {
        $trashedActivities = Activity::onlyTrashed()
            ->with('category')
            ->orderByDesc('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('activities.trash', compact('trashedActivities'));
    }

    /**
     * Memulihkan kegiatan yang ter-soft delete (Task 3, AC-11).
     *
     * Record dicari lewat onlyTrashed() agar kegiatan yang masih aktif
     * otomatis ditolak oleh findOrFail().
     */
    public function restore(int $id): RedirectResponse
    {
        $activity = Activity::onlyTrashed()->findOrFail($id);

        $activity->restore();

        return redirect()
            ->route('activities.trash')
            ->with('success', 'Kegiatan "'.$activity->title.'" berhasil dipulihkan.');
    }

    public function publish(Activity $activity, ActivityService $service): RedirectResponse
    {
        try {
            $service->publish($activity);

            return back()->with('success', 'Kegiatan berhasil dipublikasikan.');
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function complete(Activity $activity, ActivityService $service): RedirectResponse
    {
        try {
            $service->complete($activity);

            return back()->with('success', 'Kegiatan berhasil diselesaikan.');
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
