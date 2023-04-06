<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\User;
/**
 * @property int $id
 * @property string $body
 * @property string $subject
 * @property int $from
 * @property int $to
 * @property bool $was_replied
 */
class EmailMessageResource extends ResourceCollection
{

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id??null,
            'body' => $this->body??null,
            'subject' => $this->subject??null,
            'from' => $this->from ? self::getEmailById($this->from):null,
            'to' => $this->to ? self::getEmailById($this->to):null,
            'was_replied' => $this->was_replied??null,
        ];
    }

    protected function getEmailById($user):string|null
    {
        return User::where('id',$user)->first()->email??null;
    }
}
