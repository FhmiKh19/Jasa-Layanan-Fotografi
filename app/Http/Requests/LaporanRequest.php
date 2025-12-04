<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check(); // atau cek role fotografer jika perlu
    }

    public function rules()
    {
        return [
            'tanggal' => 'required|date',
            'judul' => 'nullable|string|max:191',
            'ringkasan' => 'required|string',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // max 5MB
        ];
    }
}
