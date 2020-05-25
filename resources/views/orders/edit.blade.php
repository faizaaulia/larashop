@extends('layouts.global')

@section('title', 'Edit Order')

@section('content')
    <div class="row">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('orders.update', [$order->id]) }}" method="post" class="shadow-sm bg-white p-3">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                
                <label>Invoice Numebr</label> <br>
                <input type="text" class="form-control" value="{{ $order->invoice_number }}" disabled> <br>
                
                <label>Buyer</label> <br>
                <input type="text" class="form-control" value="{{ $order->user->name }}" disabled> <br>
                
                <label>Order Date</label> <br>
                <input type="text" class="form-control" value="{{ $order->created_at }}" disabled> <br>
                
                <label>Books ({{ $order->totalQuantity }})</label> <br>
                <ul>
                    @foreach ($order->books as $book)
                        <li>{{ $book->title }} <b> ({{ $book->pivot->quantity }}) </b></li>
                    @endforeach
                </ul>

                <label>Total Price</label> <br>
                <input type="text" class="form-control" value="{{ $order->total_price }}" disabled> <br>

                <label>Status</label> <br>
                <select name="status" id="status" class="form-control">
                    <option value="SUBMIT" {{ $order->status == 'SUBMIT' ? 'selected' : '' }}>SUBMIT</option>
                    <option value="PROCESS" {{ $order->status == 'PROCESS' ? 'selected' : '' }}>PROCESS</option>
                    <option value="FINISH" {{ $order->status == 'FINISH' ? 'selected' : '' }}>FINISH</option>
                    <option value="CANCEL" {{ $order->status == 'CANCEL' ? 'selected' : '' }}>CANCEL</option>
                </select> <br>

                <input type="submit" value="Update" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection