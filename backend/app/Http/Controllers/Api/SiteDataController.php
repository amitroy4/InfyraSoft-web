<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;

class SiteDataController extends Controller
{
    public function __invoke()
    {
        $defaults = [
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

        $saved = SiteSetting::toKeyValueMap()->all();

        return response()->json(array_merge($defaults, $saved));
    }
}
