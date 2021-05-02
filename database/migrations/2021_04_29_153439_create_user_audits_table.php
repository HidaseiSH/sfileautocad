<?php

use App\Models\UserAudit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_audits', function (Blueprint $table) {
            $table->id();

            $table->enum('action',[UserAudit::ACTION_UPDATE_PASSWORD,UserAudit::ACTION_LOGIN, UserAudit::ACTION_LOGOUT]);

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
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
        Schema::dropIfExists('user_logs');
    }
}
