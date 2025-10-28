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
        'start_date',  
        'end_date',    
        'description', 
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}