<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuccessfulEmail extends Model
{
    use HasFactory, SoftDeletes;

    // Nome da tabela associada a este modelo
    protected $table = 'successful_emails';

    // Indica quais os campos podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'affiliate_id',
        'envelope',
        'from',
        'subject',
        'dkim',
        'SPF',
        'spam_score',
        'email',
        'raw_text',
        'sender_ip',
        'to',
        'timestamp',
    ];

    // Caso a tabela use timestamps (created_at, updated_at)
    public $timestamps = true;

    // Se o campo 'deleted_at' existir, é possível utilizar SoftDeletes
    protected $dates = ['deleted_at'];
}
