@extends('dashboard.layout')

@section('title', 'Lead Inbox')

@section('content')
    <div class="panel">
        <p class="muted">Latest inquiries submitted from your landing page contact form.</p>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Service</th>
                    <th>Budget</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($leads as $lead)
                    <tr>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->phone ?: '-' }}</td>
                        <td>{{ $lead->service ?: '-' }}</td>
                        <td>{{ $lead->budget ?: '-' }}</td>
                        <td>{{ $lead->message }}</td>
                        <td>{{ $lead->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="muted">No leads received yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:14px;">
            {{ $leads->links() }}
        </div>
    </div>
@endsection
