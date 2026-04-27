@extends('dashboard.layout')

@section('title', 'Our Clients')
@section('subtitle', 'Manage heading text shown in the clients section.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head">
            <h2>Clients Section</h2>
            <p>Update the label and title used in the frontend clients section.</p>
        </div>

        <form method="POST" action="{{ route('dashboard.clients.update') }}">
            @csrf

            <div class="field">
                <label for="clients_tag">Section Label</label>
                <input id="clients_tag" name="clients_tag" value="{{ old('clients_tag', $settings['clients_tag']) }}" required>
            </div>

            <div class="field">
                <label for="clients_title">Section Title</label>
                <input id="clients_title" name="clients_title" value="{{ old('clients_title', $settings['clients_title']) }}" required>
            </div>

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Clients Section</button>
            </div>
        </form>
    </div>
@endsection
