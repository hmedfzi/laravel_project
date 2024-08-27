<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->string('otp_code');
            $table->string('login_id')->comment('email or mobile');
            $table->tinyInteger('type')->default(0)->comment('0 => mobile, 1 => email');
            $table->tinyInteger('used')->default(0)->comment('0 => notUsed, 1 => used');
            $table->tinyInteger('status')->default(0);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('otps');
    }
}
