<?php
require_once 'AccountingTransaction.php';

class Account {
    private $entries;

    function addEntry($entry)
    {
        $this->entries[] = $entry;
    }

    function balance()
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
    function debet($amount, $target_account, $voucher, $date)
    {
        $transaction = new AccountingTransaction($date, $voucher);
        $transaction->addEntry($amount, 0, $target_account);
        $transaction->addEntry(0, $amount, $this);
        $transaction->post();
    }
    /**
     * Used only for two-legged transactions
     */
    function credit($amount, $target_account, $voucher, $date)
    {
        $transaction = new AccountingTransaction($date, $voucher);
        $transaction->addEntry(0, $amount, $target_account);
        $transaction->addEntry($amount, 0, $this);
        $transaction->post();
    }
}
?>