<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FotograferController extends Controller
{
    public function index() {
        $fotografer = DB::table('fotografer')->get();
        return view('fotografer.index', compact('fotografer'));
    }

    public function create() {
        return view('fotografer.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama_pengguna' => 'required',
            'username' => 'required',
            'no_hp' => 'required',
        ]);

        DB::table('fotografer')->insert([
            'nama_pengguna' => $request->nama_pengguna,
            'username' => $request->username,
            'no_hp' => $request->no_hp,
            'status_akun' => 'aktif',
            'created_at' => now(),
        ]);

        return redirect()->route('fotografer.index')->with('success', 'Data fotografer berhasil disimpan');
    }

    public function edit($id) {
        $fotografer = DB::table('fotografer')->where('id_pengguna', $id)->first();
        return view('fotografer.edit', compact('fotografer'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama_pengguna' => 'required',
            'username' => 'required',
            'no_hp' => 'required',
        ]);

        DB::table('fotografer')->where('id_pengguna', $id)->update([
            'nama_pengguna' => $request->nama_pengguna,
            'username' => $request->username,
            'no_hp' => $request->no_hp,
            'status_akun' => $request->status_akun,
            'updated_at' => now(),
        ]);

        return redirect()->route('fotografer.index')->with('success', 'Data fotografer berhasil diupdate');
    }

    public function destroy($id) {
        DB::table('fotografer')->where('id_pengguna', $id)->delete();
        return redirect()->route('fotografer.index')->with('success', 'Data fotografer berhasil dihapus');
    }
}
