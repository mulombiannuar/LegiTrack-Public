 <select id="parliamentary_term_id" name="parliamentary_term_id" class="w-100 form-control mt-lg-1 mt-md-2">
     @if (count($parliamentary_terms) > 0)
         <option class="mb-1" value="">Select Parliamentary Term</option>
         @foreach ($parliamentary_terms as $term)
             <option value="{{ $term['id'] }}">{{ ucwords($term['name']) }}</option>
         @endforeach
     @else
         <option class="mb-1" value="">No Parliamentary Terms Found</option>
     @endif
 </select>
