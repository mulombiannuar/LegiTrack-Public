 <header>
     <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <nav class="navbar navbar-expand-lg navbar-light navigation">
                     <a class="navbar-brand" href="{{ route('home') }}">
                         <img src="{{ asset('images/Parliament-Logo-Kenya.png') }}" alt="Kenya Logo">
                     </a>
                     <button class="navbar-toggler" type="button" data-toggle="collapse"
                         data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                         aria-expanded="false" aria-label="Toggle navigation">
                         <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse" id="navbarSupportedContent">
                         <ul class="navbar-nav ml-auto main-nav ">
                             <li class="nav-item active">
                                 <a class="nav-link" href="{{ route('home') }}">Home</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" href="{{ route('about-us') }}">About Us</a>
                             </li>
                             <li class="nav-item dropdown dropdown-slide">
                                 <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                     aria-haspopup="true" aria-expanded="false">
                                     Media <span><i class="fa fa-angle-down"></i></span>
                                 </a>
                                 <ul class="dropdown-menu">
                                     <li><a class="dropdown-item" href="{{ route('media') }}">News & Publications</a>
                                     </li>
                                     <li><a class="dropdown-item" href="{{ route('downloads') }}">Downloads</a></li>
                                 </ul>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" href="#">Public Feedbacks</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" href="{{ route('contact-us') }}">Contact Us</a>
                             </li>
                         </ul>
                         <ul class="navbar-nav ml-auto mt-10">
                             @auth
                                 <li class="nav-item">
                                     <a class="nav-link text-white red-button" href="{{ route('logout') }}"
                                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                             class="fa fa-sign-out"></i> Logout</a>
                                 </li>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                     style="display: none;">
                                     @csrf
                                 </form>
                             @else
                                 <li class="nav-item">
                                     <a class="nav-link login-button"
                                         href="{{ route('login', ['next' => request()->path()]) }}"><i
                                             class="fa fa-sign-in"></i> Login</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link text-white add-button"
                                         href="{{ route('register', ['next' => request()->path()]) }}"><i
                                             class="fa fa-user-plus"></i> Register</a>
                                 </li>
                             @endauth
                         </ul>
                     </div>
                 </nav>
             </div>
         </div>
     </div>
 </header>
