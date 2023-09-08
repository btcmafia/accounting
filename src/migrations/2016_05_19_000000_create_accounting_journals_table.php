<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingJournalsTable extends Migration
{
    public function up(): void
    {
        Schema::create('accounting_journals', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name')->nullable();
            $table->unsignedInteger('ledger_id')->nullable();
            $table->bigInteger('balance');
            $table->uuid('currency_id');
            $table->string('morphed_type', 32);
            $table->integer('morphed_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_journals');
    }
}
