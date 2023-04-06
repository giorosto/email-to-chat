<?php

namespace App\Services;

use App\Http\Resources\EmailMessageResource;
use App\Interfaces\MailInterface;
use App\Models\EmailMessage;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class MailServices implements MailInterface
{
    public function getUnreplayedMessages()
    {
        return EmailMessage::where('was_replied', 0)->get();
    }
     public function compareMessages($messageToCompare,$replayFrom)
     {
        $messagesToCompare = self::getUnreplayedMessages();
        foreach ($messagesToCompare as $message) {
            if (str_contains($messageToCompare, $message->body) !== false) {
                //$message->was_replied = 1;
                $message->save();
                $explodedText = explode($message->body,$messageToCompare);
                $extractedMessage = self::determineMetaData($explodedText);
                Log::info($extractedMessage);
                self::storeEmailMessage($extractedMessage,$message->from,self::determineFromWhoIsMessage($replayFrom));
                return $extractedMessage;

            }
        }
        return 'no match found';
     }
     function determineFromWhoIsMessage($email):int
     {
        return User::where('email',$email)->first()->id;
     }
     function determineMetaData(array $texts)
     {
        $firstPartMetadataPoint = new MetaDataFiltersService($texts[0]);
        $firstPartMetadataPoint = $firstPartMetadataPoint->metaDataPoint;
        $secondPartMetadataPoint = new MetaDataFiltersService($texts[1]);
        $secondPartMetadataPoint = $secondPartMetadataPoint->metaDataPoint;
        if ($firstPartMetadataPoint > $secondPartMetadataPoint) {
            return $texts[1];
        } else {
            return $texts[0];
        }
     }
     function storeEmailMessage($message,$from, $to)
     {
        $emailMessage = new EmailMessage();
        $emailMessage->body = $message;
        $emailMessage->from = $from;
        $emailMessage->to = $to;
        $emailMessage->save();
     }

}


