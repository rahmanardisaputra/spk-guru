<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $periode_penilaian = Setting::where('key', 'periode_penilaian')->value('value') ?? 'Ganjil - 2024/2025';
        $nama_kepsek = Setting::where('key', 'nama_kepsek')->value('value') ?? 'Nama Kepala Sekolah';
        $nip_kepsek = Setting::where('key', 'nip_kepsek')->value('value') ?? 'NIP Kepala Sekolah';
        $no_surat = Setting::where('key', 'no_surat')->value('value') ?? date('Y') . '/SPK-GURU/';

        return view('settings.index', compact('periode_penilaian', 'nama_kepsek', 'nip_kepsek', 'no_surat'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'periode_penilaian' => 'required|string|max:255',
            'nama_kepsek' => 'required|string|max:255',
            'nip_kepsek' => 'required|string|max:255',
            'no_surat' => 'required|string|max:255',
        ]);

        Setting::updateOrCreate(['key' => 'periode_penilaian'], ['value' => $request->periode_penilaian]);
        Setting::updateOrCreate(['key' => 'nama_kepsek'], ['value' => $request->nama_kepsek]);
        Setting::updateOrCreate(['key' => 'nip_kepsek'], ['value' => $request->nip_kepsek]);
        Setting::updateOrCreate(['key' => 'no_surat'], ['value' => $request->no_surat]);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
