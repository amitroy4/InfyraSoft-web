@extends('dashboard.layout')

@section('title', 'Contact Section')
@section('subtitle', 'Maintain contact details used on the frontend.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div style="border:1px solid #fecaca; background:#fef2f2; color:#b91c1c; border-radius:10px; padding:12px 14px; margin-bottom:16px; font-weight:600;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="panel-head">
            <h2>Contact Details</h2>
            <p>Update location, email, phone, working hours, and the social links used on the frontend.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.contact.update') }}">
            @csrf

            <div class="grid">
                <div class="field">
                    <label for="contact_email">Contact Email</label>
                    <input id="contact_email" name="contact_email" type="email" value="{{ old('contact_email', $settings['contact_email']) }}" required>
                </div>

                <div class="field">
                    <label for="contact_phone">Contact Phone</label>
                    <input id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" required>
                </div>

                <div class="field">
                    <label for="contact_location">Contact Location</label>
                    <input id="contact_location" name="contact_location" value="{{ old('contact_location', $settings['contact_location']) }}" required>
                </div>

                <div class="field">
                    <label for="contact_hours">Working Hours</label>
                    <input id="contact_hours" name="contact_hours" value="{{ old('contact_hours', $settings['contact_hours']) }}" required>
                </div>

                <div class="field">
                    <label for="whatsapp_link">WhatsApp Link</label>
                    <input id="whatsapp_link" name="whatsapp_link" type="url" value="{{ old('whatsapp_link', $settings['whatsapp_link'] ?? '') }}" placeholder="https://wa.me/8801XXXXXXXXX">
                    <p class="hint">Used for the WhatsApp button on the frontend.</p>
                </div>

                <div class="field">
                    <label for="facebook_link">Facebook Link</label>
                    <input id="facebook_link" name="facebook_link" type="url" value="{{ old('facebook_link', $settings['facebook_link'] ?? '') }}" placeholder="https://facebook.com/yourpage">
                </div>

                <div class="field">
                    <label for="linkedin_link">LinkedIn Link</label>
                    <input id="linkedin_link" name="linkedin_link" type="url" value="{{ old('linkedin_link', $settings['linkedin_link'] ?? '') }}" placeholder="https://linkedin.com/company/yourcompany">
                </div>
            </div>

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Contact Section</button>
            </div>
        </form>
    </div>
@endsection
