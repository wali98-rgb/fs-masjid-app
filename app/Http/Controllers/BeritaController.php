<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::paginate(10);

        return view('admin.pages.berita.index', compact('berita'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cover' => 'nullable|image|max:2048',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('berita', 'public');
            $validatedData['cover'] = $path;
        }

        $validatedData['slug'] = Str::slug($validatedData['judul']);

        Berita::create($validatedData);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function viewFile($filename)
    {
        $path = storage_path('app/public/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
