<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'description'
    ];

    public function member() : HasMany
    {
        return this->hasMany(Member::class, 'division_id', 'id' );
    }
}
