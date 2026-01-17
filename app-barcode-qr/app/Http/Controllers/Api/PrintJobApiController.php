<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrintJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrintJobApiController extends Controller
{
    /**
     * Ambil 1 job antrian
     */
    public function next()
    {
        $job = PrintJob::queued()
            ->orderBy('created_at')
            ->first();

        if (!$job) {
            return response()->json([
                'message' => 'No print job available'
            ], 204);
        }

        return response()->json([
            'job_token' => $job->job_token,
            'file_path' => storage_path(path: 'app/' . $job->file_path),
            'copies' => $job->copies,
            'print_mode' => $job->print_mode,
        ]);
    }

    /**
     * Update status ke printing
     */
    public function markPrinting($token)
    {
        PrintJob::where('job_token', $token)
            ->update(['status' => 'printing']);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Update status ke done
     */
    public function markDone($token)
    {
        $job = PrintJob::where('job_token', $token)->firstOrFail();

        Storage::delete($job->file_path);
        $job->update(['status' => 'done']);

        return response()->json(['status' => 'ok']);
    }

    public function markFailed($token)
    {
        PrintJob::where('job_token', $token)
            ->update(['status' => 'failed']);

        return response()->json(['status' => 'failed']);
    }

}
