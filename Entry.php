<?php
class Entry {
    public $debet;
    public $credit;
    private $date;
    private $account;
    private $voucher;
    private $transaction;

    function __construct($debet, $credit, $date, $account, $voucher, $transaction)
    {
        $this->debet = $debet;
        $this->credit = $credit;
        $this->date = $date;
        $this->account = $account;
        $this->voucher = $voucher;
        $this->transaction = $transaction;
    }

    function balance()
    {
        return ($this->debet - $this->credit);
    }

    function post()
    {
        $this->account->addEntry($this);
        $this->voucher->addEntry($this);
    }
}
?>