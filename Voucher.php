<?php
class Voucher
{
    public $year;
    private $entries;

    function __construct($year) {
        $this->year = $year;
    }

    function addEntry($entry)
    {
        $this->entries[] = $entry;
    }

    function balance()
    {
        if (count($this->entries) == 0) return 0;
        $result = 0;
        foreach($this->entries AS $entry) {
            $result += $entry->debet - $entry->credit;
        }
        return $result;
    }
}
?>