<?php

namespace App\Models;

use Database\Factories\WebsiteFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $domain
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, VisitorSession> $visitorSessions
 * @property-read int|null $visitor_sessions_count
 *
 * @method static \Database\Factories\WebsiteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Website withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Website extends Model
{
    /** @use HasFactory<WebsiteFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function visitorSessions(): HasMany
    {
        return $this->hasMany(VisitorSession::class);
    }
}
