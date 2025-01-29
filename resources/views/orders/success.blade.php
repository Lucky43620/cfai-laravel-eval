@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="display-4 text-success">
                        <i class="fas fa-check-circle"></i>
                    </h1>
                    <h2>Commande confirmée !</h2>
                    <p class="lead">Merci pour votre commande. Nous vous enverrons un email de confirmation avec les détails de votre commande.</p>
                    <hr>
                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Continuer mes achats</a>
                        <a href="{{ route('profile') }}" class="btn btn-secondary">Voir mes commandes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 