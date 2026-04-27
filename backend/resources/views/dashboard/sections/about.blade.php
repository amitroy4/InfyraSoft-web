@extends('dashboard.layout')

@section('title', 'About Section')
@section('subtitle', 'Edit company description and about copy.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head">
            <h2>About Content</h2>
            <p>These paragraphs are shown in the About section on the landing page.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.about.update') }}">
            @csrf

            <div class="field">
                <label for="about_title">About Title</label>
                <input id="about_title" name="about_title" value="{{ old('about_title', $settings['about_title']) }}" required>
            </div>

            <div class="field">
                <label for="about_paragraph_1">About Paragraph 1</label>
                <textarea id="about_paragraph_1" name="about_paragraph_1" required>{{ old('about_paragraph_1', $settings['about_paragraph_1']) }}</textarea>
            </div>

            <div class="field">
                <label for="about_paragraph_2">About Paragraph 2</label>
                <textarea id="about_paragraph_2" name="about_paragraph_2" required>{{ old('about_paragraph_2', $settings['about_paragraph_2']) }}</textarea>
            </div>

            <div class="grid">
                <div class="field">
                    <label for="about_point_1">Point 1</label>
                    <input id="about_point_1" name="about_point_1" value="{{ old('about_point_1', $settings['about_point_1']) }}" required>
                </div>
                <div class="field">
                    <label for="about_point_2">Point 2</label>
                    <input id="about_point_2" name="about_point_2" value="{{ old('about_point_2', $settings['about_point_2']) }}" required>
                </div>
                <div class="field">
                    <label for="about_point_3">Point 3</label>
                    <input id="about_point_3" name="about_point_3" value="{{ old('about_point_3', $settings['about_point_3']) }}" required>
                </div>
                <div class="field">
                    <label for="about_point_4">Point 4</label>
                    <input id="about_point_4" name="about_point_4" value="{{ old('about_point_4', $settings['about_point_4']) }}" required>
                </div>
                <div class="field">
                    <label for="about_button_text">Button Text</label>
                    <input id="about_button_text" name="about_button_text" value="{{ old('about_button_text', $settings['about_button_text']) }}" required>
                </div>
                <div class="field">
                    <label for="about_button_link">Button Link</label>
                    <input id="about_button_link" name="about_button_link" value="{{ old('about_button_link', $settings['about_button_link']) }}" placeholder="https://example.com or /about">
                </div>
            </div>

            <div class="field">
                <label for="about_button_active_toggle">Button Active</label>
                <div class="toggle-row">
                    <input type="hidden" name="about_button_active" value="0">
                    <label class="switch" for="about_button_active_toggle">
                        <input id="about_button_active_toggle" type="checkbox" name="about_button_active" value="1" {{ old('about_button_active', $settings['about_button_active']) == '1' ? 'checked' : '' }}>
                        <span class="switch-slider"></span>
                    </label>
                    <span class="toggle-state" id="about_button_active_state">{{ old('about_button_active', $settings['about_button_active']) == '1' ? 'Enabled' : 'Disabled' }}</span>
                </div>
            </div>

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save About Section</button>
            </div>
        </form>
    </div>

    <script>
        (function () {
            const toggle = document.getElementById('about_button_active_toggle');
            const state = document.getElementById('about_button_active_state');
            if (!toggle || !state) return;

            function refreshState() {
                state.textContent = toggle.checked ? 'Enabled' : 'Disabled';
            }

            toggle.addEventListener('change', refreshState);
            refreshState();
        })();
    </script>
@endsection
