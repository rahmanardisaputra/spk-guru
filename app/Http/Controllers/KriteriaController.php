<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        // Ambil semua kriteria beserta data sub kriterianya
        $kriterias = Kriteria::with('subKriterias')->get();
        return view('kriteria.index', compact('kriterias'));
    }
}