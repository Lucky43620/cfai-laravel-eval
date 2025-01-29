@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Informations de livraison</div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Adresse</label>
                            <input type="text" class="form-control @error('shipping_address') is-invalid @enderror"
                                   id="shipping_address" name="shipping_address" required>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_city" class="form-label">Ville</label>
                            <input type="text" class="form-control @error('shipping_city') is-invalid @enderror"
                                   id="shipping_city" name="shipping_city" required>
                            @error('shipping_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_postal_code" class="form-label">Code postal</label>
                            <input type="text" class="form-control @error('shipping_postal_code') is-invalid @enderror"
                                   id="shipping_postal_code" name="shipping_postal_code" required>
                            @error('shipping_postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_country" class="form-label">Pays</label>
                            <input type="text" class="form-control @error('shipping_country') is-invalid @enderror"
                                   id="shipping_country" name="shipping_country" required>
                            @error('shipping_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Commander</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Récapitulatif de la commande</div>
                <div class="card-body">
                    @foreach($cart as $id => $details)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <h6 class="mb-0">{{ $details['name'] }}</h6>
                                <small class="text-muted">{{ $details['quantity'] }} x {{ number_format($details['price'], 2) }}€</small>
                            </div>
                            <div>
                                {{ number_format($details['price'] * $details['quantity'], 2) }}€
                            </div>
                        </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>{{ number_format($total, 2) }}€</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
