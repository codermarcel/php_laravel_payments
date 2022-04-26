<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecoveryCodesTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'recovery_codes';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('user_id');
            $table->string('token')->unique();

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
