<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintJob extends Model
{
    use HasFactory;

    protected $table = 'print_jobs';

    protected $fillable = [
        'job_token',
        'file_name',
        'file_path',
        'total_pages',
        'copies',
        'print_mode',
        'status',
        'source'
    ];


    protected $casts = [
        'total_pages' => 'integer',
        'copies' => 'integer',
    ];

    /* =========================
       SCOPES (OPSIONAL TAPI RAPI)
    ========================== */

    public function scopeQueued($query)
    {
        return $query->where('status', 'queued');
    }

    public function scopePrinting($query)
    {
        return $query->where('status', 'printing');
    }
}
