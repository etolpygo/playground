<?php

namespace App\Models;

use App\Enums\JobTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes; 

    protected $primaryKey = 'job_id';

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

    protected $errors;

    public function validate($data)
    {
        $v = Validator::make($data, $this->rules);
        if ($v->fails()) {
            $this->errors = $v->errors();
            return false;
        }
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function import(): BelongsTo
    {
        return $this->belongsTo(Import::class, 'import_id');
    }

    private $rules = [
        'job_code' => 'required|max:8',
        'title' => 'required|max:255',
        'location' => 'required|max:255',
        'job_type' => [
            'required',
            'string',
            //Rule::in(JobTypeEnum::all()),
        ],
        'salary' => 'nullable|max:32',
        'application_deadline' => 'nullable|date',
        'description' => 'required|max:2048',
        'requirements' => 'required|max:2048',
        'accepting_applications' => 'sometimes|boolean',
    ];
    

}
