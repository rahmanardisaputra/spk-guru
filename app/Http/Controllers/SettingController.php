<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $periode_penilaian = Setting::where('key', 'periode_penilaian')->value('value') ?? 'Ganjil - 2024/2025';
        return view('settings.index', compact('periode_penilaian'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'periode_penilaian' => 'required|string|max:255',
        ]);

        Setting::updateOrCreate(
            ['key' => 'periode_penilaian'],
            ['value' => $request->periode_penilaian]
        );

        return redirect()->back()->with('success', 'Pengaturan Periode Penilaian berhasil disimpan.');
    }
}
