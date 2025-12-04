<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // =======================
    // TAMPIL FORM + DATA EDIT
    // =======================
    public function create()
    {
        $booking = Booking::first(); // ambil data pertama (jika ada)
        return view('booking.create', compact('booking'));
    }

    // =======================
    // SIMPAN DATA BOOKING
    // =======================
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required',
            'jam_booking' => 'required',
            'bukti_transfer' => 'required|image|max:2048'
        ]);

        // Upload file
        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

        Booking::create([
            'nama_pemesan' => $request->nama_pemesan,
            'jam_booking' => $request->jam_booking,
            'bukti_transfer' => $path
        ]);

        return redirect()->route('pesan.fotografer')->with('success', 'Booking berhasil disimpan!');
    }

    // =======================
    // TAMPIL FORM EDIT
    // =======================
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('booking.edit', compact('booking'));
    }

    // =======================
    // UPDATE BOOKING
    // =======================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pemesan' => 'required',
            'jam_booking' => 'required',
            'bukti_transfer' => 'nullable|image|max:2048'
        ]);

        $booking = Booking::findOrFail($id);

        // Jika upload baru
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $booking->bukti_transfer = $path;
        }

        $booking->nama_pemesan = $request->nama_pemesan;
        $booking->jam_booking = $request->jam_booking;
        $booking->save();

        return redirect()->route('pesan.fotografer')->with('success', 'Booking berhasil diperbarui!');
    }

    // =======================
    // DELETE BOOKING
    // =======================
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('pesan.fotografer')->with('success', 'Booking berhasil dihapus!');
    }
}
