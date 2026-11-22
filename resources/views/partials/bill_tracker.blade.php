{{-- A Bill's journey through Parliament: each milestone with its House, state and date. --}}
@php
    $stateText = ['done' => 'Done', 'current' => 'In progress', 'next' => 'Next', 'stopped' => 'Stopped here', 'upcoming' => 'To come'];
    $stateIcon = ['done' => 'fa-check', 'current' => 'fa-circle', 'next' => 'fa-arrow-right', 'stopped' => 'fa-times', 'upcoming' => 'fa-circle-o'];
@endphp
@if (empty($tracker))
    <p class="text-muted">The Bill's progress will appear here once it is published.</p>
@else
    <ol class="bill-tracker">
        @foreach ($tracker as $step)
            <li class="tracker-step tracker-{{ $step['state'] }}">
                <span class="tracker-dot" aria-hidden="true"><i class="fa {{ $stateIcon[$step['state']] ?? 'fa-circle-o' }}"></i></span>
                <div class="tracker-body">
                    <div class="tracker-title">{{ $step['label'] }} <span class="tracker-state">{{ $stateText[$step['state']] ?? '' }}</span></div>
                    <div class="tracker-meta">{{ collect([
                        $step['house'],
                        $step['state'] !== 'upcoming' ? $step['outcome'] : null,
                        $step['date'] ? \Illuminate\Support\Carbon::parse($step['date'])->format('j M Y') : null,
                    ])->filter()->implode(' · ') }}</div>
                </div>
            </li>
        @endforeach
    </ol>
@endif
