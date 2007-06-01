<?php
class Voucher
{
    public $year;

    private $id;
    private $entries;

    public function __construct($year) {
        $this->year = $year;
    }

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

    public function save($db)
    {
        if ($this->id) {
            $this->update($db);
        } else {
            $this->insert($db);
        }
    }

    private function insert($db) {
        $db->exec("INSERT INTO vouchers (year) VALUES (:year)", Array(':year' => $this->year));
        $this->id = $db->insertId();
        $this->saveEntries($db);
    }

    private function update($db) {
        $db->exec("UPDATE vouchers SET year=:year", Array(':year' => $this->year));
        $this->id = $db->insertId();
        $this->saveEntries($db);
    }

    private function saveEntries($db) {
        foreach ($this->entries as $entry) {
            $entry->save($db, $this->id);
        }
    }

    public function getEntries($db)
    {
        $gateway = new EntryGateway($db);
        return $gateway->getEntriesOnVoucher();
    }
}
?>