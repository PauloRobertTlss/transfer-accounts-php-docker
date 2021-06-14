<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('agency', 120);
            $table->string('account', 120);
            $table->float('balance');
            $table->uuid('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->timestamp('created_at')->useCurrent();
            /**
             * Others layers
             */
            $table->timestamp('locked_at')->nullable();
            $table->bigInteger('locked_by')->nullable()->unsigned();
            $table->foreign('locked_by')->references('id')->on('users');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
}
