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
            <p>This content appears in the top hero section and menu on the landing page.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.home.update') }}">
            @csrf

            <div class="grid">
                <div class="field">
                    <label for="hero_badge_text">Hero Badge</label>
                    <input id="hero_badge_text" name="hero_badge_text" value="{{ old('hero_badge_text', $settings['hero_badge_text']) }}" required>
                </div>

                <div class="field">
                    <label for="hero_primary_button_text">Primary Button Text</label>
                    <input id="hero_primary_button_text" name="hero_primary_button_text" value="{{ old('hero_primary_button_text', $settings['hero_primary_button_text']) }}" required>
                </div>

                <div class="field">
                    <label for="hero_secondary_button_text">Secondary Button Text</label>
                    <input id="hero_secondary_button_text" name="hero_secondary_button_text" value="{{ old('hero_secondary_button_text', $settings['hero_secondary_button_text']) }}" required>
                </div>
            </div>

            <div class="field">
                <label for="hero_subtitle">Hero Subtitle</label>
                <textarea id="hero_subtitle" name="hero_subtitle" required>{{ old('hero_subtitle', $settings['hero_subtitle']) }}</textarea>
            </div>

            <div class="field">
                <label for="hero_type_words">Hero Type Words</label>
                <textarea id="hero_type_words" name="hero_type_words" required placeholder="Web Applications&#10;SaaS Platforms&#10;ERP Systems">{{ old('hero_type_words', $settings['hero_type_words']) }}</textarea>
                <p class="hint">Use one line per animated word.</p>
            </div>

            <div class="field">
                <label for="hero_menu_items">Hero Menu Items</label>
                <textarea id="hero_menu_items" name="hero_menu_items" required placeholder="Home&#10;About&#10;Services&#10;Products&#10;Portfolio&#10;Contact">{{ old('hero_menu_items', $settings['hero_menu_items']) }}</textarea>
                <p class="hint">Use one line per menu label in the same order as the landing page navigation.</p>
            </div>

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Home Section</button>
            </div>
        </form>
    </div>
@endsection
