<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('name');
            $table->morphs('document');
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        });

        Schema::create('persons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('document')->unique();
        });

        Schema::create('shopkeepers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('document')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopkeepers');
        Schema::dropIfExists('persons');
        Schema::dropIfExists('clients');
    }
}
