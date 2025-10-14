<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'occupation',
        'country',
        'nationality',
        'dob',
        'gender',
        'summary',
        'hobbies',
        'interests',
        'template',
    ];

    // Relationships
    public function employmentHistories()
    {
        return $this->hasMany(EmploymentHistory::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function languages()
    {
        return $this->hasMany(Language::class);
    }
}
