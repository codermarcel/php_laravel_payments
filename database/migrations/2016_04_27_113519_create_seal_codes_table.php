<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSealCodesTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'seal_codes';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('email_template_id');
            $table->string('code')->unique();
            $table->tinyInteger('status')->default(0);

            $table->foreign('email_template_id')
            ->references('id')->on('email_templates')
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
