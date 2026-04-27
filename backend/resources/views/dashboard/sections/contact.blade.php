@extends('dashboard.layout')

@section('title', 'Contact Section')
@section('subtitle', 'Maintain contact details used on the frontend.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head">
            <h2>Contact Details</h2>
            <p>Update location, email, phone, and working hours.</p>
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
            </div>

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Contact Section</button>
            </div>
        </form>
    </div>
@endsection
