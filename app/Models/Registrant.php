<?php

namespace App\Models;

use App\Models\Prodi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registrant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'NIM', 'number_hp', 'birth_date', 'prodi_id', 'motivation_later', 'CV', 'is_accepted'
    ];

    public function prodi (): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id');
    }
}
