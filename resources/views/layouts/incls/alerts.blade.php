 @if ($errors->any())
     <div class="container-fluid mt-3">
         <div class="alert alert-danger alert-dismissible">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <h4><i class="icon fa fa-exclamation-circle"></i> Form Validation Failed with
                 Error{{ count($errors->all()) > 1 ? 's' : '' }}</h4>
             <ul>
                 @foreach ($errors->all() as $error)
                     <li class="ml-3">{{ $error }}</li>
                 @endforeach
             </ul>
         </div>
     </div>
 @endif

 @if (isset($formErrors) && is_array($formErrors))
     <div class="container-fluid mt-3">
         <div class="alert alert-danger alert-dismissible">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <h4><i class="icon fa fa-exclamation-circle"></i> Form Validation Failed with
                 Error{{ count($formErrors) > 1 ? 's' : '' }}</h4>
             <ul>
                 @foreach ($formErrors as $field => $messages)
                     <li class="ml-3">{{ $message }}</li>
                 @endforeach
             </ul>
         </div>
     </div>
 @endif

 @if (session('success'))
     <div class="alert alert-success mt-3 alert-dismissible container">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <h5><i class="icon fa fa-check-circle"></i><small> {{ session('success') }} </small></h5>
     </div>
 @endif

 @if (session('danger'))
     <div class="alert alert-danger mt-3 alert-dismissible container">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <h5><i class="icon fa fa-exclamation-circle"></i><small> {{ session('danger') }}</small></h5>
     </div>
 @endif

 @if (session('warning'))
     <div class="alert alert-warning mt-3 alert-dismissible container">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <h5><i class="icon fas fa-exclamation-circle"></i> <small> {{ session('warning') }}</small> </h5>
     </div>
 @endif
