<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = "clients";
    private $column = "people_id";
    private $foreign = "clients_people_id_foreign";

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger($this->column);
            $table->foreign($this->column)->references('id')->on('peoples');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropForeign($this->foreign);
        });

        Schema::dropIfExists('clients');
    }
};
