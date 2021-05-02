<?php

use App\Models\UserFileAudit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFileAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_file_audits', function (Blueprint $table) {
            $table->id();

            $table->enum('type',[UserFileAudit::TYPE_DOWNLOAD, UserFileAudit::TYPE_UPLOAD]);
            $table->enum('result',[UserFileAudit::RESULT_SUCCESS, UserFileAudit::RESULT_ERROR]);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('file_id')->nullable();

            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
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
        Schema::dropIfExists('user_file_logs');
    }
}
