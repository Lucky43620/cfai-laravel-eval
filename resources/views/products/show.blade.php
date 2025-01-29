@extends('layouts.app')

@section('content')
    <div class="card">
        <img src="{{ $product->image_url }}" class="card-img-top">
        <div class="card-body">
            <h5>{{ $product->name }}</h5>
            <p>{{ $product->price }}€</p>
            
            @foreach($product->reviews as $review)
                <div class="review">
                    {{ $review->comment }}
                    <small>{{ $review->user->name }}</small>
                </div>
            @endforeach

            <form action="{{ url('cart/add') }}" method="GET">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit">Ajouter au panier</button>
            </form>
        </div>
    </div>
@endsection
