<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::paginate(10);

        // Logika untuk tombol hapus
        $title = 'Hapus Berita!';
        $text = 'Yakin ingin menghapusnya?';
        confirmDelete($title, $text);

        return view('admin.pages.berita.index', compact('berita'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cover' => 'nullable|image|max:2048',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'class_berita' => 'required|in:-,harian,bulanan,tahunan',
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date',
            'user_id' => 'nullable|exists:users,id',
            'thumbnail' => 'nullable|image|max:2048',
            'docum_berita.*' => 'nullable|image|max:5120', // Maksimal 5MB per file
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('berita', 'public');
            $validatedData['cover'] = $path;
        }

        if ($request->hasFile('thumbnail')) {
            $thumbPath = $request->file('thumbnail')->store('berita/thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbPath;
        }

        if ($request->hasFile('docum_berita')) {
            $documBeritaPaths = [];
            foreach ($request->file('docum_berita') as $file) {
                $filePath = $file->store('berita/documents', 'public');
                $documBeritaPaths[] = $filePath;
            }
            $validatedData['docum_berita'] = json_encode($documBeritaPaths);
        }

        $validatedData['slug'] = Str::slug($validatedData['judul']);
        // $validatedData['user_id'] = Auth::user()->id;
        $validatedData['user_id'] = 1; // Temporary hardcoded user ID for testing

        Berita::create($validatedData);

        Alert::success('Sukses', 'Kegiatan berhasil ditambahkan.');
        return redirect()->route('admin.berita.index');
    }

    public function viewFile($filename)
    {
        $path = storage_path('app/public/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function viewFileThumbnail($filename)
    {
        $path = storage_path('app/public/thumbnails/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function update(Request $request, $slug)
    {
        $berita = Berita::where('slug', $slug)->first();

        if (!$berita) {
            return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan.');
        }

        $validatedData = $request->validate([
            'cover' => 'nullable|image|max:2048',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'class_berita' => 'required|in:harian,bulanan,tahunan',
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date',
            'thumbnail' => 'nullable|image|max:2048',
            'docum_berita.*' => 'nullable|image|max:5120', // Maksimal 5MB per file
        ]);

        if ($request->hasFile('cover')) {
            if ($berita->cover) {
                unlink(storage_path('app/public/' . $berita->cover));
            }

            $path = $request->file('cover')->store('berita', 'public');
            $validatedData['cover'] = $path;
        }

        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail) {
                unlink(storage_path('app/public/' . $berita->thumbnail));
            }

            $thumbPath = $request->file('thumbnail')->store('berita/thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbPath;
        }

        if ($request->hasFile('docum_berita')) {
            $documBeritaPaths = $berita->docum_berita ? json_decode($berita->docum_berita, true) : [];
            foreach ($request->file('docum_berita') as $file) {
                $filePath = $file->store('berita/documents', 'public');
                $documBeritaPaths[] = $filePath;
            }
            $validatedData['docum_berita'] = json_encode($documBeritaPaths);
        }

        $validatedData['slug'] = Str::slug($validatedData['judul']);

        $berita->update($validatedData);

        Alert::success('Sukses', 'Kegiatan berhasil diperbarui.');
        return redirect()->route('admin.berita.index');
    }

    // Menambahkan dokumentasi kegiatan ke dalam json data dokumentasi kegiatan
    public function addDocum(Request $request, $slug)
    {
        $berita = Berita::where('slug', $slug)->first();

        if (!$berita) {
            return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan.');
        }

        $validatedData = $request->validate([
            'docum_berita.*' => 'nullable|image|max:5120', // Maksimal 5MB per file
        ]);

        if ($request->hasFile('docum_berita')) {
            $documBeritaPaths = $berita->docum_berita ? json_decode($berita->docum_berita, true) : [];
            foreach ($request->file('docum_berita') as $file) {
                $filePath = $file->store('berita/documents', 'public');
                $documBeritaPaths[] = $filePath;
            }
            $berita->docum_berita = json_encode($documBeritaPaths);
            $berita->save();
        }

        Alert::success('Sukses', 'Dokumentasi kegiatan berhasil ditambahkan.');
        return redirect()->route('admin.berita.index');
    }

    public function destroy($slug)
    {
        $berita = Berita::where('slug', $slug)->first();

        if (!$berita) {
            return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan.');
        }

        if ($berita->cover) {
            unlink(storage_path('app/public/' . $berita->cover));
        }

        if ($berita->thumbnail) {
            unlink(storage_path('app/public/' . $berita->thumbnail));
        }

        if ($berita->docum_berita) {
            $documBeritaFiles = json_decode($berita->docum_berita, true);
            foreach ($documBeritaFiles as $file) {
                unlink(storage_path('app/public/' . $file));
            }
        }

        $berita->delete();

        Alert::success('Sukses', 'Kegiatan berhasil dihapus.');
        return redirect()->route('admin.berita.index');
    }

    public function toggleStatus($id)
    {
        $berita = Berita::findOrFail($id);

        $berita->is_active = !$berita->is_active;
        $berita->save();

        return response()->json([
            'success' => true,
            'is_active' => $berita->is_active,
            'text' => $berita->is_active
                ? 'Kegiatan diaktifkan'
                : 'Kegiatan dinonaktifkan'
        ]);
    }
}
