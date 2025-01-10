 <select id="parliamentary_session_id" name="parliamentary_session_id" class="w-100 form-control mt-lg-1 mt-md-2" required>
     @if (count($parliamentary_sessions) > 0)
         <option class="mb-1" value="">Select Session</option>
         @foreach ($parliamentary_sessions as $session)
             <option value="{{ $session['id'] }}">{{ ucwords($session['name']) }}</option>
         @endforeach
     @else
         <option class="mb-1" value="">No Sessions Found</option>
     @endif
 </select>
