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
            'footer_logo' => '/vite.svg',
            'site_favicon' => '/vite.svg',
            'hero_subtitle' => 'InfyraSoft Tech delivers cutting-edge apps, SaaS platforms & enterprise automation for modern businesses in Dhaka and beyond.',
            'about_paragraph_1' => 'Based in Dhaka, Bangladesh, InfyraSoft Tech is a professional software development company specializing in web applications, SaaS platforms, and business automation systems.',
            'about_paragraph_2' => 'We create secure, scalable, and high-performance solutions that help companies streamline operations and accelerate growth globally.',
            'about_title' => 'We Build Digital Experiences That Drive Growth',
            'about_point_1' => 'Expert certified development team',
            'about_point_2' => 'Agile delivery with regular demos',
            'about_point_3' => 'Client-first approach always',
            'about_point_4' => 'Ongoing support & maintenance',
            'about_button_text' => 'Learn Our Story ->',
            'about_button_link' => '',
            'about_button_active' => '1',
            'core_services_title' => 'Our Core Services',
            'core_services_subtitle' => 'End-to-end technology services to power your digital transformation journey.',
            'core_services_items' => json_encode([
                [
                    'icon' => '🌐',
                    'title' => 'Domain & Hosting',
                    'details' => 'Reliable, high-performance hosting with 99.9% uptime SLA. We manage domain registration, DNS, SSL certificates, CDN, and server infrastructure.',
                    'key_points' => ['99.9% Uptime SLA', 'Free SSL Certificate', 'DDoS Protection', '24/7 Monitoring', 'Auto Backups', 'CDN Integration'],
                    'active' => true,
                ],
                [
                    'icon' => '💻',
                    'title' => 'Custom Application Development',
                    'details' => 'Tailor-made web and mobile applications using React, Next.js, Node.js, and modern tech stacks. From MVPs to enterprise-grade platforms.',
                    'key_points' => ['React & Next.js', 'Node.js Backend', 'REST & GraphQL', 'Mobile Apps', 'Cloud Deploy', 'Full Documentation'],
                    'active' => true,
                ],
                [
                    'icon' => '🛡️',
                    'title' => 'Cyber Security Support',
                    'details' => 'Comprehensive cybersecurity solutions including penetration testing, vulnerability assessments, security audits, and incident response.',
                    'key_points' => ['Penetration Testing', 'Vulnerability Scan', 'Security Audits', 'Firewall Config', 'Incident Response', 'Compliance'],
                    'active' => true,
                ],
                [
                    'icon' => '🤖',
                    'title' => 'AI Support & Integration',
                    'details' => 'Integrate cutting-edge AI into your existing systems to automate workflows, gain intelligent insights, and build smarter applications.',
                    'key_points' => ['ChatGPT Integration', 'ML Models', 'Intelligent Chatbots', 'Predictive Analytics', 'Process Automation', 'NLP Solutions'],
                    'active' => true,
                ],
                [
                    'icon' => '🔧',
                    'title' => 'Technical Support',
                    'details' => '24/7 technical assistance for all your software systems. From urgent bug fixes to performance optimization — always available.',
                    'key_points' => ['24/7 Availability', 'Remote Support', 'Bug Fixes', 'Performance Tuning', 'System Upgrades', 'Priority SLA'],
                    'active' => true,
                ],
                [
                    'icon' => '☁️',
                    'title' => 'SaaS Platform Development',
                    'details' => 'Build scalable SaaS platforms with multi-tenant architecture, subscription billing, and cloud-native infrastructure.',
                    'key_points' => ['Multi-tenant Arch', 'Subscription Billing', 'Cloud-Native', 'Auto Scaling', 'White-label Ready', 'Analytics'],
                    'active' => true,
                ],
            ], JSON_UNESCAPED_UNICODE),
            'core_service_1_icon' => '🌐',
            'core_service_1_title' => 'Domain & Hosting',
            'core_service_1_details' => 'Reliable, high-performance hosting with 99.9% uptime SLA. We manage domain registration, DNS, SSL certificates, CDN, and server infrastructure.',
            'core_service_1_key_points' => "99.9% Uptime SLA\nFree SSL Certificate\nDDoS Protection\n24/7 Monitoring\nAuto Backups\nCDN Integration",
            'core_service_2_icon' => '💻',
            'core_service_2_title' => 'Custom Application Development',
            'core_service_2_details' => 'Tailor-made web and mobile applications using React, Next.js, Node.js, and modern tech stacks. From MVPs to enterprise-grade platforms.',
            'core_service_2_key_points' => "React & Next.js\nNode.js Backend\nREST & GraphQL\nMobile Apps\nCloud Deploy\nFull Documentation",
            'core_service_3_icon' => '🛡️',
            'core_service_3_title' => 'Cyber Security Support',
            'core_service_3_details' => 'Comprehensive cybersecurity solutions including penetration testing, vulnerability assessments, security audits, and incident response.',
            'core_service_3_key_points' => "Penetration Testing\nVulnerability Scan\nSecurity Audits\nFirewall Config\nIncident Response\nCompliance",
            'core_service_4_icon' => '🤖',
            'core_service_4_title' => 'AI Support & Integration',
            'core_service_4_details' => 'Integrate cutting-edge AI into your existing systems to automate workflows, gain intelligent insights, and build smarter applications.',
            'core_service_4_key_points' => "ChatGPT Integration\nML Models\nIntelligent Chatbots\nPredictive Analytics\nProcess Automation\nNLP Solutions",
            'core_service_5_icon' => '🔧',
            'core_service_5_title' => 'Technical Support',
            'core_service_5_details' => '24/7 technical assistance for all your software systems. From urgent bug fixes to performance optimization — always available.',
            'core_service_5_key_points' => "24/7 Availability\nRemote Support\nBug Fixes\nPerformance Tuning\nSystem Upgrades\nPriority SLA",
            'core_service_6_icon' => '☁️',
            'core_service_6_title' => 'SaaS Platform Development',
            'core_service_6_details' => 'Build scalable SaaS platforms with multi-tenant architecture, subscription billing, and cloud-native infrastructure.',
            'core_service_6_key_points' => "Multi-tenant Arch\nSubscription Billing\nCloud-Native\nAuto Scaling\nWhite-label Ready\nAnalytics",
            'products_title' => 'Ready-Made Software Products',
            'products_subtitle' => 'Battle-tested products ready to deploy or customize for your business.',
            'clients_tag' => 'Trusted By',
            'clients_title' => 'Our Clients',
            'blog_title' => 'Case Studies & Blog',
            'blog_subtitle' => 'Insights, success stories, and technical deep-dives from our team.',
            'contact_location' => 'Dhaka, Bangladesh',
            'contact_email' => 'info@infyrasoft.tech',
            'contact_phone' => '+880 1XXX-XXXXXX',
            'whatsapp_link' => '',
            'facebook_link' => '',
            'linkedin_link' => '',
            'contact_hours' => 'Sun-Thu: 9AM - 6PM BST',
            'footer_tagline' => 'Building scalable software solutions for modern digital businesses. Based in Dhaka, Bangladesh.',
            'footer_copyright' => '© 2025 InfyraSoft Tech. All rights reserved. Built in Dhaka',
            'privacy_policy' => 'Privacy Policy',
            'terms_of_service' => 'Terms of Service',
            'stat_projects' => '50+',
            'stat_clients' => '30+',
            'stat_products' => '8+',
            'stat_rating' => '5★',
        ];

        $saved = SiteSetting::toKeyValueMap()->all();

        return response()->json(array_merge($defaults, $saved));
    }
}
