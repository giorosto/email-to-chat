<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $body
 * @property int $to
 * @property int $from
 * @property bool|null $was_replied
 */
class EmailMessage extends Model
{
    protected $fillable = [
        'body',
        'from',
        'to',
        'was_replied'
    ];

    use HasFactory;
}
