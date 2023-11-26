<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Import extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'import_id';

    public $incrementing = false;

    protected  $fillable = [
        'filename'
    ];

    public function uploadingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploading_user_id');
    }


}