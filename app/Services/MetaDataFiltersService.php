<?php

namespace App\Services;

class MetaDataFiltersService
{
    public int $metaDataPoint = 0;
    protected string $text;
    public function __construct(string $text)
    {
        $methods = get_class_methods($this);
        $this->text = strtolower($text);
        forEach($methods as $method)
        {
            if($method != '__construct')
            {
                $this->{$method}();
            }
        }
        return $this->metaDataPoint;
    }

    function checkIfContainsEmail(): void
    {
        $this->metaDataPoint += preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/si',$this->text);
    }
    function checkIfEmailContainsRedWords(): void
    {
        $redWords = [
            'wrote',
            'write',
            'said',
            ' >',
            'sent',
            'dec',
            'december',
            'jan',
            'january',
            'feb',
            'february',
            'mar',
            'march',
            'apr',
            'april',
            'may',
            'jun',
            'june',
            'jul',
            'july',
            'aug',
            'august',
            'sep',
            'september',
            'oct',
            'october',
            'nov',
            'november',
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
            'from',
            'to',
            'cc',
            'bcc',
            'subject',
            're:',
            'fw:',
            'fwd',
        ];
        foreach ($redWords as $redWord)
        {
            $this->metaDataPoint += str_contains($this->text,$redWord);
        }
    }
}
