<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorSession extends Model
{
    /** @use HasFactory<\Database\Factories\VisitorSessionFactory> */
    use HasFactory;

    protected $guarded = [];
    

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
