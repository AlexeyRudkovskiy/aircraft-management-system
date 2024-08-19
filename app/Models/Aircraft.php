<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $model
 * @property int $serial_number
 * @property string $registration
 * @property MaintenanceCompany $maintenanceCompany
 * @property Collection<ServiceRequest> $serviceRequests
 */
class Aircraft extends Model
{
    use HasFactory;

    protected $fillable = [
        'model', 'serial_number', 'registration'
    ];

    public function maintenanceCompany(): BelongsTo
    {
        return $this->belongsTo(MaintenanceCompany::class);
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

}
