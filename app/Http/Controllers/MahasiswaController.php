<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Exports\MahasiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class MahasiswaController extends Controller
{
    /**
     * 🧾 Tampilkan daftar mahasiswa + pencarian + pagination
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $mahasiswa = Mahasiswa::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('nama', 'asc')
            ->paginate(5);

        return view('mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * ➕ Form tambah mahasiswa
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * 💾 Simpan data mahasiswa baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',
            'email' => 'required|email|unique:mahasiswas,email',
        ]);

        Mahasiswa::create($request->all());

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    /**
     * ✏️ Form edit mahasiswa
     */
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * 🔄 Update data mahasiswa
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $id,
            'email' => 'required|email|unique:mahasiswas,email,' . $id,
        ]);

        $mahasiswa->update($request->all());

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * 🗑️ Hapus data mahasiswa
     */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    /**
     * 📊 Export ke Excel
     */
    public function exportExcel(Request $request)
    {
        $keyword = $request->input('search');
        $export = new MahasiswaExport($keyword);

        // ✅ Tambahkan tanggal otomatis di nama file
        $fileName = 'Laporan Data Mahasiswa (' . date('d-m-Y') . ').xlsx';

        return Excel::download(new MahasiswaExport, MahasiswaExport::fileName());
    }

    /**
     * 🧾 Cetak ke PDF
     */
    public function cetakPdf()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();

        // ✅ Pastikan view-nya sesuai: resources/views/mahasiswa/cetakpdf.blade.php
        $pdf = Pdf::loadView('mahasiswa.cetakpdf', compact('mahasiswa'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan Data Mahasiswa.pdf');
    }
}
