<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'job_title',
        'company',
        'job_start',
        'job_end',
        'job_description',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
