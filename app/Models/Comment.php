<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['body', 'student_id', 'commentable_id', 'commentable_type'];

    public function commentable()
    {
        return $this->morphTo();
    }
    public function student(): BelongsTo{
        return $this->belongsTo(User::class,'student_id');
    }
}
