<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function defaultProductCategories(): array
    {
        return [
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
    }

    private function defaultProducts(): array
    {
        return [
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
    }

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

    private function defaults(): array
    {
        $coreServices = [
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
        ];
        $productCategories = $this->defaultProductCategories();
        $products = $this->defaultProducts();
        $clients = $this->defaultClients();
        $blogCategories = $this->defaultBlogCategories();
        $blogItems = $this->defaultBlogItems();

        return [
            'site_title' => 'InfyraSoft Tech',
            'footer_logo' => '/vite.svg',
            'site_favicon' => '/vite.svg',
            'hero_badge_text' => "🚀 Bangladesh's Trusted Tech Partner",
            'hero_type_words' => "Web Applications\nSaaS Platforms\nERP Systems\nAI Solutions\nCustom Software",
            'hero_menu_items' => "Home\nAbout\nServices\nProducts\nPortfolio\nContact",
            'hero_primary_button_text' => 'Explore Services',
            'hero_secondary_button_text' => 'View Our Work',
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
            'core_services_items' => json_encode($coreServices, JSON_UNESCAPED_UNICODE),
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
            'clients_tag' => 'Trusted By',
            'clients_title' => 'Our Clients',
            'blog_categories' => json_encode($blogCategories, JSON_UNESCAPED_UNICODE),
            'blog_items' => json_encode($blogItems, JSON_UNESCAPED_UNICODE),
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
    }

    private function mergedSettings(): array
    {
        $settings = SiteSetting::toKeyValueMap();
        $merged = [];
        $defaults = $this->defaults();

        foreach ($defaults as $key => $value) {
            $merged[$key] = $settings->get($key, $value);
        }

        return $merged;
    }

    private function normalizeStringList($value): array
    {
        if (is_array($value)) {
            $items = $value;
        } else {
            $items = preg_split('/\r\n|\n|\r|,/', (string) $value) ?: [];
        }

        $items = array_map(function ($item) {
            return trim((string) $item);
        }, $items);

        return array_values(array_filter($items, function ($item) {
            return $item !== '';
        }));
    }

    private function slugifyText(string $value): string
    {
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $value) ?? '', '-'));

        return $slug !== '' ? $slug : 'item';
    }

    private function persist(array $validated): void
    {
        foreach ($validated as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }
    }

    public function dashboard()
    {
        return redirect()->route('dashboard.branding');
    }

    public function branding()
    {
        return view('dashboard.sections.branding', [
            'settings' => $this->mergedSettings(),
        ]);
    }

    public function updateBranding(Request $request)
    {
        $validated = $request->validate([
            'site_title' => ['required', 'string', 'max:120'],
            'contact_location' => ['required', 'string', 'max:190'],
            'contact_hours' => ['required', 'string', 'max:120'],
            'contact_phone' => ['required', 'string', 'max:60'],
            'contact_email' => ['required', 'email', 'max:190'],
            'whatsapp_link' => ['nullable', 'url', 'max:220'],
            'facebook_link' => ['nullable', 'url', 'max:220'],
            'linkedin_link' => ['nullable', 'url', 'max:220'],
            'footer_logo_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'site_favicon_upload' => ['nullable', 'mimes:ico,png,svg,webp', 'max:1024'],
        ]);

        if ($request->hasFile('footer_logo_upload')) {
            $path = $request->file('footer_logo_upload')->store('site-assets', 'public');
            $validated['footer_logo'] = '/storage/' . $path;
        }

        if ($request->hasFile('site_favicon_upload')) {
            $path = $request->file('site_favicon_upload')->store('site-assets', 'public');
            $validated['site_favicon'] = '/storage/' . $path;
        }

        unset($validated['footer_logo_upload']);
        unset($validated['site_favicon_upload']);
        $this->persist($validated);

        return redirect()->route('dashboard.branding')->with('status', 'Branding updated successfully.');
    }

    public function home()
    {
        return view('dashboard.sections.home', [
            'settings' => $this->mergedSettings(),
        ]);
    }

    public function updateHome(Request $request)
    {
        $validated = $request->validate([
            'hero_badge_text' => ['required', 'string', 'max:120'],
            'hero_subtitle' => ['required', 'string'],
            'hero_type_words' => ['required', 'string', 'max:500'],
            'hero_menu_items' => ['required', 'string', 'max:500'],
            'hero_primary_button_text' => ['required', 'string', 'max:120'],
            'hero_secondary_button_text' => ['required', 'string', 'max:120'],
        ]);

        $this->persist($validated);

        return redirect()->route('dashboard.home')->with('status', 'Home section updated successfully.');
    }

    public function about()
    {
        return view('dashboard.sections.about', [
            'settings' => $this->mergedSettings(),
        ]);
    }

    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'about_paragraph_1' => ['required', 'string'],
            'about_paragraph_2' => ['required', 'string'],
            'about_title' => ['required', 'string', 'max:220'],
            'about_point_1' => ['required', 'string', 'max:220'],
            'about_point_2' => ['required', 'string', 'max:220'],
            'about_point_3' => ['required', 'string', 'max:220'],
            'about_point_4' => ['required', 'string', 'max:220'],
            'about_button_text' => ['required', 'string', 'max:120'],
            'about_button_link' => ['nullable', 'string', 'max:300'],
            'about_button_active' => ['nullable', 'boolean'],
        ]);

        $validated['about_button_active'] = $request->boolean('about_button_active') ? '1' : '0';

        $this->persist($validated);

        return redirect()->route('dashboard.about')->with('status', 'About section updated successfully.');
    }

    public function contact()
    {
        return view('dashboard.sections.contact', [
            'settings' => $this->mergedSettings(),
        ]);
    }

    public function coreServices()
    {
        return view('dashboard.sections.core-services', [
            'settings' => $this->mergedSettings(),
        ]);
    }

    public function updateCoreServices(Request $request)
    {
        $validated = $request->validate([
            'core_services_title' => ['required', 'string', 'max:220'],
            'core_services_subtitle' => ['required', 'string', 'max:600'],
            'core_services_items' => ['required', 'json'],
        ]);

        $items = json_decode($validated['core_services_items'], true);
        if (!is_array($items)) {
            return redirect()->route('dashboard.core-services')->withErrors(['core_services_items' => 'Invalid service data format.']);
        }

        $normalized = [];
        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $icon = trim((string)($item['icon'] ?? ''));
            $title = trim((string)($item['title'] ?? ''));
            $details = trim((string)($item['details'] ?? ''));
            $active = !empty($item['active']);

            $keyPointsRaw = $item['key_points'] ?? [];
            $keyPoints = is_array($keyPointsRaw)
                ? $keyPointsRaw
                : preg_split('/\r\n|\n|\r/', (string)$keyPointsRaw);

            $keyPoints = array_values(array_filter(array_map(function ($point) {
                return trim((string)$point);
            }, $keyPoints), function ($point) {
                return $point !== '';
            }));

            if ($icon === '' || $title === '' || $details === '' || count($keyPoints) === 0) {
                continue;
            }

            $normalized[] = [
                'icon' => substr($icon, 0, 20),
                'title' => substr($title, 0, 220),
                'details' => substr($details, 0, 1500),
                'key_points' => array_slice($keyPoints, 0, 12),
                'active' => $active,
            ];
        }

        if (count($normalized) === 0) {
            return redirect()->route('dashboard.core-services')->withErrors(['core_services_items' => 'Please add at least one valid service.']);
        }

        $validated['core_services_items'] = json_encode($normalized, JSON_UNESCAPED_UNICODE);

        $activeServices = array_values(array_filter($normalized, function ($item) {
            return !empty($item['active']);
        }));

        for ($i = 1; $i <= 6; $i++) {
            $service = $activeServices[$i - 1] ?? null;
            $validated["core_service_{$i}_icon"] = $service['icon'] ?? '';
            $validated["core_service_{$i}_title"] = $service['title'] ?? '';
            $validated["core_service_{$i}_details"] = $service['details'] ?? '';
            $validated["core_service_{$i}_key_points"] = $service ? implode("\n", $service['key_points']) : '';
        }

        $this->persist($validated);

        return redirect()->route('dashboard.core-services')->with('status', 'Core Services section updated successfully.');
    }

    public function products()
    {
        return view('dashboard.sections.products', [
            'settings' => $this->mergedSettings(),
        ]);
    }

    public function updateProducts(Request $request)
    {
        $validated = $request->validate([
            'products_title' => ['required', 'string', 'max:220'],
            'products_subtitle' => ['required', 'string', 'max:600'],
            'products_categories' => ['required', 'json'],
            'products_items' => ['required', 'json'],
        ]);

        $categories = json_decode($validated['products_categories'], true);
        $items = json_decode($validated['products_items'], true);

        if (!is_array($categories) || !is_array($items)) {
            return redirect()->route('dashboard.products')->withErrors(['products_items' => 'Invalid products data format.']);
        }

        $normalizedCategories = [];
        $categorySlugs = [];

        foreach ($categories as $category) {
            if (!is_array($category)) {
                continue;
            }

            $name = trim((string) ($category['name'] ?? ''));
            if ($name === '') {
                continue;
            }

            $slugBase = trim((string) ($category['slug'] ?? ''));
            $slugBase = $slugBase !== '' ? $this->slugifyText($slugBase) : $this->slugifyText($name);
            $slug = $slugBase;
            $suffix = 2;

            while (isset($categorySlugs[$slug])) {
                $slug = $slugBase . '-' . $suffix;
                $suffix++;
            }

            $categorySlugs[$slug] = true;

            $normalizedCategories[] = [
                'name' => substr($name, 0, 80),
                'slug' => substr($slug, 0, 80),
                'description' => substr(trim((string) ($category['description'] ?? '')), 0, 200),
                'active' => !empty($category['active']),
            ];
        }

        if (count($normalizedCategories) === 0) {
            return redirect()->route('dashboard.products')->withErrors(['products_categories' => 'Please add at least one category.']);
        }

        $fallbackCategory = null;
        foreach ($normalizedCategories as $category) {
            if ($category['slug'] === 'other') {
                $fallbackCategory = $category['slug'];
                break;
            }
        }
        if ($fallbackCategory === null) {
            $fallbackCategory = $normalizedCategories[0]['slug'];
        }

        $normalizedProducts = [];
        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $logo = trim((string) ($item['logo'] ?? ''));
            $title = trim((string) ($item['title'] ?? ''));
            $details = trim((string) ($item['details'] ?? ''));
            $category = trim((string) ($item['category'] ?? $fallbackCategory));
            if (!isset($categorySlugs[$category])) {
                $category = $fallbackCategory;
            }

            $features = $this->normalizeStringList($item['features'] ?? []);
            $stack = $this->normalizeStringList($item['stack'] ?? []);
            $demoMessage = trim((string) ($item['demo_message'] ?? ''));

            if ($demoMessage === '') {
                $demoMessage = 'Book a demo for ' . $title;
            }

            if ($logo === '' || $title === '' || $details === '' || count($features) === 0 || count($stack) === 0) {
                continue;
            }

            $normalizedProducts[] = [
                'category' => $category,
                'logo' => substr($logo, 0, 20),
                'title' => substr($title, 0, 220),
                'details' => substr($details, 0, 1200),
                'features' => array_slice($features, 0, 8),
                'stack' => array_slice($stack, 0, 8),
                'demo_message' => substr($demoMessage, 0, 220),
                'active' => !empty($item['active']),
            ];
        }

        if (count($normalizedProducts) === 0) {
            return redirect()->route('dashboard.products')->withErrors(['products_items' => 'Please add at least one valid product.']);
        }

        $validated['products_categories'] = json_encode($normalizedCategories, JSON_UNESCAPED_UNICODE);
        $validated['products_items'] = json_encode($normalizedProducts, JSON_UNESCAPED_UNICODE);

        $this->persist($validated);

        return redirect()->route('dashboard.products')->with('status', 'Products section updated successfully.');
    }

    public function clients()
    {
        return view('dashboard.sections.clients', [
            'settings' => $this->mergedSettings(),
        ]);
    }

    public function updateClients(Request $request)
    {
        $validated = $request->validate([
            'clients_tag' => ['required', 'string', 'max:120'],
            'clients_title' => ['required', 'string', 'max:220'],
            'clients_items' => ['required', 'json'],
        ]);

        $items = json_decode($validated['clients_items'], true);
        if (!is_array($items)) {
            return redirect()->route('dashboard.clients')->withErrors(['clients_items' => 'Invalid client data format.']);
        }

        $normalizedClients = [];
        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $logo = trim((string) ($item['logo'] ?? ''));
            $name = trim((string) ($item['name'] ?? ''));
            $url = trim((string) ($item['url'] ?? ''));

            if ($name === '') {
                continue;
            }

            $normalizedClients[] = [
                'logo' => substr($logo, 0, 300),
                'name' => substr($name, 0, 120),
                'url' => substr($url, 0, 300),
                'active' => !empty($item['active']),
            ];
        }

        if (count($normalizedClients) === 0) {
            return redirect()->route('dashboard.clients')->withErrors(['clients_items' => 'Please add at least one client.']);
        }

        $validated['clients_items'] = json_encode($normalizedClients, JSON_UNESCAPED_UNICODE);

        $this->persist($validated);

        return redirect()->route('dashboard.clients')->with('status', 'Clients section updated successfully.');
    }

    public function uploadClientLogo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $path = $request->file('logo')->store('site-assets', 'public');

        return response()->json([
            'path' => '/storage/' . $path,
        ]);
    }

    public function blog()
    {
        return view('dashboard.sections.blog', [
            'settings' => $this->mergedSettings(),
        ]);
    }

    public function updateBlog(Request $request)
    {
        $validated = $request->validate([
            'blog_title' => ['required', 'string', 'max:220'],
            'blog_subtitle' => ['required', 'string', 'max:600'],
            'blog_categories' => ['required', 'json'],
            'blog_items' => ['required', 'json'],
        ]);

        $categories = json_decode($validated['blog_categories'], true);
        $items = json_decode($validated['blog_items'], true);

        if (!is_array($categories) || !is_array($items)) {
            return redirect()->route('dashboard.blog')->withErrors(['blog_items' => 'Invalid blog data format.']);
        }

        $normalizedCategories = [];
        $categorySlugs = [];

        foreach ($categories as $category) {
            if (!is_array($category)) {
                continue;
            }

            $name = trim((string) ($category['name'] ?? ''));
            if ($name === '') {
                continue;
            }

            $slugBase = trim((string) ($category['slug'] ?? ''));
            $slugBase = $slugBase !== '' ? $this->slugifyText($slugBase) : $this->slugifyText($name);
            $slug = $slugBase;
            $suffix = 2;

            while (isset($categorySlugs[$slug])) {
                $slug = $slugBase . '-' . $suffix;
                $suffix++;
            }

            $categorySlugs[$slug] = true;

            $normalizedCategories[] = [
                'name' => substr($name, 0, 80),
                'slug' => substr($slug, 0, 80),
                'description' => substr(trim((string) ($category['description'] ?? '')), 0, 200),
                'active' => !empty($category['active']),
            ];
        }

        if (count($normalizedCategories) === 0) {
            return redirect()->route('dashboard.blog')->withErrors(['blog_categories' => 'Please add at least one category.']);
        }

        $fallbackCategory = $normalizedCategories[0]['slug'];

        $normalizedItems = [];
        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $title = trim((string) ($item['title'] ?? ''));
            $image = trim((string) ($item['image'] ?? ''));
            $date = trim((string) ($item['date'] ?? ''));
            $details = trim((string) ($item['details'] ?? ''));
            $category = trim((string) ($item['category'] ?? $fallbackCategory));

            if (!isset($categorySlugs[$category])) {
                $category = $fallbackCategory;
            }

            if ($title === '' || $image === '' || $date === '' || $details === '') {
                continue;
            }

            $normalizedItems[] = [
                'category' => $category,
                'title' => substr($title, 0, 220),
                'image' => substr($image, 0, 300),
                'date' => substr($date, 0, 40),
                'details' => substr($details, 0, 2000),
                'active' => !empty($item['active']),
            ];
        }

        if (count($normalizedItems) === 0) {
            return redirect()->route('dashboard.blog')->withErrors(['blog_items' => 'Please add at least one blog post or case study.']);
        }

        $validated['blog_categories'] = json_encode($normalizedCategories, JSON_UNESCAPED_UNICODE);
        $validated['blog_items'] = json_encode($normalizedItems, JSON_UNESCAPED_UNICODE);

        $this->persist($validated);

        return redirect()->route('dashboard.blog')->with('status', 'Case Studies & Blog section updated successfully.');
    }

    public function uploadBlogImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $path = $request->file('image')->store('site-assets', 'public');

        return response()->json([
            'path' => '/storage/' . $path,
        ]);
    }

    public function updateContact(Request $request)
    {
        $validated = $request->validate([
            'contact_location' => ['required', 'string', 'max:190'],
            'contact_email' => ['required', 'email', 'max:190'],
            'contact_phone' => ['required', 'string', 'max:60'],
            'contact_hours' => ['required', 'string', 'max:120'],
            'whatsapp_link' => ['nullable', 'url', 'max:220'],
            'facebook_link' => ['nullable', 'url', 'max:220'],
            'linkedin_link' => ['nullable', 'url', 'max:220'],
        ]);

        $this->persist($validated);

        return redirect()->route('dashboard.contact')->with('status', 'Contact section updated successfully.');
    }

    public function stats()
    {
        return view('dashboard.sections.stats', [
            'settings' => $this->mergedSettings(),
        ]);
    }

    public function updateStats(Request $request)
    {
        $validated = $request->validate([
            'stat_projects' => ['required', 'string', 'max:30'],
            'stat_clients' => ['required', 'string', 'max:30'],
            'stat_products' => ['required', 'string', 'max:30'],
            'stat_rating' => ['required', 'string', 'max:30'],
        ]);

        $this->persist($validated);

        return redirect()->route('dashboard.stats')->with('status', 'Stats section updated successfully.');
    }

    public function footer()
    {
        return view('dashboard.sections.footer', [
            'settings' => $this->mergedSettings(),
        ]);
    }

    public function updateFooter(Request $request)
    {
        $validated = $request->validate([
            'footer_tagline' => ['required', 'string'],
            'footer_copyright' => ['required', 'string', 'max:220'],
            'privacy_policy' => ['required', 'string', 'max:4000'],
            'terms_of_service' => ['required', 'string', 'max:4000'],
        ]);

        $this->persist($validated);

        return redirect()->route('dashboard.footer')->with('status', 'Footer section updated successfully.');
    }

    public function leads()
    {
        $leads = Lead::query()->latest()->paginate(20);

        return view('dashboard.leads', [
            'leads' => $leads,
        ]);
    }
}
