<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;

class LogVisitor
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin*')) {
            return $next($request);
        }

        try {
            $ip = $request->ip();
            $userAgent = $request->header('User-Agent');

            $browser = 'Bilinmeyen';
            if (str_contains($userAgent, 'Firefox')) $browser = 'Firefox';
            elseif (str_contains($userAgent, 'Edg')) $browser = 'Edge';
            elseif (str_contains($userAgent, 'Chrome')) $browser = 'Chrome';
            elseif (str_contains($userAgent, 'Safari')) $browser = 'Safari';

            $device = str_contains($userAgent, 'Mobile') ? 'Mobil' : 'Masaüstü';

            $visitor = Visitor::where('ip_address', $ip)
                ->whereDate('created_at', today())
                ->first();

            if ($visitor) {
                $visitor->increment('visit_count');
                $visitor->update([
                    'last_seen_at' => now(),
                    'browser' => $browser,
                    'device' => $device,
                ]);
            } else {
                Visitor::create([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'browser' => $browser,
                    'device' => $device,
                    'visit_count' => 1,
                    'last_seen_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Visitor log error: ' . $e->getMessage());
        }

        return $next($request);
    }
}