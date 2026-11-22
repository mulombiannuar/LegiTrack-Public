@extends('layouts.main')

@section('content')
    @php
        $statusLabels = ['before_parliament' => 'Before Parliament', 'passed' => 'Passed by Parliament', 'became_law' => 'Became law', 'did_not_proceed' => 'Did not proceed'];
        $categoryLabels = ['ordinary' => 'Ordinary Bills', 'money' => 'Money Bills', 'county' => 'Bills concerning counties', 'constitutional' => 'Constitutional amendments'];
        $counts = $meta['status_counts'] ?? [];
        $total = array_sum($counts);
        $active = $filters['status'] ?? (! empty($filters['open']) ? 'open' : 'all');
        $base = array_diff_key($filters, ['status' => 1, 'open' => 1]);
        $tabs = ['all' => ['All Bills', $total, $base], 'open' => ['Open for comment', $meta['open_for_comment'] ?? 0, $base + ['open' => 1]]];
        foreach ($statusLabels as $key => $label) {
            $tabs[$key] = [$label, $counts[$key] ?? 0, $base + ['status' => $key]];
        }
        $hasFilters = count($filters) > 0;
        $page = (int) ($meta['page'] ?? 1);
        $daysLeft = fn (string $date): int => max(0, (int) now()->startOfDay()->diffInDays(\Illuminate\Support\Carbon::parse($date), false));
    @endphp

    <section class="bills-hero">
        <div class="container">
            <h1>Bills in the Parliament of Kenya</h1>
            <p>Follow every Bill published in the Kenya Gazette: where it is, what it does, and when you can have your say.</p>
            <form method="GET" action="{{ route('search') }}" class="bills-search" role="search">
                @foreach (array_diff_key($filters, ['q' => 1]) as $name => $value)
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                @endforeach
                <label for="q" class="sr-only">Search Bills</label>
                <input type="search" id="q" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search by title, subject or Bill number, e.g. Health" autocomplete="off">
                <button type="submit" class="btn btn-main"><i class="fa fa-search"></i> Search</button>
            </form>
        </div>
    </section>

    <section class="section-sm bills-list-section">
        <div class="container">
            <nav class="bills-tabs" aria-label="Bills by status">
                @foreach ($tabs as $key => [$label, $count, $query])
                    <a href="{{ route('search', $query) }}" class="{{ $active === $key ? 'active' : '' }} {{ $key === 'open' ? 'tab-open' : '' }}" @if ($active === $key) aria-current="page" @endif>
                        {{ $label }} <span class="count">{{ $count }}</span>
                    </a>
                @endforeach
            </nav>

            <form method="GET" action="{{ route('search') }}" class="bills-filters">
                @foreach (array_intersect_key($filters, ['q' => 1, 'status' => 1, 'open' => 1]) as $name => $value)
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                @endforeach
                <label class="sr-only" for="house">House</label>
                <select name="house" id="house" onchange="this.form.submit()">
                    <option value="">Both Houses</option>
                    @foreach ($house_categories as $houseId => $houseName)
                        <option value="{{ $houseId }}" @selected((int) ($filters['house'] ?? 0) === $houseId)>{{ $houseName }}</option>
                    @endforeach
                </select>
                <label class="sr-only" for="category">Kind of Bill</label>
                <select name="category" id="category" onchange="this.form.submit()">
                    <option value="">All kinds of Bills</option>
                    @foreach ($categoryLabels as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['category'] ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <label class="sr-only" for="sort">Sort</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="recent" @selected(($filters['sort'] ?? 'recent') === 'recent')>Recently updated</option>
                    <option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>Oldest first</option>
                    <option value="title" @selected(($filters['sort'] ?? '') === 'title')>Title A-Z</option>
                </select>
                <noscript><button class="btn btn-sm btn-main">Apply</button></noscript>
                <span class="flex-grow"></span>
                @if ($hasFilters)<a href="{{ route('search') }}" class="clear-link">Clear filters</a>@endif
                <a href="{{ route('bills.export', $filters) }}" class="download-link"><i class="fa fa-download"></i> Download data (CSV)</a>
            </form>

            <p class="bills-count" aria-live="polite">
                {{ number_format($meta['total'] ?? 0) }} {{ ($meta['total'] ?? 0) === 1 ? 'Bill' : 'Bills' }}@if (! empty($filters['q'])) matching “{{ $filters['q'] }}”@endif
            </p>

            @forelse ($bills as $bill)
                <article class="bill-card">
                    <div class="bill-card-badges">
                        <span class="status-badge status-{{ $bill['status'] }}">{{ $bill['status_label'] }}</span>
                        @if (! empty($bill['open_for_comment_until']))
                            <span class="status-badge status-open"><i class="fa fa-bullhorn"></i> Open for comment · {{ $daysLeft($bill['open_for_comment_until']) === 0 ? 'closes today' : $daysLeft($bill['open_for_comment_until']).' '.($daysLeft($bill['open_for_comment_until']) === 1 ? 'day' : 'days').' left' }}</span>
                        @endif
                    </div>
                    <h2><a href="{{ route('get-bill-details', $bill['slug']) }}">{{ ucwords($bill['title']) }}</a></h2>
                    <div class="bill-card-meta">
                        {{ $bill['number'] }} · {{ $bill['house'] }}@if ($bill['category'] !== 'ordinary') · {{ $bill['category_label'] }}@endif
                    </div>
                    @if ($bill['excerpt'])<p class="bill-card-excerpt">{{ $bill['excerpt'] }}</p>@endif
                    <dl class="bill-card-facts">
                        <div><dt>Stage</dt><dd>{{ $bill['latest_outcome'] ?? $bill['stage'] ?? '—' }}</dd></div>
                        @if ($bill['sponsor'])<div><dt>Sponsor</dt><dd>{{ $bill['sponsor'] }}</dd></div>@endif
                        @if ($bill['gazette_published_at'])<div><dt>Published</dt><dd>{{ \Illuminate\Support\Carbon::parse($bill['gazette_published_at'])->format('j M Y') }}</dd></div>@endif
                    </dl>
                </article>
            @empty
                <div class="bills-empty">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    @if ($hasFilters)
                        <h2>No Bills match these filters</h2>
                        <p>Try different words or fewer filters.</p>
                        <a href="{{ route('search') }}" class="btn btn-main">Show all Bills</a>
                    @else
                        <h2>No Bills have been published yet</h2>
                        <p>Bills appear here as soon as they are published in the Kenya Gazette.</p>
                    @endif
                </div>
            @endforelse

            @if (($meta['last_page'] ?? 1) > 1)
                <nav class="bills-pagination" aria-label="Pages of Bills">
                    @if ($page > 1)<a href="{{ route('search', $filters + ['page' => $page - 1]) }}" rel="prev">&laquo; Previous</a>@endif
                    <span>Page {{ $page }} of {{ $meta['last_page'] }}</span>
                    @if ($page < $meta['last_page'])<a href="{{ route('search', $filters + ['page' => $page + 1]) }}" rel="next">Next &raquo;</a>@endif
                </nav>
            @endif
        </div>
    </section>
@endsection
