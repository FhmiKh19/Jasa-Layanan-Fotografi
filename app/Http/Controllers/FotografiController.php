<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FotografiController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show()
    {
        $judul = "Selamat Datang di Website Fotografi";
        $deskripsi = "Website ini berisi informasi tentang layanan fotografi, galeri, dan portofolio.";
        $layanan = ["Wedding Photography", "Product Photography", "Travel Photography", "Event Photography"];

        return view('home-fotografi', compact('judul', 'deskripsi', 'layanan'));
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
