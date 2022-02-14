@extends('layouts.nav')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User</h1>
</div>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">User</li>
</ol>

@if(Session::has('message'))
<div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
    {{ Session::get('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row mb-4">
    <a href="#" class="btn btn-success btn-icon-split ml-3" data-toggle="modal" data-target="#userModal">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Add User</span>
    </a>

</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">User table</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>E-mail</th>
                        <th>Address</th>
                        <th>Date Register</th>
                        <th>Wallet</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    {{-- @php dd($users)@endphp --}}
                    @forelse($users as $user)
                    @if($user->id != Auth::user()->id)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->role_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->address}}</td>
                        <td>{{$user->created_at->format('Y-m-d')}}</td>
                        <td>
                            @if($user->wallet === null)
                                No wallet
                            @else
                                {{$user->wallet}}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('user.edit',['id' => $user->id])}}" class="btn btn-info btn-circle btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->wallet !== null)
                            <a href="{{route('user.transaction',['id' => $user->id])}}" class="btn btn-warning btn-circle btn-sm">
                                <i class="fas fa-dollar-sign"></i>
                            </a>
                            @endif
                            @if($user->role_id != Auth::user()->role_id)
                            <form method="POST" action="{{route('user.delete',['id' => $user->id])}}" style="display: inline;">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-circle btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            {{-- <a href="{{route('transaction.edit',['id' => $user->id])}}" class="btn btn-danger btn-circle btn-sm">
                                <i class="fas fa-trash"></i>
                            </a> --}}
                            @endif
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="7">There's no user data</td>
                    </tr>
                    @endforelse
                    {{-- @forelse($trans as $transac)
                    <tr>
                        <td>{{$transac->created_at}}</td>
                        <td><span class="badge badge-pill badge-{{($transac->type=='deposit' ? 'success' : 'warning')}}">{{$transac->type}}</span></td>
                        <td>{{$transac->transaksi}}</td>
                        <td>{{$transac->total + $transac->transaksi}}</td>
                        <td>
                            @if($transac->id == $lastdata['id'])
                            <a href="{{route('transaction.edit',['id' => $transac->id])}}" class="btn btn-info btn-circle btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        @if($wallet['wallet'] === null)
                        <td colspan="4"><center>You don't have any wallet yet, <strong>make a wallet now!</strong></center></td>
                        @else
                        <td colspan="4"><center>You don't have any transaction yet</center></td>
                        @endif
                    </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Deposit Modal-->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add user</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.add')}}" method="POST" id="form-user">
                    @csrf
    
                    <div class="form-group">
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            id="" aria-describedby=""
                            placeholder="Enter Name..." 
                            value="{{ old('name') }}" 
                            required autocomplete="name" autofocus>
                        
                        <input id="role_id" type="hidden" class="form-control"  name="role_id" value="2">
                        @error('role_id')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <select class="form-select form-control" name="role_id" required autofocus>
                                <option value="1">Super Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div> 
                        
                        <input id="role_id" type="hidden" class="form-control"  name="role_id" value="2">
                        @error('name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    
                    <div class="form-group">
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
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
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror"
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
                        <input name="password_confirmation" type="password" class="form-control @error('password') is-invalid @enderror"
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
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit" form="form-user">Submit</a>
            </div>
        </div>
    </div>
</div>

@endsection
