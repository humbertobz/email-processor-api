<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SuccessfulEmail;
use App\Services\ParseEmailContent;

class ProcessEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'process emails content and extracts plain text to save in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Busca os e-mails que ainda não foram processados (raw_text está vazio)
        $emails = SuccessfulEmail::/*whereNull('updated_at')->*/whereNull('deleted_at')->get();

        foreach ($emails as $email) {
            // Instancia o parser
            $parser = new ParseEmailContent();
            $plainTextBody = $parser->extractBody($email->email);

            // Salva o texto simples no banco de dados
            $email->raw_text = $plainTextBody;
            $email->save();

            // Exibe uma mensagem no terminal para cada e-mail processado
            $this->info('Processed email ID: ' . $email->id);
        }

        $this->info('E-mails processados com sucesso.');
        return Command::SUCCESS;
    }
}
