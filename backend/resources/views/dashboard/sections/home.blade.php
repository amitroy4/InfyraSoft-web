@extends('dashboard.layout')

@section('title', 'Home Section')
@section('subtitle', 'Edit homepage hero copy and messaging.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head">
            <h2>Hero Content</h2>
            <p>This content appears in the top hero section of the landing page.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.home.update') }}">
            @csrf

            <div class="field">
                <label for="hero_subtitle">Hero Subtitle</label>
                <textarea id="hero_subtitle" name="hero_subtitle" required>{{ old('hero_subtitle', $settings['hero_subtitle']) }}</textarea>
            </div>

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Home Section</button>
            </div>
        </form>
    </div>
@endsection
