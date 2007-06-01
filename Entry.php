<?php
class Entry {
    public $debet;
    public $credit;

    private $id;
    private $date;
    private $account;
    private $voucher;
    private $transaction;

    public function __construct($debet, $credit, $date, $account, $voucher, $transaction)
    {
        $this->debet = $debet;
        $this->credit = $credit;
        $this->date = $date;
        $this->account = $account;
        $this->voucher = $voucher;
        $this->transaction = $transaction;
    }

    public function balance()
    {
        return ($this->debet - $this->credit);
    }

    public function post()
    {
        $this->account->addEntry($this);
        $this->voucher->addEntry($this);
    }

    public function save($db)
    {
        if ($this->id) {
            $this->update($db);
        } else {
            $this->insert($db);
        }
    }

    private function insert($db) {
        $db->exec("INSERT INTO entry (voucher) VALUES (:voucher)", Array(':voucher' => $this->voucher));
        $this->id = $db->insertId();
    }

    private function update($db) {
        $db->exec("UPDATE entry SET voucher=:voucher", Array(':voucher' => $this->voucher));
        $this->id = $db->insertId();
    }
}
?>