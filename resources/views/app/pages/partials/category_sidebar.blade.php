<div class="category-sidebar">

    {{-- Bill Types --}}
    <div class="widget category-list">
        <h4 class="widget-header">All Bill Types</h4>
        <ul class="category-list">
            @foreach ($bill_types as $bill_type)
                @if ($bill_type['count'] > 0)
                    <li>
                        <a href="javascript:void(0);" onclick="filterBills('bill-type', {{ $bill_type['id'] }})">
                            {{ ucwords($bill_type['name']) }} <span>
                                ({{ $bill_type['count'] }})
                            </span></a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    {{-- Sponsorship Types --}}
    <div class="widget category-list">
        <h4 class="widget-header">By Sponsorship Types</h4>
        <ul class="category-list">
            @foreach ($sponsorship_types as $sponsorship_type)
                @if ($sponsorship_type['count'] > 0)
                    <li>
                        <a href="javascript:void(0);"
                            onclick="filterBills('sponsorship-type', {{ $sponsorship_type['id'] }})">
                            {{ ucwords($sponsorship_type['name']) }} <span>
                                ({{ $sponsorship_type['count'] }})
                            </span></a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
