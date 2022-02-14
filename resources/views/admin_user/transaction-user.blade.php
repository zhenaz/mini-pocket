@extends('layouts.nav')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User</h1>
</div>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{url('user')}}">User</a></li>
    <li class="breadcrumb-item active" aria-current="page">Transaction</li>
</ol>

@if(Session::has('message'))
<div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
    {{ Session::get('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            <span>{{$wallet['name']}}'s Wallet</span>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. 
                            {{$wallet['wallet']}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row mb-4">
    <a href="#" class="btn btn-success btn-icon-split ml-3" data-toggle="modal" data-target="#depositModal">
        <span class="icon text-white-50">
            <i class="fas fa-sack-dollar"></i>
        </span>
        <span class="text">Deposit</span>
    </a>

    <a href="#" class="btn btn-warning btn-icon-split ml-3" data-toggle="modal" data-target="#withdrawModal">
        <span class="icon text-white-50">
            <i class="fas fa-inbox-out"></i>
        </span>
        <span class="text">Withdraw</span>
    </a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">User Transaction table ({{$wallet['name']}})</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Nominal</th>
                        <th>End Balance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @php dd($lastdata) @endphp --}}
                    @forelse($trans as $transac)
                    <tr>
                        <td>{{$transac->created_at}}</td>
                        <td><span class="badge badge-pill badge-{{($transac->type=='deposit' ? 'success' : 'warning')}}">{{$transac->type}}</span></td>
                        <td>{{$transac->transaksi}}</td>
                        <td>{{$transac->total + $transac->transaksi}}</td>
                        <td>
                            @if($transac->id == $lastdata['id'])
                            <a href="{{route('user.transaction.edit',['id' => $transac->id])}}" class="btn btn-info btn-circle btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                                @if($wallet['role_id'] != Auth::user()->role_id)
                                <form method="POST" action="{{route('user.transaction.delete',['id' => $transac->id])}}" style="display: inline;">
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
                            @endif
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        @if($wallet['wallet'] === null)
                        <td colspan="5"><center>You don't have any wallet yet, <strong>make a wallet now!</strong></center></td>
                        @else
                        <td colspan="5"><center>You don't have any transaction yet</center></td>
                        @endif
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Deposit Modal-->
<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deposit</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.transaction.deposit')}}" method="POST" id="form-deposit">
                    @csrf
                    <div class="form-group">
                        <label>Balance</label>
                        <input type="hidden" name="user_id" value="{{$wallet['user_id']}}" id="">
                        <input name="wallet" type="number" min="1000" class="form-control" placeholder="Input Balance to be deposit">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit" form="form-deposit">Submit</a>
            </div>
        </div>
    </div>
</div>

<!-- Withdraw Modal-->
<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Withdraw</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.transaction.withdraw')}}" method="POST" id="form-withdraw">
                    @csrf
                    <div class="form-group">
                        <label>Balance</label>
                        <input type="hidden" name="user_id" value="{{$wallet['user_id']}}" id="">
                        <input name="wallet" type="number" min="1000" class="form-control" placeholder="Input Balance to be withdraw!">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit" form="form-withdraw">Submit</a>
            </div>
        </div>
    </div>
</div>

@endsection
