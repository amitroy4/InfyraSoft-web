@extends('dashboard.layout')

@section('title', 'Branding')
@section('subtitle', 'Update site title and upload the footer logo.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head">
            <h2>Brand Identity</h2>
            <p>These settings control how your brand appears on the landing page.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.branding.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid">
                <div class="field">
                    <label for="site_title">Site Title</label>
                    <input id="site_title" name="site_title" value="{{ old('site_title', $settings['site_title']) }}" required>
                </div>

                <div class="field">
                    <label for="footer_logo_upload">Footer Logo</label>
                    <input id="footer_logo_upload" name="footer_logo_upload" type="file" accept="image/*">
                    <p class="hint">Accepted: JPG, JPEG, PNG, WEBP, SVG (max 2MB).</p>
                    <img id="footer_logo_preview" alt="Footer logo preview" class="preview-img" style="display:none; margin-top:8px;">
                </div>

                <div class="field">
                    <label for="site_favicon_upload">Favicon</label>
                    <input id="site_favicon_upload" name="site_favicon_upload" type="file" accept=".ico,image/png,image/svg+xml,image/webp">
                    <p class="hint">Accepted: ICO, PNG, SVG, WEBP (max 1MB).</p>
                    <img id="site_favicon_preview" alt="Favicon preview" class="preview-img" style="display:none; margin-top:8px; max-height:40px;">
                </div>

                <div class="field">
                    <label for="contact_phone">Phone Number</label>
                    <input id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" required>
                </div>

                <div class="field">
                    <label for="contact_email">Email</label>
                    <input id="contact_email" name="contact_email" type="email" value="{{ old('contact_email', $settings['contact_email']) }}" required>
                </div>

                <div class="field">
                    <label for="contact_location">Location</label>
                    <input id="contact_location" name="contact_location" value="{{ old('contact_location', $settings['contact_location']) }}" required>
                </div>

                <div class="field">
                    <label for="contact_hours">Working Time</label>
                    <input id="contact_hours" name="contact_hours" value="{{ old('contact_hours', $settings['contact_hours']) }}" required>
                </div>

                <div class="field">
                    <label for="whatsapp_link">WhatsApp Link</label>
                    <input id="whatsapp_link" name="whatsapp_link" value="{{ old('whatsapp_link', $settings['whatsapp_link']) }}" placeholder="https://wa.me/8801XXXXXXXXX">
                </div>

                <div class="field">
                    <label for="facebook_link">Facebook Link</label>
                    <input id="facebook_link" name="facebook_link" value="{{ old('facebook_link', $settings['facebook_link']) }}" placeholder="https://facebook.com/your-page">
                </div>

                <div class="field">
                    <label for="linkedin_link">LinkedIn Link</label>
                    <input id="linkedin_link" name="linkedin_link" value="{{ old('linkedin_link', $settings['linkedin_link']) }}" placeholder="https://linkedin.com/company/your-company">
                </div>
            </div>

            @if (!empty($settings['footer_logo']))
                <div class="field">
                    <label>Current Logo</label>
                    <img src="{{ $settings['footer_logo'] }}" alt="Current footer logo" class="preview-img">
                </div>
            @endif

            @if (!empty($settings['site_favicon']))
                <div class="field">
                    <label>Current Favicon</label>
                    <img src="{{ $settings['site_favicon'] }}" alt="Current favicon" class="preview-img">
                </div>
            @endif

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Branding</button>
            </div>
        </form>
    </div>

    <script>
        (function () {
            function bindPreview(inputId, previewId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                if (!input || !preview) return;

                input.addEventListener('change', function () {
                    const file = input.files && input.files[0] ? input.files[0] : null;
                    if (!file) {
                        preview.removeAttribute('src');
                        preview.style.display = 'none';
                        return;
                    }

                    const objectUrl = URL.createObjectURL(file);
                    preview.src = objectUrl;
                    preview.style.display = 'block';
                });
            }

            bindPreview('footer_logo_upload', 'footer_logo_preview');
            bindPreview('site_favicon_upload', 'site_favicon_preview');
        })();
    </script>
@endsection
