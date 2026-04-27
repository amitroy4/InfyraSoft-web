@extends('dashboard.layout')

@section('title', 'Case Studies & Blog')
@section('subtitle', 'Manage heading and summary for the blog section.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head">
            <h2>Case Studies & Blog Section</h2>
            <p>Update the title and subtitle used in the frontend blog section.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.blog.update') }}">
            @csrf

            <div class="field">
                <label for="blog_title">Section Title</label>
                <input id="blog_title" name="blog_title" value="{{ old('blog_title', $settings['blog_title']) }}" required>
            </div>

            <div class="field">
                <label for="blog_subtitle">Section Subtitle</label>
                <textarea id="blog_subtitle" name="blog_subtitle" required>{{ old('blog_subtitle', $settings['blog_subtitle']) }}</textarea>
            </div>

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Blog Section</button>
            </div>
        </form>
    </div>
@endsection
