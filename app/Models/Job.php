<?php

namespace App\Models;

use App\Enums\JobTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes; 

    public $incrementing = false;

    protected  $fillable = [
        'job_code',
        'title',
        'location',
        'job_type',
        'salary',
        'application_deadline',
        'description',
        'requirements',
        'accepting_applications'
    ];

    protected $attributes = [
        'accepting_applications' => true,
    ];

    protected $casts = [
        'job_type' => JobTypeEnum::class,
        'accepting_applications' => 'boolean'
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

}
