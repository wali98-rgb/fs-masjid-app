<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index()
    {
        $articles = Article::paginate(10);

        // Logika untuk tombol hapus
        $title = 'Hapus Artikel!';
        $text = 'Yakin ingin menghapusnya?';
        confirmDelete($title, $text);

        return view('admin.pages.artikel.index', compact('articles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cover' => 'nullable|image|max:2048',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('articles', 'public');
            $validatedData['cover'] = $path;
        }

        $validatedData['slug'] = Str::slug($validatedData['judul']);

        Article::create($validatedData);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function viewFile($filename)
    {
        $path = storage_path('app/public/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function update(Request $request, $slug)
    {
        $article = Article::where('slug', $slug)->first();

        if (!$article) {
            return redirect()->route('admin.artikel.index')->with('error', 'Artikel tidak ditemukan.');
        }

        $validatedData = $request->validate([
            'cover' => 'nullable|image|max:2048',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        if ($request->hasFile('cover')) {
            unlink(storage_path('app/public/' . $article->cover));

            $path = $request->file('cover')->store('articles', 'public');
            $validatedData['cover'] = $path;
        }

        $validatedData['slug'] = Str::slug($validatedData['judul']);

        $article->update($validatedData);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($slug)
    {
        $article = Article::where('slug', $slug)->first();

        if (!$article) {
            return redirect()->route('admin.artikel.index')->with('error', 'Artikel tidak ditemukan.');
        }

        if ($article->cover) {
            unlink(storage_path('app/public/' . $article->cover));
        }

        $article->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
