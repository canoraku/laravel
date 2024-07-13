<?php

namespace App\Models;

use App\Models\Prodi;
use App\Models\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'NIM', 'name', 'number_hp', 'period', 'birth_date', 'division_id', 'prodi_id'
    ];

    public function division (): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function prodi (): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id');
    }
}
