--TEST--
Accounting Test
--FILE--
<?php
//http://qa.php.net/write-test.php
require 'Year.php';
require 'Voucher.php';
require 'Account.php';

{
    $year = new Year();
    $voucher = new Voucher($year, 1);

    $deferred_account = new Account(1);
    $revenue_account = new Account(2);

    $revenue_account->debet(700, $deferred_account, $voucher, '2007-02-07');
    var_dump($revenue_account->balance());
}

{
    $revenue_account->credit(700, $deferred_account, $voucher, '2007-02-07');
    var_dump($revenue_account->balance());
}
{
    var_dump($voucher->balance());
}


?>
--EXPECT--
int(-700)
int(0)
int(0)