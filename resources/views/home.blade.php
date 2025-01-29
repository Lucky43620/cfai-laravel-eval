@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-5 text-center bg-light rounded-3">
                <h1 class="display-4 fw-bold">Bienvenue sur notre boutique</h1>
                <p class="fs-4">Découvrez notre sélection de produits de qualité</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Voir nos produits</a>
            </div>
        </div>
    </div>

    <!-- Featured Categories -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-4">Nos Catégories</h2>
        </div>
        @foreach($categories->take(6) as $category)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h3 class="h5">{{ $category->name }}</h3>
                        <p class="text-muted">{{ Str::limit($category->description, 100) }}</p>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="btn btn-outline-primary">
                            Découvrir
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Featured Products -->
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Produits Populaires</h2>
        </div>
        @foreach($featuredProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" 
                             style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="h5 mb-0">{{ number_format($product->price, 2) }}€</span>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">
                                Voir détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection 