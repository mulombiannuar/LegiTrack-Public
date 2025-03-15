@push('styles')
    <style>
        .step {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .step .circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }

        .step-header {
            display: flex;
            align-items: center;
        }

        .step.completed .circle {
            background-color: #28a745;
        }

        .step.completed .label {
            color: #28a745;
        }

        .step.active .circle {
            background-color: #888;
        }

        .step.active .label {
            font-weight: bold;
        }

        .step .line {
            height: 40px;
            width: 2px;
            background-color: #e0e0e0;
            margin: 0 auto;
        }

        .step .description {
            font-size: 0.875rem;
            color: #6c757d;
            margin-left: 40px;
            margin-top: 5px;
        }

        .product-table tr th {
            padding-left: 25px;
        }
      
    </style>
@endpush
@extends('layouts.main')

@section('content')
    <section class="section bg-gray">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    @php
                        $billAttributes = $bill['attributes'];
                        $billRelationships = $bill['relationships'];

                        $id = $bill['id'];
                        $slug = $billAttributes['slug'];
                        $subject = $billAttributes['subject'];
                        $billTypeId = $billAttributes['bill_type_id'];
                        $parliamentaryTermId = $billAttributes['parliamentary_term_id'];
                        $parliamentaryTerm = $billAttributes['parliamentary_term'];
                        $billTitle = ucwords($billAttributes['title']);
                        $description = $billAttributes['description'];
                        $publishedBillNumber = 'Bill No.' . $billAttributes['published_bill_number'];
                        $sponsor = $billRelationships['sponsor'];
                        $billType = ucwords($billRelationships['bill_type']);
                        $submissionDate = $billAttributes['submission_date'];
                        $billActivities = $billRelationships['bill_activities'];
                        $sponsorshipType = $billRelationships['sponsorship_type'];
                        $billStageOutcome = $billRelationships['bill_stage_outcome'];
                        $billStageName = $billAttributes['bill_stage_name'];
                        $updatedDate = $billAttributes['updated_at'];
                        $parliamentarySession = $billRelationships['parliamentary_session'];
                    @endphp
                    <div class="product-details">
                        <h1 class="product-title">{{ $billTitle }} | {{ $publishedBillNumber }}</h1>
                        <div class="product-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item"><i class="fa fa-calendar"></i> Submitted On: <a
                                        href="javascript:void(0);">{{ format_date($submissionDate, 'd F Y h:i a') }}</a>
                                </li>
                                <li class="list-inline-item"><i class="fa fa-folder-open-o"></i> Type: <a
                                        href="javascript:void(0);">
                                        {{ $billType }}</a></li>
                                <li class="list-inline-item"><i class="fa fa-calendar-plus-o"></i> Session: <a
                                        href="javascript:void(0);">{{ $parliamentaryTerm . ' - ' . $parliamentarySession }}</a>
                                </li>
                                <li class="list-inline-item"><i class="fa fa-calendar-plus-o"></i> Current Stage: <a
                                        href="javascript:void(0);">{{ $billStageName }}</a></li>
                                <li class="list-inline-item"><i class="fa fa-user"></i> Bill Sponsor: <a
                                        href="javascript:void(0);">{{ $sponsor }}</a></li>
                                <li class="list-inline-item"><i class="fa fa-address-book"></i> Sponsorship Type: <a
                                        href="javascript:void(0);">{{ $sponsorshipType }}</a></li>
                            </ul>
                        </div>

                        <div class="content mt-1">
                            <ul class="nav nav-pills" id="bill-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="bill-home-tab" data-toggle="pill" href="#bill-home"
                                        role="tab" aria-controls="bill-home" aria-selected="true">Bill Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="bill-passage-tab" data-toggle="pill" href="#bill-passage"
                                        role="tab" aria-controls="bill-passage" aria-selected="false">Bill Passage</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="bill-sponsor-tab" data-toggle="pill" href="#bill-sponsor"
                                        role="tab" aria-controls="bill-sponsor" aria-selected="false">Bill Sponsor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="bill-versions-tab" data-toggle="pill" href="#bill-versions"
                                        role="tab" aria-controls="bill-versions" aria-selected="false">Bill Versions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="bill-review-tab" data-toggle="pill" href="#bill-review"
                                        role="tab" aria-controls="bill-review" aria-selected="false">Feedback &
                                        Review</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="bill-publications-tab" data-toggle="pill"
                                        href="#bill-publications" role="tab" aria-controls="bill-publications"
                                        aria-selected="false">News & Publications</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="bill-tabContent">

                                {{-- Bill Information --}}
                                <div class="tab-pane fade show active" id="bill-home" role="tabpanel"
                                    aria-labelledby="bill-home-tab">
                                    <h3 class="tab-title">Bill Subject</h3>
                                    <p>{{ $subject }}</p>

                                    <h3 class="tab-title">Bill Description</h3>
                                    {!! $description !!}

                                    <ul class="list-inline mt-2 product-meta">
                                        <li class="list-inline-item"
                                            style="color: #000; font-size: 12px; font-style: italic;">
                                            <i class="fa fa-clock-o"></i> Last updated
                                            {{ format_date($updatedDate, 'd F Y h:i a') }}
                                        </li>
                                    </ul>
                                </div>

                                {{-- Bill Passage --}}
                                <div class="tab-pane fade" id="bill-passage" role="tabpanel"
                                    aria-labelledby="bill-passage-tab">
                                    <h3 class="tab-title">Bill Stages Passage</h3>
                                    <div class="container">
                                        <div class="d-flex flex-column align-items-start">
                                            @foreach ($bill_completed_stages as $stage)
                                                <div class="step {{ $stage['is_completed'] ? 'completed' : 'active' }}">
                                                    <div class="step-header">
                                                        <div class="circle"><i
                                                                class="fa {{ $stage['is_completed'] ? 'fa-check' : 'fa-minus' }} "></i>
                                                        </div>
                                                        <div class="label">{{ ucwords($stage['name']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="line"></div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Bill Sponsor --}}
                                <div class="tab-pane fade" id="bill-sponsor" role="tabpanel"
                                    aria-labelledby="bill-sponsor-tab">
                                    <h3 class="tab-title">Bill Sponsor</h3>
                                    <div class="widget user text-center">
                                        <img width="300px;" class="rounded-circle img-fluid mb-4 px-5"
                                            src="{{ $bill_sponsor['profile_image'] }}"
                                            alt="{{ ucwords($bill_sponsor['full_name']) }}">
                                        <h4><a href="#">{{ ucwords($bill_sponsor['full_name']) }}</a></h4>
                                        @if ($user_positions)
                                            <p class="member-time p-150">{{ $user_positions }}</p>
                                        @endif
                                        <ul class="list-inline mt-20">
                                            <li class="list-inline-item"><a
                                                    href="{{ route('sponsor-bills', ['sponsor_id' => $bill_sponsor['id']]) }}"
                                                    class="btn btn-contact d-inline-block  btn-primary px-lg-5 my-1 px-md-3">View
                                                    All Bills Sponsored</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Bill Versions --}}
                                <div class="tab-pane fade" id="bill-versions" role="tabpanel"
                                    aria-labelledby="bill-versions-tab">
                                    <h3 class="tab-title">Bill Versions ({{ count($bill_versions) }})</h3>
                                    @if ($bill_versions)
                                        <table class="table table-sm table-bordered table-hover product-table">
                                            <thead>
                                                <tr>
                                                    <th>S.N</th>
                                                    <th>Version</th>
                                                    <th>During Stage</th>
                                                    <th>Date Created</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bill_versions as $bill_version)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <a title="Click to view this bill version"
                                                                href="{{ route('bill-version', $bill_version['id']) }}">
                                                                V{{ $bill_version['version_number'] }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $bill_version['bill_stage_name'] }} Stage</td>
                                                        <td>{{ format_date($bill_version['created_at'], 'd M. Y h:i A') }}
                                                        </td>
                                                        <td>
                                                            <a title="Click to view this bill version"
                                                                href="{{ route('bill-version', $bill_version['id']) }}"
                                                                class="btn btn-sm btn-main-sm"><i
                                                                    class="fa fa-sign-in"></i>
                                                                View Version</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="row p-lg-3 p-sm-5 p-4 justify-content-center">
                                            <div class="w-100 alert alert-warning font-weight-bold">
                                                No bills versions are available for "{{ $billTitle }}". Please check
                                                back
                                                later
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Bill Feedback & Review --}}
                                <div class="tab-pane fade" id="bill-review" role="tabpanel"
                                    aria-labelledby="bill-review-tab">
                                    @auth
                                        @if (count($bill_feedbacks) > 0)
                                            <h3 class="tab-title">Bill Feedback & Review ({{ count($bill_feedbacks) }}) </h3>
                                        @endif
                                        <div class="product-review">
                                            @if (count($bill_feedbacks) > 0)
                                                @foreach ($bill_feedbacks as $feedback)
                                                    <!-- BEGIN : Feedback -->
                                                    <div class="media">
                                                        <img src="{{ asset('images/user/user-thumb.png') }}" alt="avater">
                                                        <div class="media-body">
                                                            <div class="name">
                                                                <h5>{{ ucwords($feedback['full_name']) }} |
                                                                    {{ $feedback['tracking_number'] }}</h5>
                                                            </div>
                                                            <div class="date">
                                                                <p>{{ format_date($feedback['created_at'], 'd F Y h:i a') }}
                                                                </p>
                                                            </div>
                                                            <div class="review-comment">
                                                                <p>{{ $feedback['content'] }}</p>
                                                            </div>

                                                            {{-- Replies  --}}
                                                            @if (count($feedback['replies']) > 0)
                                                                <hr>
                                                                <div class="ml-3">
                                                                    <div class="name">
                                                                        <h5 class="italic">Replies
                                                                            ({{ count($feedback['replies']) }})
                                                                        </h5>
                                                                    </div>
                                                                    <div class="review-comment">
                                                                        @foreach ($feedback['replies'] as $reply)
                                                                            <p style="font-style: italic">
                                                                                <strong>[{{ format_date($reply['created_at']) }}]</strong>
                                                                                {{ $reply['content'] }}
                                                                            </p>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- BEGIN : Feedback -->
                                                @endforeach
                                            @endif
                                            <div class="review-submission">
                                                <h3 class="tab-title">
                                                    {{ count($bill_feedbacks) > 0 ? 'Submit another Review' : 'Submit your Review' }}
                                                </h3>
                                                <div class="review-submit">
                                                    <form action="{{ route('submit-bill-feedback') }}" method="POST"
                                                        class="row">
                                                        @csrf
                                                        <input type="hidden" name="bill_id" value="{{ $bill['id'] }}">
                                                        <div class="col-lg-6 mb-3">
                                                            <select name="feedback_type" id="feedback_type"
                                                                class="w-100 form-control mt-lg-1 mt-md-2" required>
                                                                <option class="mb-1" value="">
                                                                    -- Select Type Below --</option>
                                                                <option value="1">Bill Review</option>
                                                                <option value="0">Bill Feedback</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <select name="bill_support" id="bill_support"
                                                                class="w-100 form-control mt-lg-1 mt-md-2" required>
                                                                <option value="1">I Support</option>
                                                                <option value="0">I do not support</option>
                                                                <option value="2">Other (specify below)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <textarea name="content" id="content" rows="6" class="form-control"
                                                                placeholder="Please provide your detailed feedback/review or suggestions regarding this bill" required></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-main disable-button">Submit
                                                                Message</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row p-lg-3 p-sm-5 p-4 justify-content-center">
                                            <h3 class="tab-title">Submit Bill Feedback & Review </h3>
                                            <div class="w-100 alert alert-warning font-weight-bold">
                                                You can only submit a review/feedback for this bill to Parliament for
                                                consideration once you are
                                                logged in. Please click the button below to log in. If you don't have an
                                                account, you will need to register.
                                            </div>
                                            <a class="nav-link login-button"
                                                href="{{ route('login', ['next' => request()->path()]) }}"><i
                                                    class="fa fa-sign-in"></i> Login</a>
                                            <a class="nav-link text-white add-button"
                                                href="{{ route('register', ['next' => request()->path()]) }}"><i
                                                    class="fa fa-user-plus"></i> Register</a>
                                        </div>
                                    @endauth
                                </div>

                                {{-- Bill Publications --}}
                                <div class="tab-pane fade" id="bill-publications" role="tabpanel"
                                    aria-labelledby="bill-publications-tab">
                                    <h3 class="tab-title">Bill News & Publications (0)</h3>
                                    <div class="product-review">
                                        <div class="media">

                                            <!-- Loading block  -->
                                            @include('layouts.incls.loading')

                                            <!-- bill listing block  -->
                                            <div id="publications-listing-block"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container End -->
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            fetchPublications(1);

            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();

                const url = $(this).attr('href');

                if (url) {
                    const page = new URL(url).searchParams.get(
                        'page');
                    fetchPublications(page);
                }
            });
        });

        function fetchPublications(page) {
            const remoteBaseUrl = "{{ config('app.remote_base_url') }}";
            const $publicationListing = $('#publications-listing-block');
            const $loading = $('#loading');

            $.ajax({
                url: `${remoteBaseUrl}/api/get-bill-publications`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    bill_id: {{ $id }},
                    paginate: 5,
                    page: page,
                    with_html: true
                },
                beforeSend: function() {
                    $loading.show();
                    $publicationListing.hide();
                },
                success: function(response) {
                    console.log('Response:', response);
                    if (response.status && response.data.html) {
                        $publicationListing.html(response.data.html);
                    } else {
                        console.error('Error: Invalid response format.');
                    }
                },
                complete: function() {
                    $loading.hide();
                    $publicationListing.show();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching bill publications:', xhr.responseJSON?.errors || error);
                }
            });
        }
    </script>
@endpush
