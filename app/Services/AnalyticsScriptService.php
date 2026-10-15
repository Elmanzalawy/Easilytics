<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Website;

class AnalyticsScriptService
{
    public function scriptUrl(Website $website): string
    {
        return route('analytics.script', ['website' => $website->uuid]);
    }

    public function snippet(Website $website): string
    {
        return '<script async src="'.$this->scriptUrl($website).'"></script>';
    }

    public function generate(Website $website): string
    {
        $uuid = json_encode($website->uuid, JSON_THROW_ON_ERROR);
        $endpoint = json_encode(route('api.v1.sendMetrics'), JSON_THROW_ON_ERROR);

        return <<<JS
            (function () {
                var websiteUuid = {$uuid};
                var endpoint = {$endpoint};
                var lastPath = null;

                function track() {
                    var path = location.pathname + location.search;
                    if (path === lastPath) {
                        return;
                    }
                    var referrer = lastPath === null ? document.referrer : location.origin + lastPath;
                    lastPath = path;

                    fetch(endpoint, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                        body: JSON.stringify({
                            website_uuid: websiteUuid,
                            path: path,
                            referrer: referrer || null,
                            title: document.title || null
                        }),
                        keepalive: true
                    }).catch(function () {});
                }

                ['pushState', 'replaceState'].forEach(function (method) {
                    var original = history[method];
                    history[method] = function () {
                        var result = original.apply(this, arguments);
                        setTimeout(track, 0);
                        return result;
                    };
                });
                window.addEventListener('popstate', track);

                track();
            })();
        JS;
    }
}
