<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $visitor_session_id
 * @property int $website_id
 * @property string $path
 * @property string|null $referrer
 * @property string $created_at
 * @property-read \App\Models\VisitorSession $visitorSession
 * @property-read \App\Models\Website|null $website
 * @method static \Database\Factories\PageViewFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageView query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageView wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageView whereReferrer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageView whereVisitorSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PageView whereWebsiteId($value)
 * @mixin \Eloquent
 */
class PageView extends Model
{
    /** @use HasFactory<\Database\Factories\PageViewFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function visitorSession(): BelongsTo
    {
        return $this->belongsTo(VisitorSession::class);
    }

}
