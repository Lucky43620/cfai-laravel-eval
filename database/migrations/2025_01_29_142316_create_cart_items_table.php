<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade'); // Lien avec le panier
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Lien avec le produit
            $table->integer('quantity'); // Quantité du produit dans le panier
            $table->decimal('price', 10, 2); // Prix du produit au moment de l'ajout dans le panier
            $table->timestamps(); // Pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
