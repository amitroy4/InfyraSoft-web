@extends('dashboard.layout')

@section('title', 'Website Content')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="/dashboard">
            @csrf

            <div class="grid">
                <div class="field">
                    <label for="site_title">Site Title</label>
                    <input id="site_title" name="site_title" value="{{ old('site_title', $settings['site_title']) }}" required>
                </div>
                <div class="field">
                    <label for="contact_email">Contact Email</label>
                    <input id="contact_email" name="contact_email" type="email" value="{{ old('contact_email', $settings['contact_email']) }}" required>
                </div>

                <div class="field">
                    <label for="contact_location">Contact Location</label>
                    <input id="contact_location" name="contact_location" value="{{ old('contact_location', $settings['contact_location']) }}" required>
                </div>
                <div class="field">
                    <label for="contact_phone">Contact Phone</label>
                    <input id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" required>
                </div>

                <div class="field">
                    <label for="contact_hours">Working Hours</label>
                    <input id="contact_hours" name="contact_hours" value="{{ old('contact_hours', $settings['contact_hours']) }}" required>
                </div>
                <div class="field">
                    <label for="footer_copyright">Footer Copyright</label>
                    <input id="footer_copyright" name="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright']) }}" required>
                </div>

                <div class="field">
                    <label for="stat_projects">Projects Stat</label>
                    <input id="stat_projects" name="stat_projects" value="{{ old('stat_projects', $settings['stat_projects']) }}" required>
                </div>
                <div class="field">
                    <label for="stat_clients">Clients Stat</label>
                    <input id="stat_clients" name="stat_clients" value="{{ old('stat_clients', $settings['stat_clients']) }}" required>
                </div>

                <div class="field">
                    <label for="stat_products">Products Stat</label>
                    <input id="stat_products" name="stat_products" value="{{ old('stat_products', $settings['stat_products']) }}" required>
                </div>
                <div class="field">
                    <label for="stat_rating">Rating Stat</label>
                    <input id="stat_rating" name="stat_rating" value="{{ old('stat_rating', $settings['stat_rating']) }}" required>
                </div>
            </div>

            <div class="field">
                <label for="hero_subtitle">Hero Subtitle</label>
                <textarea id="hero_subtitle" name="hero_subtitle" required>{{ old('hero_subtitle', $settings['hero_subtitle']) }}</textarea>
            </div>

            <div class="field">
                <label for="about_paragraph_1">About Paragraph 1</label>
                <textarea id="about_paragraph_1" name="about_paragraph_1" required>{{ old('about_paragraph_1', $settings['about_paragraph_1']) }}</textarea>
            </div>

            <div class="field">
                <label for="about_paragraph_2">About Paragraph 2</label>
                <textarea id="about_paragraph_2" name="about_paragraph_2" required>{{ old('about_paragraph_2', $settings['about_paragraph_2']) }}</textarea>
            </div>

            <div class="field">
                <label for="footer_tagline">Footer Tagline</label>
                <textarea id="footer_tagline" name="footer_tagline" required>{{ old('footer_tagline', $settings['footer_tagline']) }}</textarea>
            </div>

            <button class="btn-primary" type="submit">Save Changes</button>
        </form>
    </div>
@endsection
