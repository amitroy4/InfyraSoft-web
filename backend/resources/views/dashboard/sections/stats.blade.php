@extends('dashboard.layout')

@section('title', 'Stats Section')
@section('subtitle', 'Control highlighted performance numbers.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head">
            <h2>Website Stats</h2>
            <p>These values appear as counters and badges on the homepage.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.stats.update') }}">
            @csrf

            <div class="grid">
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

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Stats Section</button>
            </div>
        </form>
    </div>
@endsection
