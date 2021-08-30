<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDocflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('docflows', function (Blueprint $table)
         {
            $table->boolean('is_downloaded')->default(false);
            $table->string('filename')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('docflows', function (Blueprint $table)
        {
           $table->dropColumn(['is_downloaded', 'filename']);
       });
    }
}
