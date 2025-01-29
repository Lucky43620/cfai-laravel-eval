@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Filtres -->
        <div class="col-md-3">
            <div class="card mb-4 sticky-top" style="top: 1rem;">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Filtres</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Rechercher</label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Nom du produit..." value="{{ request('search') }}">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catégorie</label>
                            <select name="category" class="form-select">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Trier par</label>
                            <select name="sort" class="form-select">
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nom</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Prix</option>
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Nouveautés</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Appliquer les filtres</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des produits -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2 mb-0">Nos Produits</h1>
                <span class="text-muted">{{ $products->total() }} produits trouvés</span>
            </div>

            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if($product->image)
                                <img src="{{ $product->image }}" class="card-img-top"
                                     alt="{{ $product->name }}"
                                     style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                    <span class="badge bg-primary">{{ $product->category->name }}</span>
                                </div>
                                <p class="card-text text-muted mt-2">{{ Str::limit($product->description, 80) }}</p>

                                @if($product->reviews->count() > 0)
                                    <div class="mb-2">
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= round($product->reviews->avg('rating')))
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </div>
                                        <small class="text-muted">
                                            ({{ $product->reviews->count() }} avis)
                                        </small>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="h5 mb-0">{{ number_format($product->price, 2) }}€</span>
                                    <div>
                                        <a href="{{ route('products.show', $product) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Voir détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
