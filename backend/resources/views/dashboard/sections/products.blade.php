@extends('dashboard.layout')

@section('title', 'Ready-Made Software Products')
@section('subtitle', 'Manage section heading and subheading shown in the products area.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head">
            <h2>Products Section</h2>
            <p>Update the title and subtitle used in the frontend products section.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.products.update') }}">
            @csrf

            <div class="field">
                <label for="products_title">Section Title</label>
                <input id="products_title" name="products_title" value="{{ old('products_title', $settings['products_title']) }}" required>
            </div>

            <div class="field">
                <label for="products_subtitle">Section Subtitle</label>
                <textarea id="products_subtitle" name="products_subtitle" required>{{ old('products_subtitle', $settings['products_subtitle']) }}</textarea>
            </div>

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Products Section</button>
            </div>
        </form>
    </div>
@endsection
