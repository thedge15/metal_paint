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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->index()->constrained('projects');
            $table->foreignId('metal_id')->index()->constrained('metals');
            $table->foreignId('characteristic_id')->index()->constrained('characteristics');
            $table->foreignId('standard_id')->index()->constrained('standards');
            $table->foreignId('steel_id')->index()->constrained('steels');
            $table->foreignId('element_id')->index()->constrained('elements');


            $table->integer('numb')->nullable();
            $table->decimal('weight', 13, 3);
            $table->decimal('length', 13, 3)->nullable();
            $table->decimal('area', 13, 3);
            $table->decimal('quantity')->nullable();
            $table->string('paint')->nullable();
            $table->decimal('paint_quantity')->nullable();
            $table->string('paint_color')->nullable();
            $table->integer('number_of_layers')->nullable();
            $table->boolean('is_pile')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
