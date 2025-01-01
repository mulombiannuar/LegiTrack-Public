<div id="bills-container">
    @foreach ($bills['data'] as $bill)
        @php
            $billAttributes = $bill['attributes'];
            $billRelationships = $bill['relationships'];

            $slug = $billAttributes['slug'];
            $subject = $billAttributes['subject'];
            $billTypeId = $billAttributes['bill_type_id'];
            $parliamentaryTermId = $billAttributes['parliamentary_term_id'];
            $parliamentaryTerm = $billAttributes['parliamentary_term'];
            $title = ucwords($billAttributes['title']);
            $description = $billAttributes['description'];
            $billStageId = $billAttributes['bill_stage_id'];
            $billStageName = $billAttributes['bill_stage_name'];
            $publishedBillNumber = 'Bill No.' . $billAttributes['published_bill_number'];
            $billType = ucwords($billRelationships['bill_type']);
            $submissionDate = $billAttributes['submission_date'];
            $parliamentarySession = $billRelationships['parliamentary_session'];
        @endphp

        <div class="ad-listing-list mt-20">
            <div class="row p-lg-3 p-sm-5 p-4">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-10 col-sm-12">
                            <div class="ad-listing-content">
                                <div>
                                    <a href="{{ route('get-bill-details', ['slug' => $slug]) }}"
                                        class="font-weight-bold ad-listing-title">{{ $title }}</a>
                                </div>
                                <ul class="list-inline mt-2 mb-3 product-meta">
                                    <li class="list-inline-item">
                                        <a href="{{ route('home', ['bill_type_id' => $billTypeId]) }}">
                                            <i class="fa fa-folder-open-o"></i>
                                            {{ $billType }}</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a
                                            href="{{ route('home', ['parliamentary_term_id' => $parliamentaryTermId]) }}">
                                            <i class="fa fa-calendar-plus-o"></i>
                                            {{ $parliamentaryTerm }} - {{ $parliamentarySession }}</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#"><i class="fa fa-calendar"></i>
                                            {{ format_date($submissionDate, 'd F Y h:i a') }}
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="{{ route('home', ['bill_stage_id' => $billStageId]) }}"><i
                                                class="fa fa-address-book-o"></i>
                                            {{ $billStageName }}</a>
                                    </li>
                                </ul>
                                <p class="pr-5">{{ $subject }}</p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12 align-self-center">
                            <div class="product-ratings float-lg-right pb-3">
                                <a href="{{ route('get-bill-details', ['slug' => $slug]) }}" class="btn btn-main-sm"><i
                                        class="fa fa-sign-in"></i>
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Pagination Links -->
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
</div>
