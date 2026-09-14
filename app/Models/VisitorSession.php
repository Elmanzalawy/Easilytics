<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\VisitorSessionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $website_id
 * @property string $hash
 * @property string $ip_address
 * @property string $country
 * @property string $city
 * @property string|null $region
 * @property string $latitude
 * @property string $longitude
 * @property string $os
 * @property string $device_type
 * @property string|null $referrer_domain
 * @property Carbon|null $last_seen_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PageView> $pageViews
 * @property-read int|null $page_views_count
 * @property-read \App\Models\Website|null $website
 * @method static \Database\Factories\VisitorSessionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereLastSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereOs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereReferrerDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitorSession whereWebsiteId($value)
 * @mixin \Eloquent
 */
class VisitorSession extends Model
{
    /** @use HasFactory<VisitorSessionFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'last_seen_at' => 'datetime',
        ];
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }
}
