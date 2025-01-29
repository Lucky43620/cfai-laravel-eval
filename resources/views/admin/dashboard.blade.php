@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de bord administrateur</h1>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Commandes totales</h5>
                    <p class="card-text h2">{{ $stats['total_orders'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Chiffre d'affaires</h5>
                    <p class="card-text h2">{{ number_format($stats['total_revenue'], 2) }}€</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Produits</h5>
                    <p class="card-text h2">{{ $stats['total_products'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Clients</h5>
                    <p class="card-text h2">{{ $stats['total_customers'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Commandes récentes -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Commandes récentes</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Montant</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->total_amount }}€</td>
                                    <td>{{ $order->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Produits en rupture de stock -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Produits en rupture de stock</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Stock restant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($low_stock_products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->stock }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 