@extends('layout')

@section('title', 'Cart')

@section('content')

    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>

        <?php $total = 0 ?>

        
            @foreach($cartProduct as $id => $details)

                <tr>
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{$details->product_name }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">${{ $details->product->price }}</td>
                    <td data-th="Quantity">
                        <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                    </td>
                    <td data-th="Subtotal" class="text-center">${{ $details->amount }}</td>
                 
                </tr>
            @endforeach
      

        </tbody>
        <tfoot>
        
        <tr>
            <td><a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
            <td><a href="{{ url('/checkout') }}" class="btn btn-warning"><i class="fa fa-angle-right"></i> Checkout</a></td>

            <td colspan="2" class="hidden-xs"></td>
        </tr>
        </tfoot>
    </table>

@endsection
