@extends('layouts.nav')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Transaction</h1>
</div>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{url('/user')}}">User</a></li>
    <li class="breadcrumb-item"><a href="{{url()->previous()}}">Transaction</a></li>
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

<div class="row">

    <div class="col-lg-12">

        <!-- Default Card Example -->
        <div class="card mb-4">
            <div class="card-header py-3">
                {{-- @php dd($wallet) @endphp --}}
                <h6 class="m-0 font-weight-bold text-primary">Edit User Transaction ({{$wallet['name']}})</h6>
            </div>
            <div class="card-body">
                <form action="{{route('user.transaction.update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label>Balance</label>
                      <input type="hidden" name="id_user" value="{{$wallet['user_id']}}" id="">
                      <input type="hidden" name="id_transaksi" value="{{$trans['id']}}" id="">
                      <input type="hidden" name="id_wallet" value="{{$trans['wallet_id']}}" id="">
                      <input type="hidden" name="type" value="{{$trans['type']}}" id="">
                      <input type="hidden" name="old_wallet" class="form-control" placeholder="Name" value="{{abs($trans['transaksi'])}}">
                      <input type="text" name="wallet" class="form-control" placeholder="Name" value="{{abs($trans['transaksi'])}}">
                    </div> 
                
                    <button type="submit" class="btn btn-primary">Edit</button>
                  </form>
            </div>
        </div>

    </div>
</div>

@endsection