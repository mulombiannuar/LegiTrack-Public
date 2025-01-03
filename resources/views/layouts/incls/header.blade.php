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
                                 <a class="nav-link" href="#">About Us</a>
                             </li>
                             <li class="nav-item dropdown dropdown-slide">
                                 <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                     aria-haspopup="true" aria-expanded="false">
                                     Media <span><i class="fa fa-angle-down"></i></span>
                                 </a>
                                 <ul class="dropdown-menu">
                                     <li><a class="dropdown-item" href="#">News</a></li>
                                     <li><a class="dropdown-item" href="#">Downloads</a></li>
                                 </ul>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" href="#">Public Feedbacks</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" href="#">Contact Us</a>
                             </li>
                         </ul>
                         <ul class="navbar-nav ml-auto mt-10">
                             <li class="nav-item">
                                 <a class="nav-link login-button" href="login.html">Login</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link text-white add-button" href="#"><i
                                         class="fa fa-plus-circle"></i> Register</a>
                             </li>
                         </ul>
                     </div>
                 </nav>
             </div>
         </div>
     </div>
 </header>
