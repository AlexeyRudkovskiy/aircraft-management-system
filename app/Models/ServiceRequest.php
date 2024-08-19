<?php

namespace App\Models;

use App\Enums\ServiceRequest\Priority;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $description
 * @property Priority $priority
 * @property Carbon $due_date
 * @property Aircraft $aircraft
 */
class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'priority', 'due_date'
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

}
