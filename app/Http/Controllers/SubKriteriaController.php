<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    // Menampilkan halaman Sub Kriteria berdasarkan Kriteria yang dipilih
    public function index($kriteria_id)
    {
        $kriteria = Kriteria::with('subKriterias')->findOrFail($kriteria_id);
        return view('subkriteria.index', compact('kriteria'));
    }

    // Menyimpan Sub Kriteria baru
    public function store(Request $request, $kriteria_id)
    {
        $request->validate([
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai_ideal' => 'required|integer|min:1|max:5', // Biasanya profil ideal 1-5
            'jenis_faktor' => 'required|in:core,secondary', // CF atau SF
        ]);

        SubKriteria::create([
            'kriteria_id' => $kriteria_id,
            'nama_sub_kriteria' => $request->nama_sub_kriteria,
            'nilai_ideal' => $request->nilai_ideal,
            'jenis_faktor' => $request->jenis_faktor,
        ]);

        return redirect()->back()->with('success', 'Sub Kriteria berhasil ditambahkan!');
    }

    // Menampilkan halaman edit sub kriteria
    public function edit($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        return view('subkriteria.edit', compact('subKriteria'));
    }

    // Memproses perubahan sub kriteria
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai_ideal' => 'required|integer|min:1|max:5',
            'jenis_faktor' => 'required|in:core,secondary',
        ]);

        $subKriteria = SubKriteria::findOrFail($id);
        $subKriteria->update($request->all());

        // Setelah sukses, kembalikan ke halaman kelola sub kriteria sesuai kriteria_id nya
        return redirect()->route('subkriteria.index', $subKriteria->kriteria_id)
                         ->with('success', 'Sub Kriteria berhasil diperbarui!');
    }

    // Menghapus Sub Kriteria
    public function destroy($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $subKriteria->delete();

        return redirect()->back()->with('success', 'Sub Kriteria berhasil dihapus!');
    }
}