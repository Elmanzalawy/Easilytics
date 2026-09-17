<?php

declare(strict_types=1);

namespace App\Services;

use App\Dtos\SendMetricsDto;
use App\Models\VisitorSession;
use App\Models\Website;
use Jenssegers\Agent\Agent;
use Location;
use Stevebauman\Location\Position;

class MetricsService
{
    public function __construct(
        private readonly Agent $agent,
        private Position $position,
    ) {
        $this->position = Location::get('197.54.28.225');
    }

    public function logMetrics(SendMetricsDto $dto): void
    {
        $session = $this->updateOrCreateSession($dto);
        $this->logPageView($session, $dto);

        info(json_encode([
            'website' => Website::where('uuid', $dto->website_uuid)->first(),
            'host' => $dto->host,
            'ip' => $dto->ip,
            'fingerprint' => $dto->fingerprint,
            'session' => $session,
            'agent' => [
                'isAndroidOS' => $this->agent->isAndroidOS(),
                'isiPhone' => $this->agent->isiPhone(),
                'isNexus' => $this->agent->isNexus(),
                'isSafari' => $this->agent->isSafari(),
                'isDesktop' => $this->agent->isDesktop(),
                'isMobile' => $this->agent->isMobile(),
                'isTablet' => $this->agent->isTablet(),
                'languages' => $this->agent->languages(),
                'device' => $this->agent->device(),
                'platform' => $this->agent->platform(),
                'platformVersion' => $this->agent->version($this->agent->platform()),
                'browser' => $this->agent->browser(),
                'browserVersion' => $this->agent->version($this->agent->browser()),
                'isPhone' => $this->agent->isPhone(),
                'isRobot' => $this->agent->isRobot(),

            ],
            'location' => $this->position,
        ], JSON_PRETTY_PRINT));
    }

    private function updateOrCreateSession(SendMetricsDto $dto): VisitorSession
    {
        $session = VisitorSession::where('hash', $dto->fingerprint)->first();

        if ($session) {
            $session->last_seen_at = now();
            $session->save();
        } else {
            $session = VisitorSession::create([
                'website_id' => Website::where('uuid', $dto->website_uuid)->first()->id,
                'hash' => $dto->fingerprint,
                'ip_address' => $dto->ip,
                'country' => $this->position->countryName,
                'city' => $this->position->cityName,
                'region' => $this->position->regionName,
                'latitude' => $this->position->latitude,
                'longitude' => $this->position->longitude,
                'os' => $this->agent->platform(),
                'device_type' => $this->getDeviceType($this->agent),
                'language' => array_first($this->agent->languages()),
                'referrer' => $dto->referrer,
                'last_seen_at' => now(),
            ]);
        }

        return $session;
    }

    private function logPageView(VisitorSession $session, SendMetricsDto $dto): void
    {
        $session->pageViews()->create([
            'website_id' => $session->website_id,
            'path' => $dto->path,
            'created_at' => now(),
        ]);
    }

    private function getDeviceType(Agent $agent): string
    {
        if ($agent->isDesktop()) {
            return 'desktop';
        }
        if ($agent->isTablet()) {
            return 'tablet';
        }
        if ($agent->isMobile()) {
            return 'mobile';
        }

        return 'unknown';
    }
}
