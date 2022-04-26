<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockchainProfileTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'profile_blockchain';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('user_id');
            $table->string('api_key')->nullable();
            $table->string('xpub')->nullable();
            $table->boolean('enabled')->default(false);

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('updated_at');
            $table->integer('created_at');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}