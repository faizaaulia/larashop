@extends('layouts.global')

@section('title', 'Orders List')

@section('content')
    <form action="{{ route('orders.index') }}">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="buyer_email" id="buyer_email" class="form-control" value="{{ Request::get('buyer_email') }}" placeholder="Filter by buyer's email">
            </div>
            <div class="col-md-2">
                <select name="status" id="status" class="form-control">
                    <option value="">ANY</option>
                    <option value="SUBMIT" {{ Request::get('status') == 'SUBMIT' ? 'selected' : '' }}>SUBMIT</option>
                    <option value="PROCESS" {{ Request::get('status') == 'PROCESS' ? 'selected' : '' }}>PROCESS</option>
                    <option value="FINISH" {{ Request::get('status') == 'FINISH' ? 'selected' : '' }}>FINISH</option>
                    <option value="CANCEL" {{ Request::get('status') == 'CANCEL' ? 'selected' : '' }}>CANCEL</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="submit" value="Filter" class="btn btn-primary">
            </div>
        </div>
    </form>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
            <table class="table shadow-0">
                <thead>
                    <tr>
                        <th><b>Invoice Number</b></th>
                        <th><b>Status</b></th>
                        <th><b>Buyer</b></th>
                        <th><b>Total Quantity</b></th>
                        <th><b>Order Date</b></th>
                        <th><b>Total Price</b></th>
                        <th><b>Actions</b></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->invoice_number }}</td>
                            <td>
                                @if ($order->status == 'PUBLISH')
                                    <span class="badge bg-warning text-light">{{ $order->status }}</span>
                                @elseif ($order->status == 'PROCESS')
                                    <span class="badge bg-info text-light">{{ $order->status }}</span>
                                @elseif ($order->status == 'FINISH')
                                    <span class="badge bg-success text-light">{{ $order->status }}</span>
                                @elseif ($order->status == 'CANCEL')
                                    <span class="badge bg-dark text-light">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $order->user->name }} <br>
                                <small>{{ $order->user->email }}</small>
                            </td>
                            <td>{{ $order->totalQuantity }} pc(s)</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->total_price }}</td>
                            <td>
                                <a href="{{ route('orders.edit', [$order->id]) }}" class="btn btn-sm btn-info">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">
                            {{ $orders->appends(Request::all())->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection