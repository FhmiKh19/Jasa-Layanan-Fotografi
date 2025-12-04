<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $pageData['username']   = 'Heroku';
        $pageData['last_login'] = date('Y-m-d H:i:s');
        $pageData['list_pendidikan'] = ['SD','SMP','SMA','S1','S2','S3'];
        // return view('simple-home', $pageData);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
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

    public function signup(Request $request)
    {
        $pageData['name']     = $request->name;
        $pageData['email']    = $request->email;
        $pageData['password'] = $request->password;
		$request->validate([
            'name'  => 'required|max:10',
		    'email' => ['required','email'],
		    'password' => [
                'required',           // Wajib diisi
                'min:8',              // Minimal 8 karakter
                'string',             // Harus berupa string
                'regex:/[A-Z]/',      // Harus mengandung setidaknya 1 huruf besar
                'regex:/[a-z]/',      // Harus mengandung setidaknya 1 huruf kecil
                'regex:/[0-9]/',      // Harus mengandung setidaknya 1 angka
            ],
        ]);
        // return view('signup-success', $pageData);
    }
}
