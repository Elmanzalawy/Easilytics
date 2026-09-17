<?php

declare(strict_types=1);

namespace App\Dtos;

use Spatie\LaravelData\Data;

class SendMetricsDto extends Data
{
    public function __construct(
        public readonly string $website_uuid,
        public readonly string $host,
        public readonly string $ip,
        public readonly string $fingerprint,
        public readonly string $path,
        public readonly ?string $referrer = null,
    ) {}
}
