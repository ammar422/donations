<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('full_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('photo')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable()->index();
            $table->string('verification_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('account_status', ['pending', 'active', 'ban'])->default('pending')->index();
            $table->string('password')->default('no_password_for_user')->nullable();
            $table->string('reset_token')->nullable();
            $table->enum('account_type', ['user', 'admin'])->default('user')->index();
            $table->longText('ban_reason')->nullable();

            $table->foreignUuid('admin_group_id')->nullable()->constrained('admin_groups')->cascadeOnDelete()->cascadeOnUpdate();

            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
