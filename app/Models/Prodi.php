<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Registrant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prodi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function registrant() : HasMany
    {
        return this->hasMany(Registrant::class, 'prodi_id', 'id' );
    }

    public function member() : HasMany
    {
        return this->hasMany(Member::class, 'prodi_id', 'id' );
    }
}
