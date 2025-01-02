 <div class="advance-search">
     <div class="container">
         <div class="row justify-content-center">
             <div class="col-lg-12 col-md-12 align-content-center">
                 <form method="get" action="{{ route('search') }}">
                     @csrf
                     <div class="form-row">
                         <div class="form-group col-xl-4 col-lg-3 col-md-6">
                             <input type="text" name="search" class="form-control my-2 my-lg-1" id="search"
                                 placeholder="Enter Bill Title or Subject" autocomplete="on">
                         </div>
                         <div class="form-group col-xl-4 col-lg-3 col-md-6">
                             <select name="house_category_id" id="house_category_id"
                                 class="w-100 form-control mt-lg-1 mt-md-2">
                                 <option class="mb-1" value="">Select Originating House</option>
                                 <option value="1">National Assembly</option>
                                 <option value="0">Senate</option>
                             </select>
                         </div>
                         <div class="form-group col-xl-4 col-lg-3 col-md-6" id="parliamentary_term_block">
                             <select id="parliamentary_term_id" name="parliamentary_term_id"
                                 class="w-100 form-control mt-lg-1 mt-md-2">
                                 <option class="mb-1" value="">Select House First</option>
                             </select>
                         </div>
                         <div class="form-group col-xl-4 col-lg-3 col-md-6" id="parliamentary_session_block">
                             <select name="parliamentary_session_id" id="parliamentary_session_id"
                                 class="w-100 form-control mt-lg-1 mt-md-2">
                                 <option class="mb-1" value="">Select Parliamentary Session
                                 </option>
                             </select>
                         </div>
                         <div class="form-group col-xl-4 col-lg-3 col-md-6">
                             <select name="bill_type_id" id="bill_type_id" class="w-100 form-control mt-lg-1 mt-md-2">
                                 <option class="mb-1" value="">Select Bill Type </option>
                                 @foreach ($bill_types as $bill_type)
                                     @if ($bill_type['count'] > 0)
                                         <option value="{{ $bill_type['id'] }}">
                                             {{ ucwords($bill_type['name']) }}
                                             ({{ $bill_type['count'] }})
                                         </option>
                                     @endif
                                 @endforeach
                             </select>
                         </div>
                         <div class="form-group col-xl-4 col-lg-3 col-md-6">
                             <select name="bill_stage_id" id="bill_stage_id" class="w-100 form-control mt-lg-1 mt-md-2">
                                 <option class="mb-1" value="">
                                     Select Bill Stage </option>
                                 @foreach ($bill_stages as $bill_stage)
                                     <option value="{{ $bill_stage['id'] }}">
                                         {{ ucwords($bill_stage['name']) }}</option>
                                 @endforeach
                             </select>
                         </div>
                         <div class="form-group col-xl-4 col-lg-3 col-md-6">
                             <select name="sponsorship_type_id" id="sponsorship_type_id"
                                 class="w-100 form-control mt-lg-1 mt-md-2">
                                 <option class="mb-1" value="">
                                     Select Sponsorship Type </option>
                                 @foreach ($sponsorship_types as $sponsorship_type)
                                     @if ($sponsorship_type['count'] > 0)
                                         <option value="{{ $sponsorship_type['id'] }}">
                                             {{ ucwords($sponsorship_type['name']) }}
                                             ({{ $sponsorship_type['count'] }})
                                         </option>
                                     @endif
                                 @endforeach
                             </select>
                         </div>
                         <div class="form-group col-xl-4 col-lg-3 col-md-6">
                             <select name="sponsor_id" id="sponsor_id" class="w-100 form-control mt-lg-1 mt-md-2">
                                 <option class="mb-1" value="">
                                     Select Sponsoring Member </option>
                                 @foreach ($bill_sponsors as $bill_sponsor)
                                     <option value="{{ $bill_sponsor['id'] }}">
                                         {{ ucwords($bill_sponsor['profile']['full_name']) }}
                                         ({{ $bill_sponsor['bills_count'] }})
                                     </option>
                                 @endforeach
                             </select>
                         </div>
                         <div class="form-group col-xl-4 col-lg-3 col-md-6 align-self-center">
                             <button type="submit" class="btn btn-success active w-100">Search Bills
                                 Now</button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
