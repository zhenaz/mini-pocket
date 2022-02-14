@extends('layouts.nav')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
</div>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{url('/user')}}">User</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
</ol>

@if(Session::has('message'))
<div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
    {{ Session::get('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
@endif

{{-- @php dd($users) @endphp --}}

<div class="row">

    <div class="col-lg-12">

        <!-- Default Card Example -->
        <div class="card mb-4">
            <div class="card-header">
                
            </div>
            <div class="card-body">
                <form action="{{route('user.update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label>Name</label>
                      <input type="hidden" name="id_user" id="" value="{{$users['id']}}">
                      <input type="text" name="name" class="form-control" placeholder="Name" value="{{$users['name']}}">
                    </div> 
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-select form-control" name="role_id">
                            <option value="1" {{($users['role_id'] == 1 ? 'selected' : '')}}>Super Admin</option>
                            @if($users['role_id'] != Auth::user()->role_id)
                            <option value="2" {{($users['role_id'] == 2 ? 'selected' : '')}}>User</option>
                            @endif
                        </select>
                    </div> 
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{$users['email']}}">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" placeholder="Address">{{$users['address']}}</textarea>
                    </div>
                
                    <button type="submit" class="btn btn-primary">Edit</button>
                  </form>
            </div>
        </div>

    </div>
</div>

@endsection