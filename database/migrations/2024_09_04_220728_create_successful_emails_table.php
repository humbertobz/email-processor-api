<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuccessfulEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('successful_emails', function (Blueprint $table) {
            $table->id(); // Cria a coluna `id` com auto-incremento
            $table->mediumInteger('affiliate_id')->unsigned(); // Cria a coluna `affiliate_id`
            $table->text('envelope'); // Cria a coluna `envelope`
            $table->string('from', 255); // Cria a coluna `from` com comprimento máximo de 255 caracteres
            $table->text('subject'); // Cria a coluna `subject`
            $table->string('dkim', 255)->nullable(); // Cria a coluna `dkim` como opcional
            $table->string('SPF', 255)->nullable(); // Cria a coluna `SPF` como opcional
            $table->float('spam_score')->nullable(); // Cria a coluna `spam_score` como opcional
            $table->longText('email'); // Cria a coluna `email` para armazenar texto longo
            $table->longText('raw_text'); // Cria a coluna `raw_text` para armazenar texto longo
            $table->string('sender_ip', 50)->nullable(); // Cria a coluna `sender_ip` como opcional
            $table->text('to'); // Cria a coluna `to`
            $table->integer('timestamp'); // Cria a coluna `timestamp`

            $table->timestamps(); // Cria colunas `created_at` e `updated_at`

            $table->index('affiliate_id'); // Cria um índice na coluna `affiliate_id`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('successful_emails');
    }
}
