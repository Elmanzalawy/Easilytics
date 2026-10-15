<?php

namespace Tests\Feature;

use App\Models\PageView;
use App\Models\VisitorSession;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class WebsiteBounceRateTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_zero_when_the_website_has_no_sessions(): void
    {
        $website = Website::query()->create([
            'uuid' => Str::uuid(),
            'name' => 'Example site',
            'domain' => 'example.com',
        ]);

        $this->assertSame(0.0, $website->getBounceRate());
    }

    public function test_it_calculates_bounce_rate_from_single_page_sessions(): void
    {
        $website = Website::query()->create([
            'uuid' => Str::uuid(),
            'name' => 'Analytics site',
            'domain' => 'analytics.example',
        ]);

        $sessionWithOnePage = VisitorSession::query()->create([
            'website_id' => $website->id,
            'hash' => Str::uuid(),
            'ip_address' => '127.0.0.1',
            'country' => 'US',
            'city' => 'Seattle',
            'region' => 'WA',
            'latitude' => '47.6062',
            'longitude' => '-122.3321',
            'os' => 'Linux',
            'device_type' => 'desktop',
            'language' => 'en-US',
            'referrer' => null,
            'last_seen_at' => now(),
        ]);

        $sessionWithTwoPages = VisitorSession::query()->create([
            'website_id' => $website->id,
            'hash' => Str::uuid(),
            'ip_address' => '127.0.0.2',
            'country' => 'US',
            'city' => 'Boston',
            'region' => 'MA',
            'latitude' => '42.3601',
            'longitude' => '-71.0589',
            'os' => 'macOS',
            'device_type' => 'desktop',
            'language' => 'en-US',
            'referrer' => null,
            'last_seen_at' => now(),
        ]);

        $sessionWithThreePages = VisitorSession::query()->create([
            'website_id' => $website->id,
            'hash' => Str::uuid(),
            'ip_address' => '127.0.0.3',
            'country' => 'CA',
            'city' => 'Toronto',
            'region' => 'ON',
            'latitude' => '43.6532',
            'longitude' => '-79.3832',
            'os' => 'Windows',
            'device_type' => 'desktop',
            'language' => 'en-CA',
            'referrer' => null,
            'last_seen_at' => now(),
        ]);

        PageView::query()->create([
            'website_id' => $website->id,
            'visitor_session_id' => $sessionWithOnePage->id,
            'path' => '/',
            'created_at' => now(),
        ]);

        PageView::query()->create([
            'website_id' => $website->id,
            'visitor_session_id' => $sessionWithTwoPages->id,
            'path' => '/',
            'created_at' => now(),
        ]);

        PageView::query()->create([
            'website_id' => $website->id,
            'visitor_session_id' => $sessionWithTwoPages->id,
            'path' => '/about',
            'created_at' => now(),
        ]);

        PageView::query()->create([
            'website_id' => $website->id,
            'visitor_session_id' => $sessionWithThreePages->id,
            'path' => '/',
            'created_at' => now(),
        ]);

        PageView::query()->create([
            'website_id' => $website->id,
            'visitor_session_id' => $sessionWithThreePages->id,
            'path' => '/products',
            'created_at' => now(),
        ]);

        PageView::query()->create([
            'website_id' => $website->id,
            'visitor_session_id' => $sessionWithThreePages->id,
            'path' => '/pricing',
            'created_at' => now(),
        ]);

        $this->assertEqualsWithDelta(1 / 3, $website->getBounceRate(), 0.0001);
    }
}
