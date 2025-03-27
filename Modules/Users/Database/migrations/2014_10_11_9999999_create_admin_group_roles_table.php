<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminGroupRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_group_roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('admin_group_id')->constrained('admin_groups')->references('id')->onDelete('cascade');
            $table->string('resource');
            $table->enum('create', ['yes', 'no'])->default('no')->index();
            $table->enum('show', ['yes', 'no'])->default('no')->index();
            $table->enum('update', ['yes', 'no'])->default('no')->index();
            $table->enum('delete', ['yes', 'no'])->default('no')->index();
            $table->enum('force_delete', ['yes', 'no'])->default('no')->index();
            $table->enum('restore', ['yes', 'no'])->default('no')->index();
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
        Schema::dropIfExists('admin_group_roles');
    }
}
