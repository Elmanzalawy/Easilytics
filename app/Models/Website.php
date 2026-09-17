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
 * @property-read Collection<int, PageView> $pageViews
 * @property-read int|null $page_views_count
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

    public function getUniqueVisitsCount(): int
    {
        return cache()->remember(
            "website_{$this->id}_unique_visits_count",
            now()->addMinutes(5),
            fn () => $this->visitorSessions()->count()
        );
    }

    public function getViewsCount(): int
    {
        return cache()->remember(
            "website_{$this->id}_views_count",
            now()->addMinutes(5),
            fn () => $this->pageViews()->count()
        );
    }

    public function getBounceRate(): float
    {
        return cache()->remember(
            "website_{$this->id}_bounce_rate",
            now()->addMinutes(5),
            function () {
                $totalSessions = $this->getUniqueVisitsCount();

                if ($totalSessions === 0) {
                    return 0;
                }

                $singlePageSessions = PageView::query()
                    ->where('website_id', $this->id)
                    ->whereNotNull('visitor_session_id')
                    ->groupBy('visitor_session_id')
                    ->havingRaw('COUNT(*) = 1')
                    ->count();

                return $singlePageSessions / $totalSessions;
            }
        );
    }

    public function getAverageTimeOnPage(): string
    {
        // Replace this with the actual calculation for average time on page
        return cache()->remember(
            "website_{$this->id}_average_time_on_page",
            now()->addMinutes(5),
            fn () => '3:12'
        );
    }

    public function visitorSessions(): HasMany
    {
        return $this->hasMany(VisitorSession::class);
    }

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }
}
