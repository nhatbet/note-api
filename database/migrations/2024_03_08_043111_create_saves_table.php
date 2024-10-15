<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Save;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saves', function (Blueprint $table) {
            $table->id();
            $table->integer('saver_id');
            $table->integer('saveable_id');
            $table->string('saveable_type');
            $table->tinyInteger('status')->default(Save::STATUS_SAVED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saves');
    }
};
