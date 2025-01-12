 {{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script> --}}
 <script src="{{ asset('lib/js/libs/jquery.min.js') }}" type="text/javascript"></script>
 <script src="{{ asset('plugins/bootstrap/popper.min.js') }}"></script>
 <script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
 <script src="{{ asset('plugins/bootstrap/bootstrap-slider.js') }}"></script>
 <script src="{{ asset('plugins/tether/js/tether.min.js') }}"></script>
 <script src="{{ asset('plugins/raty/jquery.raty-fa.js') }}"></script>
 <script src="{{ asset('plugins/slick/slick.min.js') }}"></script>
 <script src="{{ asset('plugins/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
 <script src="{{ asset('js/script.js') }}"></script>
 <script>
     document.addEventListener('DOMContentLoaded', function() {

         const form = document.querySelector('form');
         const button = document.querySelector('.disable-button');

         if (button) {
             form.addEventListener('submit', function(event) {
                 button.disabled = true;
                 button.innerHTML = 'Please wait...';
             });
         }
     });
 </script>
 @stack('scripts')
