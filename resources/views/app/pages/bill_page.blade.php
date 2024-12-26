@extends('layouts.main')

@section('content')
    <section class="section bg-gray">
        <!-- Container Start -->
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-sm-12">
                    <div class="product-details">
                        <h1 class="product-title">Data Privacy and Protection Act, 2024</h1>
                        <div class="product-meta">
                            <ul class="list-inline">
                                <li class="list-inline-item"><i class="fa fa-calendar"></i> Published On: <a
                                        href="#">12th February, 2024</a></li>
                                <li class="list-inline-item"><i class="fa fa-folder-open-o"></i> Type: <a
                                        href="#">Data
                                        Privacy Bill</a></li>
                                <li class="list-inline-item"><i class="fa fa-calendar-plus-o"></i> Session: <a
                                        href="#">13th Parliament S2</a></li>
                                <li class="list-inline-item"><i class="fa fa-calendar-plus-o"></i> Current Stage: <a
                                        href="#">1st Reading</a></li>
                                <li class="list-inline-item"><i class="fa fa-calendar-plus-o"></i> Next Stage: <a
                                        href="#">2nd Reading</a></li>
                                <li class="list-inline-item"><i class="fa fa-user"></i> Sponsorship: <a
                                        href="#">Government Bill</a></li>
                            </ul>
                        </div>

                        <div class="content mt-1">
                            <ul class="nav nav-pills justify-content-center" id="bill-tab" role="tablist">
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
                                        aria-selected="false">Publications</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="bill-tabContent">
                                <div class="tab-pane fade show active" id="bill-home" role="tabpanel"
                                    aria-labelledby="bill-home-tab">
                                    <h3 class="tab-title">Bill Subject</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia laudantium beatae
                                        quod perspiciatis, neque
                                    </p>

                                    <h3 class="tab-title">Bill Description</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia laudantium beatae
                                        quod perspiciatis, neque
                                        dolores eos rerum, ipsa iste cum culpa numquam amet provident eveniet pariatur, sunt
                                        repellendus quas
                                        voluptate dolor cumque autem molestias. Ab quod quaerat molestias culpa eius,
                                        perferendis facere vitae commodi
                                        maxime qui numquam ex voluptatem voluptate, fuga sequi, quasi! Accusantium eligendi
                                        vitae unde iure officia
                                        amet molestiae velit assumenda, quidem beatae explicabo dolore laboriosam mollitia
                                        quod eos, eaque voluptas
                                        enim fuga laborum, error provident labore nesciunt ad. Libero reiciendis
                                        necessitatibus voluptates ab
                                        excepturi rem non, nostrum aut aperiam? Itaque, aut. Quas nulla perferendis neque
                                        eveniet ullam?</p>
                                </div>
                                <div class="tab-pane fade" id="bill-passage" role="tabpanel"
                                    aria-labelledby="bill-passage-tab">
                                    <h3 class="tab-title">Product Specifications</h3>
                                    <table class="table table-bordered product-table">
                                        <tbody>
                                            <tr>
                                                <td>Seller Price</td>
                                                <td>$450</td>
                                            </tr>
                                            <tr>
                                                <td>Added</td>
                                                <td>26th December</td>
                                            </tr>
                                            <tr>
                                                <td>State</td>
                                                <td>Dhaka</td>
                                            </tr>
                                            <tr>
                                                <td>Brand</td>
                                                <td>Apple</td>
                                            </tr>
                                            <tr>
                                                <td>Condition</td>
                                                <td>Used</td>
                                            </tr>
                                            <tr>
                                                <td>Model</td>
                                                <td>2017</td>
                                            </tr>
                                            <tr>
                                                <td>State</td>
                                                <td>Dhaka</td>
                                            </tr>
                                            <tr>
                                                <td>Battery Life</td>
                                                <td>23</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="bill-sponsor" role="tabpanel"
                                    aria-labelledby="bill-sponsor-tab">
                                    <h3 class="tab-title">Bill Sponsor</h3>
                                    <div class="widget user text-center">
                                        <img width="250px;" class="rounded-circle img-fluid mb-5 px-5"
                                            src="images/user/user-thumb.jpg" alt="">
                                        <h4><a href="#">Hon. Kimani Ichungwa, HSC</a></h4>
                                        <p class="member-time">Chairperson, Budget And Appropriations Committee</p>
                                        <a href="#">View All Bills Sponsored</a>
                                        <ul class="list-inline mt-20">
                                            <li class="list-inline-item"><a href="#"
                                                    class="btn btn-contact d-inline-block  btn-primary px-lg-5 my-1 px-md-3">Contact</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="bill-versions" role="tabpanel"
                                    aria-labelledby="bill-versions-tab">
                                    <h3 class="tab-title">Bill Versions (3)</h3>
                                    <table class="table table-sm table-bordered table-hover product-table">
                                        <thead>
                                            <tr>
                                                <th class="align-content-center">S.N</th>
                                                <th>Version</th>
                                                <th>During Stage</th>
                                                <th>Date Created</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <a href="#">
                                                        V1
                                                    </a>
                                                </td>
                                                <td>Bill Publishing Stage</td>
                                                <td>2024-09-20 10:44:21</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-main-sm"><i
                                                            class="fa fa-sign-in"></i>
                                                        View Version</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="bill-review" role="tabpanel"
                                    aria-labelledby="bill-review-tab">
                                    <h3 class="tab-title">Bill Feedback & Review</h3>
                                    <div class="product-review">
                                        <div class="media">
                                            <!-- Avater -->
                                            <img src="images/user/user-thumb.jpg" alt="avater">
                                            <div class="media-body">
                                                <div class="name">
                                                    <h5>Jessica Brown</h5>
                                                </div>
                                                <div class="date">
                                                    <p>Mar 20, 2018</p>
                                                </div>
                                                <div class="review-comment">
                                                    <p>
                                                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                                                        accusantium doloremqe laudant tota rem ape
                                                        riamipsa eaque.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="review-submission">
                                            <h3 class="tab-title">Submit your review</h3>
                                            <div class="review-submit">
                                                <form action="#" method="POST" class="row">
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
                                                        <select name="feedback_type" id="feedback_type"
                                                            class="w-100 form-control mt-lg-1 mt-md-2">
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
                                                        <button type="submit" class="btn btn-main">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="bill-publications" role="tabpanel"
                                    aria-labelledby="bill-publications-tab">
                                    <h3 class="tab-title">Bill Publications</h3>
                                    <div class="product-review">
                                        <div class="media">
                                            <div class="media-body">
                                                <div class="name">
                                                    <h5>Jessica Brown</h5>
                                                </div>
                                                <div class="date">
                                                    <p>Mar 20, 2018</p>
                                                </div>
                                                <div class="review-comment">
                                                    <p>
                                                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                                                        accusantium doloremqe laudant tota rem ape
                                                        riamipsa eaque.
                                                    </p>
                                                </div>
                                            </div>
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
