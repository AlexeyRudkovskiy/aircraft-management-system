<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $contact
 * @property string $specialization
 * @property Collection<Aircraft> $aircrafts
 */
class MaintenanceCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'contact', 'specialization'
    ];

    public function aircrafts(): HasMany
    {
        return $this->hasMany(Aircraft::class);
    }

}
