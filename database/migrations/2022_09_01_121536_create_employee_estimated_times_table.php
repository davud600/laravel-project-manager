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
        Schema::create('employee_estimated_times', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->foreignIdFor(User::class, 'employee_id');
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->integer('time_added');
            $table->boolean('created_by_admin')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_estimated_times');
    }
};
