@extends('layouts.main')

@section('content')
    @include('app.pages.partials.page_title')
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-5 pt-lg-0">
                    <div class="about-content">
                        <h3 class="font-weight-bold">About Legitrack</h3>
                        <p>Welcome to Legitrack, a cutting-edge legislative tracking and feedback system designed to enhance
                            transparency, collaboration, and public engagement in the legislative process. Legitrack is
                            tailored to serve both internal users within the parliamentary system and the public, ensuring
                            that every voice matters in the journey of lawmaking.</p>
                        <h3 class="font-weight-bold">Our Mission</h3>
                        <p>
                            At Legitrack, our mission is to streamline legislative processes, foster accountability, and
                            create a platform that bridges the gap between lawmakers and citizens. By leveraging innovative
                            technology, we aim to simplify access to legislative information and encourage meaningful
                            participation in governance.
                        </p>
                        <h3 class="font-weight-bold">What We Do</h3>
                        <ol class="list-group list-group-numbered">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="font-weight-bold">Comprehensive Bill Management</div>
                                    Track, review, and manage bills at every stage, from drafting to enactment.
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="font-weight-bold">Public Participation Portal</div>
                                    Engage citizens to review, comment, and provide feedback on bills, ensuring inclusivity
                                    in lawmaking.
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="font-weight-bold">Committee Collaboration</div>
                                    Facilitate seamless interactions within parliamentary committees, with access to meeting
                                    schedules, reports, and bills under discussion.
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="font-weight-bold">Real-Time Notifications</div>
                                    Keep users informed with timely updates on legislative activities and decisions.
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="font-weight-bold">Advanced Search and Insights</div>
                                    Enable easy access to bills, news, and publications through powerful search and
                                    categorization tools.
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6 my-lg-0 my-3">
                    <div class="counter-content text-center bg-light py-4 rounded">
                        <i class="fa fa-smile-o d-block"></i>
                        <span class="counter my-2 d-block" data-count="{{ $stats['published_bills'] }}">0</span>
                        <h5>Bills Published</h5>
                        </script>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 my-lg-0 my-3">
                    <div class="counter-content text-center bg-light py-4 rounded">
                        <i class="fa fa-user-o d-block"></i>
                        <span class="counter my-2 d-block" data-count="{{ $stats['active_contributors'] }}">0</span>
                        <h5>Active Contributors</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 my-lg-0 my-3">
                    <div class="counter-content text-center bg-light py-4 rounded">
                        <i class="fa fa-bookmark-o d-block"></i>
                        <span class="counter my-2 d-block" data-count="{{ $stats['feedbacks_count'] }}">0</span>
                        <h5>Reviews & Feedbacks</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 my-lg-0 my-3">
                    <div class="counter-content text-center bg-light py-4 rounded">
                        <i class="fa fa-smile-o d-block"></i>
                        <span class="counter my-2 d-block" data-count="{{ $stats['all_contributors'] }}">0</span>
                        <h5>Registered Contributors</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
