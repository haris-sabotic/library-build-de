<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rent_id');
            $table->foreignId('statusBook_id');
            $table->timestamp('date');
            $table->timestamps();

            $table->foreign('rent_id')
                ->references('id')
                ->on('rents')
                ->onDelete('cascade');

            $table->foreign('statusBook_id')
                ->references('id')
                ->on('status_books')
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
        Schema::dropIfExists('rent_statuses');
    }
}
