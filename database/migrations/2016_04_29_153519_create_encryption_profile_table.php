<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncryptionProfileTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'profile_encryption';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('user_id');

            //keep this in mind.
            //aes -- http://stackoverflow.com/questions/3712222/does-mysql-ignore-null-values-on-unique-constraints
            $table->text('master_key', 5000);
            $table->text('public_key', 5000); //maybe use text instead of varchar (string)?
            $table->text('encrypted_private_key', 5000); //maybe use text instead of varchar (string)?

            /**
             *
             */
            $table->text('static_key', 5000);

            /**
             *
             */
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