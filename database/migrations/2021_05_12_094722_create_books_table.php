<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('script_id');
            $table->foreignId('language_id')->default(1);
            $table->foreignId('binding_id');
            $table->foreignId('format_id');
            $table->foreignId('publisher_id');

            $table->string('title', 256);
            $table->integer('pages');
            $table->integer('publishYear');
            $table->string('ISBN', 20)->unique();
            $table->integer('quantity');
            $table->integer('rentedBooks')->default(0);
            $table->integer('reservedBooks')->default(0);
            $table->string('summary', 4128)->nullable();
            $table->timestamps();

            $table->foreign('script_id')
                ->references('id')
                ->on('scripts')
                ->onDelete('cascade');

            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade');

            $table->foreign('binding_id')
                ->references('id')
                ->on('bindings')
                ->onDelete('cascade');

            $table->foreign('format_id')
                ->references('id')
                ->on('formats')
                ->onDelete('cascade');

            $table->foreign('publisher_id')
                ->references('id')
                ->on('publishers')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
