<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('description',1000);
            $table->string('rating',10);

            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('product_id')->references('id')->on('products')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('customer_id')->references('id')->on('customer_profiles')->restrictOnDelete()->cascadeOnUpdate();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
