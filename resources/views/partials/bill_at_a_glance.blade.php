{{-- Where a published Bill stands, in plain terms. --}}
@if (! empty($public))
    @php
        $glanceDeadlines = collect($public['deadlines'] ?? [])->filter(fn ($d) => in_array($d['status'], ['open', 'due_soon', 'overdue', 'waiting'], true) && $d['label'] !== 'Public participation closes');
    @endphp
    <div class="bill-glance mb-4">
        <div class="bill-glance-head">
            <span class="status-badge status-{{ $public['status'] }}">{{ $public['status_label'] }}</span>
            <span class="bill-glance-number">{{ $public['number'] }}</span>
        </div>
        @if (! empty($public['plain_summary']))
            <h2 class="bill-glance-heading">What this Bill does</h2>
            <p class="bill-glance-summary">{{ $public['plain_summary'] }}</p>
        @endif
        <dl class="bill-glance-facts">
            <div><dt>House</dt><dd>{{ $public['house'] }}</dd></div>
            <div><dt>Kind of Bill</dt><dd>{{ $public['category_label'] }}</dd></div>
            <div><dt>Current stage</dt><dd>{{ $public['latest_outcome'] ?? $public['stage'] ?? '—' }}</dd></div>
            @if ($public['sponsor'])<div><dt>Sponsor</dt><dd>{{ $public['sponsor'] }}</dd></div>@endif
            @if ($public['gazette_published_at'])
                <div><dt>Kenya Gazette</dt><dd>{{ $public['gazette_supplement_number'] ? 'Supplement No. '.$public['gazette_supplement_number'].', ' : '' }}{{ \Illuminate\Support\Carbon::parse($public['gazette_published_at'])->format('j M Y') }}</dd></div>
            @endif
        </dl>
        @foreach ($glanceDeadlines as $deadline)
            <div class="bill-glance-deadline">
                <i class="fa fa-clock-o"></i>
                {{ $deadline['label'] }}: {{ $deadline['kind'] === 'not_before' ? 'not before' : 'by' }} {{ \Illuminate\Support\Carbon::parse($deadline['due_on'])->format('j M Y') }}
                <span class="text-muted">({{ $deadline['legal_basis'] }})</span>
            </div>
        @endforeach
        @if (! empty($public['versions']))
            <div class="bill-glance-downloads">
                <strong>Read the Bill:</strong>
                @foreach ($public['versions'] as $version)
                    <a href="{{ $version['pdf_url'] }}" target="_blank" rel="noopener"><i class="fa fa-file-pdf-o"></i> Version {{ $version['number'] }} ({{ \Illuminate\Support\Carbon::parse($version['date'])->format('j M Y') }})</a>
                @endforeach
            </div>
        @endif
    </div>
@endif
