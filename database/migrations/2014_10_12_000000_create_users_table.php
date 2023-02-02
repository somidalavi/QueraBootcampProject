<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('role', [array_keys(User::ROLES)])->default(User::USER);
            $table->string('avatar')->nullable();
            $table->boolean('gender')->nullable();
            $table->string('national_code')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->unsignedBigInteger('wallet')->default(0);
            $table->foreignId('city_id')->constrained();
            $table->foreignId('provience_id')->constrained();
            $table->string('email')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile')->unique()->index();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
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
};
