<?php

use App\Models\stock;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('symbol')->unique();
            $table->string('company')->unique();
            $table->enum('market', stock::$market)->index();
            $table->timestamps();
            if (Schema::getConnection()->getDriverName() === 'mysql') {
                $table->fullText('symbol');
                $table->fullText('company');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
