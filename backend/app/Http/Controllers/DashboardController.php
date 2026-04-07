<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private array $defaults = [
        'site_title' => 'InfyraSoft Tech',
        'hero_subtitle' => 'InfyraSoft Tech delivers cutting-edge apps, SaaS platforms & enterprise automation for modern businesses in Dhaka and beyond.',
        'about_paragraph_1' => 'Based in Dhaka, Bangladesh, InfyraSoft Tech is a professional software development company specializing in web applications, SaaS platforms, and business automation systems.',
        'about_paragraph_2' => 'We create secure, scalable, and high-performance solutions that help companies streamline operations and accelerate growth globally.',
        'contact_location' => 'Dhaka, Bangladesh',
        'contact_email' => 'info@infyrasoft.tech',
        'contact_phone' => '+880 1XXX-XXXXXX',
        'contact_hours' => 'Sun-Thu: 9AM - 6PM BST',
        'footer_tagline' => 'Building scalable software solutions for modern digital businesses. Based in Dhaka, Bangladesh.',
        'footer_copyright' => '© 2025 InfyraSoft Tech. All rights reserved. Built in Dhaka',
        'stat_projects' => '50+',
        'stat_clients' => '30+',
        'stat_products' => '8+',
        'stat_rating' => '5★',
    ];

    public function index()
    {
        $settings = SiteSetting::toKeyValueMap();
        $merged = [];

        foreach ($this->defaults as $key => $value) {
            $merged[$key] = $settings->get($key, $value);
        }

        return view('dashboard.settings', [
            'settings' => $merged,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_title' => ['required', 'string', 'max:120'],
            'hero_subtitle' => ['required', 'string'],
            'about_paragraph_1' => ['required', 'string'],
            'about_paragraph_2' => ['required', 'string'],
            'contact_location' => ['required', 'string', 'max:190'],
            'contact_email' => ['required', 'email', 'max:190'],
            'contact_phone' => ['required', 'string', 'max:60'],
            'contact_hours' => ['required', 'string', 'max:120'],
            'footer_tagline' => ['required', 'string'],
            'footer_copyright' => ['required', 'string', 'max:220'],
            'stat_projects' => ['required', 'string', 'max:30'],
            'stat_clients' => ['required', 'string', 'max:30'],
            'stat_products' => ['required', 'string', 'max:30'],
            'stat_rating' => ['required', 'string', 'max:30'],
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return redirect('/dashboard')->with('status', 'Website content updated successfully.');
    }

    public function leads()
    {
        $leads = Lead::query()->latest()->paginate(20);

        return view('dashboard.leads', [
            'leads' => $leads,
        ]);
    }
}
