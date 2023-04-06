<?php

namespace App\Http\Controllers;

use App\Interfaces\MailInterface;
use App\Services\MetaDataFiltersService;
use \Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\ClientManager;

class MailController extends Controller
{
    /**
     * @var MailInterface
     */
    public MailInterface $mailMessageInterface;

    public function __construct(
        MailInterface $mailMessageInterface
    )
    {
        $this->mailMessageInterface = $mailMessageInterface;
    }


    function getMail()
    {
        $cm = new ClientManager($options = []);
        $oClient = $cm->make([
            'host' => env('IMAP_HOST'),
            'port' => env('IMAP_PORT'),
            'encryption' => env('IMAP_ENCRYPTION'),
            'validate_cert' => env('IMAP_VALIDATE_CERT'),
            'username' => env('IMAP_USERNAME'),
            'password' => env('IMAP_PASSWORD'),
            'protocol' => 'imap'
        ]);

        $oClient->connect();
        $oFolder = $oClient->getFolder('INBOX');
        $aMessage = $oFolder->messages()->all()->get();
        foreach ($aMessage as $oMessage) {
            $this->mailMessageInterface->compareMessages($oMessage->getTextBody(),$oMessage->getFrom()[0]->mail);
            if($oMessage->move('INBOX.read') == true){
                echo 'Message has ben moved';
            }else{
                echo 'Message could not be moved';
            }
        }
    }
}
