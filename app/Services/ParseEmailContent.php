<?php

namespace App\Services;

use PhpMimeMailParser\Parser;

class ParseEmailContent
{
    /**
     * Extrai o corpo do e-mail em texto puro da carga bruta.
     *
     * @param string $rawEmailPayload Conteúdo bruto do e-mail, incluindo headers
     * @return string Corpo do e-mail em texto simples
     */
    public function extractBody($rawEmailPayload)
    {
        // Cria o parser e carrega o conteúdo do e-mail bruto
        $parser = new Parser();
        $parser->setText($rawEmailPayload);

        // Tenta obter o corpo do e-mail como texto puro
        $plainText = $parser->getMessageBody('text');

        // Caso não haja corpo de texto simples, tenta extrair o corpo HTML
        if (!$plainText) {
            $htmlBody = $parser->getMessageBody('html');

            // Remove tags HTML para manter apenas o texto simples
            $plainText = strip_tags($htmlBody);
        }

        // Set parser text and check if still have header or is only raw body
        // Propably not the best way to do this
        $parser->setText($plainText);
        if ($parser->getHeaders()) {
            $plainText = $this->extractBody($plainText);
        }

        return trim($plainText);
    }
}
