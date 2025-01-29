@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        @foreach($cart->items as $item)
            <div class="col-md-4">
                <div class="card mb-4">
                    <!-- Affichage de l'image du produit -->
                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->product->name }}</h5>
                        <p class="card-text">Prix : {{ $item->price }}€</p>
                        <p class="card-text">Quantité : {{ $item->quantity }}</p>
                        <p class="card-text">Total : {{ $item->price * $item->quantity }}€</p>

                        <!-- Formulaire pour supprimer l'article -->
                        <form action="{{ route('cart.delete', $item->product_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        <!-- Bouton pour passer à la commande -->
        <a href="{{ route('checkout') }}" class="btn btn-primary">
            Commander ({{ $total }}€)
        </a>
    </div>
@endsection
