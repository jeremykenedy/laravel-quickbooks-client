<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateQuickBooksTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quickbooks_tokens', function (Blueprint $table) {
            $user_id_type = DB::getSchemaBuilder()
                              ->getColumnType(config('quickbooks.model.keys.table'), config('quickbooks.model.keys.owner')) === 'bigint' ? 'unsignedBigInteger' : 'unsignedInteger';
            $table->unsignedBigInteger('id');
            $table->{$user_id_type}(config('quickbooks.model.keys.foreign'));
            $table->unsignedBigInteger('realm_id');
            $table->longtext('access_token');
            $table->datetime('access_token_expires_at');
            $table->string('refresh_token');
            $table->datetime('refresh_token_expires_at');
            $table->timestamps();

            $table->foreign(config('quickbooks.model.keys.foreign'))
                  ->references(config('quickbooks.model.keys.owner'))
                  ->on(config('quickbooks.model.keys.table'))
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
        Schema::dropIfExists('quickbooks_token');
    }
}
