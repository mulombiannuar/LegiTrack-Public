<div class="category-sidebar">

    {{-- Bill Types --}}
    <div class="widget category-list">
        <h4 class="widget-header">All Bill Types</h4>
        <ul class="category-list">
            @foreach ($bill_types as $bill_type)
                @if ($bill_type['count'] > 0)
                    <li>
                        <a href="javascript:void(0);" onclick="filterBills('pending reviews', this)">
                            {{ ucwords($bill_type['name']) }} <span>
                                ({{ $bill_type['count'] }})
                            </span></a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    {{-- Sponsorship Types --}}
    <div class="widget product-shorting">
        <h4 class="widget-header">By Sponsorship Types</h4>
        @foreach ($sponsorship_types as $sponsorship_type)
            @if ($sponsorship_type['count'] > 0)
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="{{ $sponsorship_type['id'] }}" />
                        {{ ucwords($sponsorship_type['name']) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>
</div>
