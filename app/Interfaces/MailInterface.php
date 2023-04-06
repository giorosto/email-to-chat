<?php

namespace App\Interfaces;

use App\Http\Resources\EmailMessageResource;

interface MailInterface
{
    public function compareMessages(string $messageToCompare, string $replayFrom);
    public function getUnreplayedMessages();
}
