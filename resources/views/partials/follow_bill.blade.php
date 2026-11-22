{{-- Follow a Bill for email updates when it moves or opens for public comment. --}}
@if ($slug)
    <div class="follow-bill mb-4">
        <div>
            <strong><i class="fa fa-bell-o"></i> Get updates on this Bill</strong>
            <div class="small text-muted">We email you when it moves to a new stage or opens for public comment.
                @if (($follow['followers'] ?? 0) > 0) {{ number_format($follow['followers']) }} {{ $follow['followers'] === 1 ? 'person follows' : 'people follow' }} this Bill.@endif
            </div>
        </div>
        @auth
            @if ($follow['following'])
                <form method="POST" action="{{ route('bill.unfollow', $slug) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-secondary btn-sm"><i class="fa fa-check"></i> Following · Stop</button>
                </form>
            @else
                <form method="POST" action="{{ route('bill.follow', $slug) }}">
                    @csrf
                    <button type="submit" class="btn btn-main btn-sm"><i class="fa fa-bell"></i> Follow this Bill</button>
                </form>
            @endif
        @else
            <a href="{{ route('login', ['next' => request()->path()]) }}" class="btn btn-main btn-sm"><i class="fa fa-sign-in"></i> Sign in to follow</a>
        @endauth
    </div>
@endif
