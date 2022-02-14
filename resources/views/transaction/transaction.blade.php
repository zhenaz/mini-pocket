@extends('layouts.nav')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transaction</h1>
</div>

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
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

<!-- DataTales Example -->
<div class="card shadow mb-4">
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
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse($trans as $transac)
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



@endsection
