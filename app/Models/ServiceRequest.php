<?php

namespace App\Models;

use App\Enums\ServiceRequest\Priority;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $description
 * @property Priority $priority
 * @property Carbon $due_date
 * @property Aircraft $aircraft
 * @property Collection<ServiceStatus> $serviceStatuses
 * @property MaintenanceCompany $maintenanceCompany
 */
class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'priority', 'due_date', 'aircraft_id', 'maintenance_company_id'
    ];

    public function casts(): array
    {
        return [
            'priority' => Priority::class,
            'due_date' => 'date'
        ];
    }

    public function aircraft(): BelongsTo
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function maintenanceCompany(): BelongsTo
    {
        return $this->belongsTo(MaintenanceCompany::class);
    }

    public function serviceStatuses(): HasMany
    {
        return $this->hasMany(ServiceStatus::class)->latest();
    }

    public function currentStatus(): Attribute
    {
        return new Attribute(
            get: fn() => $this->serviceStatuses()->first()?->status
        );
    }

}
