<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Services\MailServices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use \Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;
use Webklex\PHPIMAP\Exceptions\FolderFetchingException;
use Webklex\PHPIMAP\Folder;
use Webklex\PHPIMAP\Message;
use App\Interfaces\MailInterface;

class ImapListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imap:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $cm = new ClientManager($options = []);
        $client = $cm->make([
            'host' => env('IMAP_HOST'),
            'port' => env('IMAP_PORT'),
            'encryption' => env('IMAP_ENCRYPTION'),
            'validate_cert' => env('IMAP_VALIDATE_CERT'),
            'username' => env('IMAP_USERNAME'),
            'password' => env('IMAP_PASSWORD'),
            'protocol' => 'imap'
        ]);

        $client->connect();
        try {
            $client->connect();
        } catch (ConnectionFailedException $e) {
            Log::error($e->getMessage());
            return 1;
        }

        /** @var Folder $folder */
        try {
            $folder = $client->getFolder("INBOX");
        } catch (ConnectionFailedException $e) {
            Log::error($e->getMessage());
            return 1;
        } catch (FolderFetchingException $e) {
            Log::error($e->getMessage());
            return 1;
        }

        try {
            $folder->idle(function($message){
                /** @var Message $message */
                $mailService = new MailServices();
                $mailService->compareMessages($message->getTextBody(),$message->getFrom()[0]->mail);
                if($message->move('INBOX.read') == true) {
                    Log::info( 'Message has ben moved');
                }else{
                    Log::warning('Message could not be moved');
                }
            });
        } catch (ConnectionFailedException $e) {
            Log::error($e->getMessage());
            return 1;
        }

        return 0;
    }
}
