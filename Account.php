<?php
require_once 'AccountingTransaction.php';

class Account {
    private $entries;

    public function addEntry($entry)
    {
        $this->entries[] = $entry;
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

    /**
     * Used only for two-legged transactions
     */
    public function debet($amount, $target_account, $voucher, $date)
    {
        $transaction = new AccountingTransaction($date, $voucher);
        $transaction->addEntry($amount, 0, $target_account);
        $transaction->addEntry(0, $amount, $this);
        $transaction->post();
    }
    /**
     * Used only for two-legged transactions
     */
    public function credit($amount, $target_account, $voucher, $date)
    {
        $transaction = new AccountingTransaction($date, $voucher);
        $transaction->addEntry(0, $amount, $target_account);
        $transaction->addEntry($amount, 0, $this);
        $transaction->post();
    }
}
?>