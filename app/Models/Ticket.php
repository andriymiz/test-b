<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    /**
     * @var int
     */
    public const STATUS_NEW = 0;

    /**
     * @var int
     */
    public const STATUS_OPEN = 1;

    /**
     * @var int
     */
    public const STATUS_CLOSED = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'subject',
        'status',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    /**
     * @return boolean
     */
    public function confirm(): bool
    {
        if (self::STATUS_NEW) {
            $this->status = self::STATUS_OPEN;
        }

        return $this->save();
    }
}
