<?php

namespace App\Models;

use App\Enums\ServiceRequest\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Status $status
 * @property ServiceRequest $serviceRequest
 * @property User $user
 */
class ServiceStatus extends Model
{
    use HasFactory;

    protected $fillable = [ 'status' ];

    protected function casts(): array
    {
        return [
            'status' => Status::class
        ];
    }

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
