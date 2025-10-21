<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'language',
        'language_level',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}