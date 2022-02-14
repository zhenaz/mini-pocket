@extends('layouts.nav-login')

@section('content')
<!-- Outer Row -->
<div class="row justify-content-center">

    <div class="col-xl-6 col-lg-12 col-md-12">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Register</h1>
                            </div>
                            <form method="POST" action="{{ route('register') }}" class="user">
                                @csrf
                                
                                <div class="form-group">
                                    <input name="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                                        id="" aria-describedby=""
                                        placeholder="Enter Name..." 
                                        value="{{ old('name') }}" 
                                        required autocomplete="name" autofocus>
                                    
                                    <input id="role_id" type="hidden" class="form-control"  name="role_id" value="2">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <input name="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                        id="" aria-describedby=""
                                        placeholder="Enter Email Address..." 
                                        value="{{ old('email') }}" 
                                        required autocomplete="email" autofocus>

                                    @error('email')
                                        <div class="invalid-feedback" >
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <textarea id="address" rows="5" class="form-control @error('address') is-invalid @enderror" name="address" required autocomplete="address" placeholder="Enter Address">{{ old('address') }}</textarea>

                                    @error('address')
                                        <div class="invalid-feedback" >
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input name="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                        id="" aria-describedby=""
                                        placeholder="Enter Password..." 
                                        value="{{ old('name') }}" 
                                        required autocomplete="new-password">

                                    @error('password')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input name="password_confirmation" type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                        id="" aria-describedby=""
                                        placeholder="Confirm Password..." 
                                        value="{{ old('name') }}" 
                                        required autocomplete="new-password">

                                    @error('password')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register
                                </button> 
        
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{route('login')}}">Already have an Account?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
