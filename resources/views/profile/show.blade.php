@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Mon Profil</div>
                <div class="card-body">
                    <h5>{{ $user->name }}</h5>
                    <p>{{ $user->email }}</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Modifier mon profil</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Mes Commandes</div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6>Commande #{{ $order->id }}</h6>
                                            <p class="text-muted mb-0">
                                                {{ $order->created_at->format('d/m/Y à H:i') }}
                                            </p>
                                        </div>
                                        <div>
                                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                                {{ $order->status }}
                                            </span>
                                            <span class="ms-3">{{ number_format($order->total_amount, 2) }}€</span>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="row">
                                        @foreach($order->items as $item)
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ $item->product->image }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="img-thumbnail me-3" 
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                        <small class="text-muted">
                                                            {{ $item->quantity }} x {{ number_format($item->price, 2) }}€
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Vous n'avez pas encore passé de commande.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 