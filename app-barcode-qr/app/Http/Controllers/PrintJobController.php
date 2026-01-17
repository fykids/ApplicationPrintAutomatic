<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrintJob;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;

class PrintJobController extends Controller
{
    public function create()
    {
        return view('upload');
    }

    // ===============================
    // UPLOAD DARI USER (FORM)
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240',
            'copies' => 'required|integer|min:1|max:100',
            'print_mode' => 'required|in:bw,color'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        $path = $file->storeAs('print_jobs', $filename, 'public');
        $fullPath = storage_path('app/public/' . $path);

        // 🔥 HITUNG JUMLAH HALAMAN PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($fullPath);
        $totalPages = count($pdf->getPages());

        try {
            $job = PrintJob::create([
                'job_token' => Str::uuid(),
                'file_name' => $filename,
                'file_path' => $fullPath,
                'total_pages' => $totalPages,
                'copies' => $request->copies,
                'print_mode' => $request->print_mode,
                'status' => 'queued',
                'source' => 'qr'
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back()->withErrors('Gagal menyimpan data print');
        }


        return redirect('/')
            ->with('success', "File berhasil diupload ($totalPages halaman)");
    }


    // ===============================
    // DIPANGGIL PYTHON
    // ===============================
    public function next()
    {
        $job = PrintJob::where('status', 'queued')
            ->orderBy('created_at')
            ->first();

        if (!$job) {
            return response()->noContent();
        }

        return response()->json($job);
    }

    public function markPrinting($token)
    {
        PrintJob::where('job_token', $token)
            ->update(['status' => 'printing']);

        return response()->json(['ok' => true]);
    }

    public function markDone($token)
    {
        PrintJob::where('job_token', $token)
            ->update(['status' => 'done']);

        return response()->json(['ok' => true]);
    }

    public function failed($token)
    {
        PrintJob::where('job_token', $token)
            ->update(['status' => 'failed']);

        return response()->json(['status' => 'failed']);
    }

}
