{{-- The committee's call for memoranda on this Bill (Constitution Art. 118). --}}
@if (! empty($participation))
    @php
        $pStatus = $participation['status'] ?? 'closed';
        $pDays = (int) ($participation['days_left'] ?? 0);
        $pClose = \Illuminate\Support\Carbon::parse($participation['closes_on'])->format('j F Y');
        $pOpen = \Illuminate\Support\Carbon::parse($participation['opens_on'])->format('j F Y');
    @endphp
    <div class="participation-banner participation-{{ $pStatus }} mb-4" role="status">
        <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap:10px">
            <div>
                <div class="participation-kicker">
                    @if ($pStatus === 'open')
                        <i class="fa fa-bullhorn"></i> Open for public comment
                    @elseif ($pStatus === 'upcoming')
                        <i class="fa fa-calendar"></i> Public comment opens {{ $pOpen }}
                    @else
                        <i class="fa fa-lock"></i> Public comment closed
                    @endif
                </div>
                <div class="participation-title">{{ $participation['title'] }}</div>
                <div class="participation-meta">
                    @if ($participation['committee'])By the {{ $participation['committee'] }} · @endif
                    {{ $pOpen }} to {{ $pClose }}
                    @if ($participation['advert_reference']) · {{ $participation['advert_reference'] }}@endif
                </div>
            </div>
            @if ($pStatus === 'open')
                <div class="participation-countdown">
                    <strong>{{ $pDays === 0 ? 'Last day' : $pDays }}</strong>
                    <span>{{ $pDays === 0 ? 'closes today' : ($pDays === 1 ? 'day left' : 'days left') }}</span>
                </div>
            @endif
        </div>
        @if (! empty($participation['notice']))
            <p class="participation-notice mb-0 mt-2">{{ $participation['notice'] }}</p>
        @endif
        @if ($pStatus === 'open')
            <a href="#make-a-submission" class="btn btn-main btn-sm mt-3">Make a submission</a>
        @endif
    </div>
@endif
