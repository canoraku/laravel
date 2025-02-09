<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'thumbnail', 'description', 'date', 'status', 'author'
    ];

    public function by (): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
