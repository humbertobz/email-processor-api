<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\SuccessfulEmail;
use App\Models\User;
// use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Contracts\Auth\Authenticatable;
// use Illuminate\Http\Response;

class SuccessfulEmailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para o método index - Listar todos os emails
     */
    public function test_index_returns_successful_emails()
    {
        // Crie um usuário e autentique via Sanctum
        $user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($user, 'sanctum');

        // Cria alguns registros no banco
        $emails = SuccessfulEmail::factory()->count(3)->create();

        $response = $this->getJson('/api/emails');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    /**
     * Teste para o método store - Criar um novo email
     */
    public function test_store_creates_successful_email()
    {
        $data = [
            'affiliate_id' => 1,
            'envelope' => 'sample envelope',
            'from' => 'test@example.com',
            'subject' => 'Test Subject',
            'dkim' => 'sample dkim',
            'SPF' => 'sample spf',
            'spam_score' => 0.1,
            'email' => 'Delivered-To: user@example.com\nReceived: by 2002:a05:6e02:1b8:: with SMTP id j24csp1678250ljk;\n        Tue, 01 Aug 2023 08:12:45 -0700 (PDT)\nX-Received: by 2002:a05:6e02:1b8:: with SMTP id j24csp1678250ljk;\n        Tue, 01 Aug 2023 08:12:45 -0700 (PDT)\nReturn-Path: <no-reply@sendgrid.net>\nReceived: from mail-ua1-f45.google.com (mail-ua1-f45.google.com. [209.85.222.45])\n        by mx.google.com with ESMTPS id r5si1901909qkj.296.2023.08.01.08.12.45\n        for <user@example.com>\n        (version=TLS1_2 cipher=ECDHE-RSA-AES128-GCM-SHA256 bits=128/128);\n        Tue, 01 Aug 2023 08:12:45 -0700 (PDT)\nReceived-SPF: pass (google.com: domain of no-reply@sendgrid.net designates 209.85.222.45 as permitted sender) client-ip=209.85.222.45;\nAuthentication-Results: mx.google.com;\n       dkim=pass header.i=@sendgrid.net header.s=smtpapi header.b=FbTW1Ex7;\n       spf=pass (google.com: domain of no-reply@sendgrid.net designates 209.85.222.45 as permitted sender) smtp.mailfrom=no-reply@sendgrid.net;\n       dmarc=pass (p=NONE sp=NONE dis=NONE) header.from=sendgrid.net\nReceived: by 2002:a67:3f04:0:0:0:0:0 with SMTP id o4csp153658pfb;\n        Tue, 01 Aug 2023 08:12:45 -0700 (PDT)\nDKIM-Signature: v=1; a=rsa-sha256; c=relaxed/relaxed;\n        d=sendgrid.net; s=smtpapi; t=1690894365;\n        h=from:to:subject:message-id:date:mime-version:content-type:content-transfer-encoding;\n        bh=VqMvDaFk5YX8fhgixayKgV4vXz+0SOetQfH5vq1yX/s=;\n        b=FbTW1Ex7oEjKHmSObbX3Ds90WyFzryV8BQ0zWqzt8mxslSK5YyyDwbX6cAyChXuWu\n         MLTy2xeyMS8QyW6HjKYKx7pdOb6YVnn6TVJvC8fRj8VJb5C3+ZbcBtFK0w==\n\nFrom: "Example Sender" <no-reply@sendgrid.net>\nTo: user@example.com\nSubject: Your Weekly Newsletter\nMessage-ID: <CA+p7eYO=CzLHgCVmrdx-G_d5X9mfw+Xr5QwHsVOkKk@mail.gmail.com>\nDate: Tue, 01 Aug 2023 08:12:45 -0700 (PDT)\nMIME-Version: 1.0\nContent-Type: multipart/alternative; boundary="0000000000004c6b9401ff294e12"\n\n--0000000000004c6b9401ff294e12\nContent-Type: text/plain; charset="UTF-8"\nContent-Transfer-Encoding: quoted-printable\n\nHello User,\n\nThank you for subscribing to our newsletter!\n\nWe hope you enjoy the content.\n\nBest regards,\nThe Team\n\n--0000000000004c6b9401ff294e12\nContent-Type: text/html; charset="UTF-8"\nContent-Transfer-Encoding: quoted-printable\n\n<html>\n  <body style="font-family:Arial, sans-serif;">\n    <h1 style="color: #333;">Hello User,</h1>\n    <p>Thank you for subscribing to our <strong>newsletter!</strong></p>\n    <p>We hope you enjoy the content.</p>\n    <p>Best regards,</p>\n    <p>The Team</p>\n  </body>\n</html>\n\n--0000000000004c6b9401ff294e12--',
            'raw_text' => 'Delivered-To: user@example.com\nReceived: by 2002:a05:6e02:1b8:: with SMTP id j24csp1678250ljk;\n        Tue, 01 Aug 2023 08:12:45 -0700 (PDT)\nX-Received: by 2002:a05:6e02:1b8:: with SMTP id j24csp1678250ljk;\n        Tue, 01 Aug 2023 08:12:45 -0700 (PDT)\nReturn-Path: <no-reply@sendgrid.net>\nReceived: from mail-ua1-f45.google.com (mail-ua1-f45.google.com. [209.85.222.45])\n        by mx.google.com with ESMTPS id r5si1901909qkj.296.2023.08.01.08.12.45\n        for <user@example.com>\n        (version=TLS1_2 cipher=ECDHE-RSA-AES128-GCM-SHA256 bits=128/128);\n        Tue, 01 Aug 2023 08:12:45 -0700 (PDT)\nReceived-SPF: pass (google.com: domain of no-reply@sendgrid.net designates 209.85.222.45 as permitted sender) client-ip=209.85.222.45;\nAuthentication-Results: mx.google.com;\n       dkim=pass header.i=@sendgrid.net header.s=smtpapi header.b=FbTW1Ex7;\n       spf=pass (google.com: domain of no-reply@sendgrid.net designates 209.85.222.45 as permitted sender) smtp.mailfrom=no-reply@sendgrid.net;\n       dmarc=pass (p=NONE sp=NONE dis=NONE) header.from=sendgrid.net\nReceived: by 2002:a67:3f04:0:0:0:0:0 with SMTP id o4csp153658pfb;\n        Tue, 01 Aug 2023 08:12:45 -0700 (PDT)\nDKIM-Signature: v=1; a=rsa-sha256; c=relaxed/relaxed;\n        d=sendgrid.net; s=smtpapi; t=1690894365;\n        h=from:to:subject:message-id:date:mime-version:content-type:content-transfer-encoding;\n        bh=VqMvDaFk5YX8fhgixayKgV4vXz+0SOetQfH5vq1yX/s=;\n        b=FbTW1Ex7oEjKHmSObbX3Ds90WyFzryV8BQ0zWqzt8mxslSK5YyyDwbX6cAyChXuWu\n         MLTy2xeyMS8QyW6HjKYKx7pdOb6YVnn6TVJvC8fRj8VJb5C3+ZbcBtFK0w==\n\nFrom: "Example Sender" <no-reply@sendgrid.net>\nTo: user@example.com\nSubject: Your Weekly Newsletter\nMessage-ID: <CA+p7eYO=CzLHgCVmrdx-G_d5X9mfw+Xr5QwHsVOkKk@mail.gmail.com>\nDate: Tue, 01 Aug 2023 08:12:45 -0700 (PDT)\nMIME-Version: 1.0\nContent-Type: multipart/alternative; boundary="0000000000004c6b9401ff294e12"\n\n--0000000000004c6b9401ff294e12\nContent-Type: text/plain; charset="UTF-8"\nContent-Transfer-Encoding: quoted-printable\n\nHello User,\n\nThank you for subscribing to our newsletter!\n\nWe hope you enjoy the content.\n\nBest regards,\nThe Team\n\n--0000000000004c6b9401ff294e12\nContent-Type: text/html; charset="UTF-8"\nContent-Transfer-Encoding: quoted-printable\n\n<html>\n  <body style="font-family:Arial, sans-serif;">\n    <h1 style="color: #333;">Hello User,</h1>\n    <p>Thank you for subscribing to our <strong>newsletter!</strong></p>\n    <p>We hope you enjoy the content.</p>\n    <p>Best regards,</p>\n    <p>The Team</p>\n  </body>\n</html>\n\n--0000000000004c6b9401ff294e12--',
            'to' => 'receiver@example.com',
            'timestamp' => time(),
        ];

        // Crie um usuário e autentique via Sanctum
        $user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/emails', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('successful_emails', [
            'from' => 'test@example.com'
        ]);
    }

    /**
     * Teste para o método store com dados inválidos
     */
    public function test_store_fails_with_invalid_data()
    {
        $data = [
            'from' => 'test@example.com', // Outros campos obrigatórios faltando
        ];

        // Crie um usuário e autentique via Sanctum
        $user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/emails', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['affiliate_id', 'envelope', 'subject']);
    }

    /**
     * Teste para o método show - Exibir um email pelo ID
     */
    public function test_show_returns_email_by_id()
    {
        // Crie um usuário e autentique via Sanctum
        $user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($user, 'sanctum');

        $email = SuccessfulEmail::factory()->create();

        $response = $this->getJson('/api/emails/' . $email->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'from' => $email->from,
        ]);
    }

    /**
     * Teste para o método show com ID inválido
     */
    public function test_show_returns_404_if_email_not_found()
    {
        // Crie um usuário e autentique via Sanctum
        $user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/emails/999');

        $response->assertStatus(404);
        $response->assertJsonFragment(['message' => 'Email not found']);
    }

    /**
     * Teste para o método update - Atualizar um email
     */
    public function test_update_successful_email()
    {
        $email = SuccessfulEmail::factory()->create([
            'from' => 'test@example.com',
            'subject' => 'Old Subject',
        ]);

        $updateData = [
            'subject' => 'Updated Subject',
        ];
        // Crie um usuário e autentique via Sanctum
        $user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($user, 'sanctum');

        $response = $this->putJson('/api/emails/' . $email->id, $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('successful_emails', [
            'id' => $email->id,
            'subject' => 'Updated Subject',
        ]);
    }

    /**
     * Teste para o método update com validação parcial
     */
    public function test_update_fails_with_invalid_data()
    {
        // Crie um usuário e autentique via Sanctum
        $user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($user, 'sanctum');

        $email = SuccessfulEmail::factory()->create();

        $updateData = [
            'affiliate_id' => 'invalid', // Dado inválido
        ];

        $response = $this->putJson('/api/emails/' . $email->id, $updateData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['affiliate_id']);
    }

    /**
     * Teste para o método destroy - Soft delete de um email
     */
    public function test_destroy_soft_deletes_email()
    {
        // Crie um usuário e autentique via Sanctum
        $user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($user, 'sanctum');

        $email = SuccessfulEmail::factory()->create();

        $response = $this->deleteJson('/api/emails/' . $email->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Email deleted successfully']);
        $this->assertSoftDeleted('successful_emails', ['id' => $email->id]);
    }

    /**
     * Teste para o método destroy com ID inválido
     */
    public function test_destroy_returns_404_if_email_not_found()
    {
        // Crie um usuário e autentique via Sanctum
        $user = User::factory()->create();

        // Autentica o usuário
        $this->actingAs($user, 'sanctum');

        $response = $this->deleteJson('/api/emails/999');

        $response->assertStatus(404);
        $response->assertJsonFragment(['message' => 'Email not found']);
    }
}
