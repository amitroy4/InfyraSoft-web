<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;

class SiteDataController extends Controller
{
    private function defaultClients(): array
    {
        return [
            [
                'logo' => '/vite.svg',
                'name' => 'Northstar Retail',
                'url' => 'https://example.com',
                'active' => true,
            ],
            [
                'logo' => '/vite.svg',
                'name' => 'Atlas Finance',
                'url' => 'https://example.com',
                'active' => true,
            ],
            [
                'logo' => '/vite.svg',
                'name' => 'Summit Health',
                'url' => 'https://example.com',
                'active' => true,
            ],
            [
                'logo' => '/vite.svg',
                'name' => 'Prime Logistics',
                'url' => 'https://example.com',
                'active' => true,
            ],
            [
                'logo' => '/vite.svg',
                'name' => 'BluePeak Foods',
                'url' => 'https://example.com',
                'active' => true,
            ],
            [
                'logo' => '/vite.svg',
                'name' => 'Vertex Education',
                'url' => 'https://example.com',
                'active' => true,
            ],
        ];
    }

    private function defaultBlogCategories(): array
    {
        return [
            [
                'name' => 'Case Study',
                'slug' => 'case-study',
                'description' => 'Project stories, transformations, and client outcomes.',
                'active' => true,
            ],
            [
                'name' => 'Blog',
                'slug' => 'blog',
                'description' => 'Articles, insights, and technical posts.',
                'active' => true,
            ],
            [
                'name' => 'Announcement',
                'slug' => 'announcement',
                'description' => 'Product updates, company news, and launches.',
                'active' => true,
            ],
        ];
    }

    private function defaultBlogItems(): array
    {
        return [
            [
                'category' => 'case-study',
                'title' => 'How a Retail Team Automated Inventory and Sales Reporting',
                'image' => '/vite.svg',
                'date' => '2026-04-10',
                'details' => 'A short case study about replacing manual stock updates with a centralized reporting workflow.',
                'active' => true,
            ],
            [
                'category' => 'blog',
                'title' => 'Choosing the Right Stack for Scalable Business Applications',
                'image' => '/vite.svg',
                'date' => '2026-04-12',
                'details' => 'Practical guidance on balancing performance, maintainability, and delivery speed.',
                'active' => true,
            ],
            [
                'category' => 'announcement',
                'title' => 'New Client Portal Templates Are Now Available',
                'image' => '/vite.svg',
                'date' => '2026-04-14',
                'details' => 'A launch note covering the latest reusable UI templates for client portals.',
                'active' => true,
            ],
            [
                'category' => 'case-study',
                'title' => 'Improving Operations for a Logistics Business',
                'image' => '/vite.svg',
                'date' => '2026-04-18',
                'details' => 'A delivery story describing scheduling, dispatch, and workflow improvements.',
                'active' => true,
            ],
            [
                'category' => 'blog',
                'title' => 'What to Include in a Product Demo Story',
                'image' => '/vite.svg',
                'date' => '2026-04-20',
                'details' => 'A checklist for writing concise, useful demo content that drives action.',
                'active' => true,
            ],
            [
                'category' => 'announcement',
                'title' => 'Support Hours Updated for Better Response Coverage',
                'image' => '/vite.svg',
                'date' => '2026-04-22',
                'details' => 'A simple status update about support availability and response times.',
                'active' => true,
            ],
        ];
    }

    public function __invoke()
    {
        $productCategories = [
            [
                'name' => 'ERP',
                'slug' => 'erp',
                'description' => 'Enterprise resource planning products for internal operations.',
                'active' => true,
            ],
            [
                'name' => 'SaaS',
                'slug' => 'saas',
                'description' => 'Subscription-ready software products for multiple clients.',
                'active' => true,
            ],
            [
                'name' => 'Management',
                'slug' => 'management',
                'description' => 'Business and operational management solutions.',
                'active' => true,
            ],
            [
                'name' => 'Other',
                'slug' => 'other',
                'description' => 'Custom or uncategorized products.',
                'active' => true,
            ],
        ];

        $products = [
            [
                'category' => 'saas',
                'logo' => '🛒',
                'title' => 'ShopBD eCommerce Suite',
                'details' => 'Full-featured multi-vendor eCommerce platform with payment gateway, SEO tools, and a mobile-first storefront.',
                'features' => ['Multi-vendor', 'Payment gateway', 'SEO tools', 'Mobile-first'],
                'stack' => ['React', 'Node.js', 'PostgreSQL'],
                'demo_message' => 'Book a demo for ShopBD eCommerce Suite',
                'active' => true,
            ],
            [
                'category' => 'erp',
                'logo' => '📦',
                'title' => 'Inventory System',
                'details' => 'Real-time inventory tracking with barcode scanning, purchase orders, and stock alerts.',
                'features' => ['Barcode scan', 'Stock alerts', 'PO management', 'Analytics'],
                'stack' => ['React', 'Express', 'MongoDB'],
                'demo_message' => 'Book a demo for Inventory System',
                'active' => true,
            ],
            [
                'category' => 'erp',
                'logo' => '👥',
                'title' => 'HRM System',
                'details' => 'Manage recruitment, payroll, attendance, leave, and performance reviews in one platform.',
                'features' => ['Payroll', 'Leave management', 'Recruitment', 'Reviews'],
                'stack' => ['React', 'Node.js', 'MySQL'],
                'demo_message' => 'Book a demo for HRM System',
                'active' => true,
            ],
            [
                'category' => 'erp',
                'logo' => '💰',
                'title' => 'Accounting Software',
                'details' => 'Invoicing, expense tracking, tax reports, bank reconciliation, and multi-currency support.',
                'features' => ['Invoicing', 'Tax reports', 'Multi-currency', 'Reconciliation'],
                'stack' => ['React', 'Python', 'PostgreSQL'],
                'demo_message' => 'Book a demo for Accounting Software',
                'active' => true,
            ],
            [
                'category' => 'saas',
                'logo' => '🍽️',
                'title' => 'Restaurant SaaS',
                'details' => 'POS, online ordering, table management, kitchen display, and loyalty programs for restaurants.',
                'features' => ['POS system', 'Online orders', 'KDS', 'Loyalty'],
                'stack' => ['React', 'Node.js', 'Redis'],
                'demo_message' => 'Book a demo for Restaurant SaaS',
                'active' => true,
            ],
            [
                'category' => 'management',
                'logo' => '📈',
                'title' => 'Investment Management',
                'details' => 'Portfolio tracking, risk assessment, real-time market data, and financial analytics.',
                'features' => ['Portfolio', 'Risk scoring', 'Market data', 'Reports'],
                'stack' => ['React', 'Python', 'MySQL'],
                'demo_message' => 'Book a demo for Investment Management',
                'active' => true,
            ],
            [
                'category' => 'management',
                'logo' => '🏠',
                'title' => 'Tenant Management',
                'details' => 'Lease management, rent collection, maintenance tracking, and tenant portal.',
                'features' => ['Lease management', 'Rent collection', 'Maintenance', 'Tenant portal'],
                'stack' => ['React', 'Node.js', 'PostgreSQL'],
                'demo_message' => 'Book a demo for Tenant Management',
                'active' => true,
            ],
            [
                'category' => 'saas',
                'logo' => '🏪',
                'title' => 'POS System',
                'details' => 'Modern point-of-sale for retail with inventory integration and sales analytics.',
                'features' => ['Sales tracking', 'Staff management', 'Inventory sync', 'Receipts'],
                'stack' => ['React', 'Express', 'SQLite'],
                'demo_message' => 'Book a demo for POS System',
                'active' => true,
            ],
        ];
        $clients = $this->defaultClients();
        $blogCategories = $this->defaultBlogCategories();
        $blogItems = $this->defaultBlogItems();

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
            'products_categories' => json_encode($productCategories, JSON_UNESCAPED_UNICODE),
            'products_items' => json_encode($products, JSON_UNESCAPED_UNICODE),
            'clients_items' => json_encode($clients, JSON_UNESCAPED_UNICODE),
            'blog_categories' => json_encode($blogCategories, JSON_UNESCAPED_UNICODE),
            'blog_items' => json_encode($blogItems, JSON_UNESCAPED_UNICODE),
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
