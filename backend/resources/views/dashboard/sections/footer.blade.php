@extends('dashboard.layout')

@section('title', 'Footer Section')
@section('subtitle', 'Manage footer text and legal line.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head">
            <h2>Footer Content</h2>
            <p>Update footer tagline, legal labels, and copyright text.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.footer.update') }}">
            @csrf

            <div class="field">
                <label for="footer_tagline">Footer Tagline</label>
                <textarea id="footer_tagline" name="footer_tagline" required>{{ old('footer_tagline', $settings['footer_tagline']) }}</textarea>
            </div>

            <div class="field">
                <label for="footer_copyright">Footer Copyright</label>
                <input id="footer_copyright" name="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright']) }}" required>
            </div>

            <div class="field">
                <label for="privacy_policy">Privacy Policy</label>
                <textarea id="privacy_policy" name="privacy_policy" required>{{ old('privacy_policy', $settings['privacy_policy']) }}</textarea>
            </div>

            <div class="field">
                <label for="terms_of_service">Terms of Service</label>
                <textarea id="terms_of_service" name="terms_of_service" required>{{ old('terms_of_service', $settings['terms_of_service']) }}</textarea>
            </div>

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Footer Section</button>
            </div>
        </form>
    </div>
@endsection
