<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
 
    protected $table = 'educations';

    protected $fillable = [
        'resume_id',
        'degree',
        'school', 
        'edu_start',
        'edu_end',
        'edu_description',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}