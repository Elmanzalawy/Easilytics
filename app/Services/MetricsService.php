<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\VisitorSession;
use App\Models\Website;
use Illuminate\Http\Request;
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

    public function logMetrics(Request $request)// : array
    {
        $session = $this->updateOrCreateSession($request);
        $this->logPageView($session, $request);


        return [
            'website' => Website::where('uuid', request()->query('website_uuid'))->first(),
            'host' => request()->host(),
            'ip' => request()->ip(),
            'fingerprint' => request()->fingerprint(),
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
            'request' => [
                'url' => $request->url(),
                'fullUrl' => $request->fullUrl(),
                'path' => $request->path(),
            ],
        ];
    }

    private function updateOrCreateSession(Request $request)
    {
        $session = VisitorSession::where('hash', $request->fingerprint())->first();

        if ($session) {
            $session->last_seen_at = now();
            $session->save();
        } else {
            $session = VisitorSession::create([
                'website_id' => Website::where('uuid', $request->query('website_uuid'))->first()->id,
                'hash' => $request->fingerprint(),
                'ip_address' => $request->ip(),
                'country' => $this->position->countryName ?? '',
                'city' => $this->position->cityName ?? '',
                'region' => $this->position->regionName ?? '',
                'latitude' => $this->position->latitude ?? '',
                'longitude' => $this->position->longitude ?? '',
                'os' => $this->agent->platform(),
                'device_type' => $this->getDeviceType($this->agent),
                'referrer_domain' => !empty($request->headers->get('referer')) ? parse_url($request->headers->get('referer'), PHP_URL_HOST) ?? null : null,
                'last_seen_at' => now(),
            ]);
        }

        return $session;
    }

    private function logPageView(VisitorSession $session, Request $request): void
    {
        $session->pageViews()->create([
            'website_id' => $session->website_id,
            'path' => $request->path(),
            'referrer' => $request->headers->get('referer'),
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
