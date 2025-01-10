 <select id="sub_county_id" name="sub_county_id" class="form-control w-100 mb-3">
     @if (count($sub_counties) > 0)
         <option class="mb-1" value="">Select Sub County</option>
         @foreach ($sub_counties as $sub_county)
             <option value="{{ $sub_county['id'] }}">{{ ucwords($sub_county['name']) }}</option>
         @endforeach
     @else
         <option class="mb-1" value="">No Sub Counties Found</option>
     @endif
 </select>
