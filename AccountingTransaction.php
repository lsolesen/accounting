<?php
/**
 * @see http://www.martinfowler.com/eaaDev/AccountingTransaction.html
 */
require_once 'Entry.php';

class AccountingTransaction {
    private $date;
    private $voucher;
    private $entries = array();

    public function __construct($date, $voucher)
    {
        $this->date = $date;
        $this->voucher = $voucher;
    }

    public function addEntry($debet, $credit, $account)
    {
        $this->entries[] = new Entry($debet, $credit, $this->date, $account, $this->voucher, $this);
    }

    public function post()
    {
        if (!$this->canPost()) return false;
        foreach ($this->entries AS $entry) {
            $entry->post();
        }
        return true;
    }

    public function canPost()
    {
        if ($this->balance() <> 0) return false;
        if (!$this->voucher->year->isDateInYear($this->date)) return false;
        return true;
    }

    public function balance()
    {
        if (count($this->entries) == 0) return 0;
        $result = 0;
        foreach($this->entries AS $entry) {
            $result += $entry->balance();
        }
        return $result;
    }
}
?>