<div class="pagination justify-content-center py-4">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            @foreach ($bills['links'] as $link)
                @if ($loop->first)
                    <!-- Previous link -->
                    <li class="page-item {{ !$link['url'] ? 'disabled' : '' }}">
                        <a class="page-link pagination-link" href="javascript:void(0);"
                            data-url="{{ $link['url'] ?? '#' }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                @elseif ($loop->last)
                    <!-- Next link -->
                    <li class="page-item {{ !$link['url'] ? 'disabled' : '' }}">
                        <a class="page-link pagination-link" href="javascript:void(0);"
                            data-url="{{ $link['url'] ?? '#' }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                @else
                    <!-- Page numbers -->
                    <li class="page-item {{ $link['active'] ? 'active' : '' }}">
                        <a class="page-link pagination-link" href="javascript:void(0);"
                            data-url="{{ $link['url'] ?? '#' }}">
                            {!! $link['label'] !!}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>
</div>
