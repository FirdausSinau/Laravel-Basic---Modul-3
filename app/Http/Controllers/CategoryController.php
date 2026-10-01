<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Pengelolaan kategori.
 */
class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori beserta jumlah kegiatan yang memakainya.
     */
    public function index(): View
    {
        $categories = Category::withCount('activities')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Menghapus kategori yang tidak lagi dipakai kegiatan.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $usedBy = $category->activities()->count();

        if ($usedBy > 0) {
            return back()->with(
                'error',
                "Kategori \"{$category->name}\" masih digunakan oleh {$usedBy} kegiatan dan tidak dapat dihapus."
            );
        }

        try {
            $category->delete();
        } catch (QueryException) {
            // Penjaga terakhir bila pemeriksaan di atas terlewati.
            return back()->with(
                'error',
                "Kategori \"{$category->name}\" masih digunakan oleh kegiatan dan tidak dapat dihapus."
            );
        }

        return redirect()
            ->route('categories.index')
            ->with('success', "Kategori \"{$category->name}\" berhasil dihapus.");
    }
}
