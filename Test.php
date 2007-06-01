<?php
// http://www.martinfowler.com/eaaDev/AccountingNarrative.html
// http://www.martinfowler.com/eaaDev/Account.html
// http://www.martinfowler.com/eaaDev/AccountingEntry.html
// http://www.martinfowler.com/eaaDev/ReplacementAdjustment.html
// http://www.martinfowler.com/eaaDev/AccountingTransaction.html
// http://www.martinfowler.com/eaaDev/ReversalAdjustment.html

require 'Year.php';
require 'Voucher.php';
require 'Account.php';

class Test {
    private $tests = array();
    function assertEqual($a, $b) {
        $this->tests[] = ($a === $b);
    }
    function run() {
        $error = 'no error';
        foreach ($this->tests AS $test) {
            if ($test === false) $error = 'error';
        }
        return $error;
    }
}

$year = new Year();

$voucher = new Voucher($year, 1);
$deferred_account = new Account(1);
$revenue_account = new Account(2);

$revenue_account->debet(700, $deferred_account, $voucher, '2007-02-07');

$test = new Test;
$test->assertEqual(-700, $revenue_account->balance());

$revenue_account->credit(700, $deferred_account, $voucher, '2007-02-07');

$test->assertEqual(0, $revenue_account->balance());
$test->assertEqual(0, $voucher->balance());
echo $test->run();
?>