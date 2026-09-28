<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $gurus = Guru::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nama_guru', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'required|string|unique:gurus,nip|max:20',
            'jenis_kelamin' => 'required|string|max:100',
            'mata_pelajaran' => 'required|string|max:50',
            'email' => 'nullable|email|unique:gurus,email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')
                ->store('foto-guru', 'public');
        }

        Guru::create($data);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $data = $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:gurus,nip,' . $guru->id,
            'jenis_kelamin' => 'required|string|max:100',
            'mata_pelajaran' => 'required|string|max:50',
            'email' => 'nullable|email|unique:gurus,email,' . $guru->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }

            // Simpan foto baru
            $data['foto'] = $request->file('foto')
                ->store('foto-guru', 'public');
        }

        $guru->update($data);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }

    public function destroy(Guru $guru)
    {
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    public function cetakPdf()
    {
        $gurus = Guru::all();

        $pdf = Pdf::loadView('guru.pdf', compact('gurus'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-data-guru.pdf');
    }
}