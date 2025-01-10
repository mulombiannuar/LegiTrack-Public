 <select id="ward_id" name="ward_id" class="form-control w-100 mb-3" required>
     @if (count($wards) > 0)
         <option class="mb-1" value="">Select Ward</option>
         @foreach ($wards as $ward)
             <option value="{{ $ward['id'] }}">{{ ucwords($ward['name']) }}</option>
         @endforeach
     @else
         <option class="mb-1" value="">No Wards Found</option>
     @endif
 </select>
