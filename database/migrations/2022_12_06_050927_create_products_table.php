<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('code')->unique();
            $table->string('name');
            $table->string('colour');
            $table->string('tax_code');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')
                ->on('units');
            $table->unsignedBigInteger('product_type_id');
            $table->foreign('product_type_id')
                ->references('id')
                ->on('product_types');
            $table->float('cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
