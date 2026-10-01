<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Pengelolaan kategori (Task 1 - BR-08).
 *
 * Fokus utama modul ini adalah membuktikan delete policy: kategori yang masih
 * dipakai kegiatan tidak dapat dihapus, dan penolakan tersebut dibungkus
 * pesan yang bisa dipahami pengguna, bukan QueryException mentah.
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
     *
     * Penjagaan dilakukan di dua lapis:
     * 1. Pemeriksaan di aplikasi memberi umpan balik yang jelas ke pengguna.
     * 2. Foreign key dengan restrictOnDelete() tetap menjadi penjaga terakhir
     *    bila pemeriksaan aplikasi terlewati (misalnya jalur request paralel).
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
