<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // Halaman pesan fotografer (2 jenis foto)
    public function pesanFotografer()
    {
        $nama = Auth::user()->name;
        return view('pesan_fotografer', compact('nama'));
    }


    public function show()
    {
        $judul = "Selamat Datang di Website Fotografi";
        $deskripsi = "Website ini berisi informasi tentang layanan fotografi, galeri, dan portofolio.";
        
        $layanan = [
            [
                'nama' => 'Foto Wedding',
                'icon' => 'fa-heart',
                'deskripsi' => 'Mengabadikan momen pernikahan Anda dengan hasil yang memukau dan berkesan seumur hidup.'
            ],
            [
                'nama' => 'Foto Wisuda',
                'icon' => 'fa-graduation-cap',
                'deskripsi' => 'Dokumentasi momen kelulusan yang berharga dengan kualitas profesional dan elegan.'
            ],
            [
                'nama' => 'Foto Produk',
                'icon' => 'fa-box',
                'deskripsi' => 'Fotografi produk berkualitas tinggi untuk kebutuhan bisnis, e-commerce, dan promosi.'
            ],
            [
                'nama' => 'Foto Event',
                'icon' => 'fa-calendar',
                'deskripsi' => 'Mengabadikan setiap momen penting dalam acara Anda dengan detail dan profesional.'
            ]
        ];

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
