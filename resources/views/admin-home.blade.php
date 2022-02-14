@extends('layouts.nav')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
</div>

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
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{count($users)}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-fw fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Balance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$wallets}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-fw fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row -->
<div class="row">

    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- User -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">User</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>E-mail</th>
                                <th>Address</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->role_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->address}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No data yet!</td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <p><center><a href="{{route('user')}}" type="button" class="btn btn-primary">CRUD User</a></center></p>
        </div>

    </div>

    <div class="col-lg-6 mb-4">

        <!-- Transaction -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transaction</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Nominal</th>
                                <th>End Balance</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($trans as $transac)
                                <tr>
                                    <td>{{$transac->name}}</td>
                                    <td>{{$transac->created_at}}</td>
                                    <td>{{$transac->type}}</td>
                                    <td>{{$transac->transaksi}}</td>
                                    <td>{{$transac->total}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No data yet!</td>
                                </tr>
                            @endforelse
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- @php dd($wallet['wallet']) @endphp --}}

{{-- @if($wallet['wallet'] === null)

    <form action="{{route('wallet.create')}}" method="POST">
        @csrf
        <input type="hidden" name="wallet" value="0">

        <button type="submit"class="btn btn-primary btn-icon-split btn-lg">
            <span class="icon text-white-50">
                <i class="fas fa-dollar-sign"></i>
            </span>
            <span class="text">Make a Wallet Now!</span>
        </button>

    </form>
    <div class="mb-4"></div>

@else
<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Your Wallet</div>
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
@endif --}}

{{-- <div class="row mb-4">
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
</div> --}}


<!-- DataTales Example -->
{{-- <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Transaction table</h6>
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
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse($trans as $transac)
                    <tr>
                        <td>{{$transac->created_at}}</td>
                        <td><span class="badge badge-pill badge-{{($transac->type=='deposit' ? 'success' : 'warning')}}">{{$transac->type}}</span></td>
                        <td>{{$transac->transaksi}}</td>
                        <td>{{$transac->total + $transac->transaksi}}</td>
                        
                    </tr>
                    @empty
                    <tr>
                        @if($wallet['wallet'] === null)
                        <td colspan="4"><center>You don't have any wallet yet, <strong>make a wallet now!</strong></center></td>
                        @else
                        <td colspan="4"><center>You don't have any transaction yet</center></td>
                        @endif
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <p><center><a href="{{route('transaction')}}" type="button" class="btn btn-primary">See more transaction...</a></center></p>
    </div>
</div> --}}

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
                <form action="{{route('transaction.deposit')}}" method="POST" id="form-deposit">
                    @csrf
                    <div class="form-group">
                        <label>Balance</label>
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
                <form action="{{route('transaction.withdraw')}}" method="POST" id="form-withdraw">
                    @csrf
                    <div class="form-group">
                        <label>Balance</label>
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
