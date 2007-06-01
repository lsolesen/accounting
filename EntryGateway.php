<?php
class EntryGateway
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @return array Entries
     */
    public function getEntriesOnVoucher($voucher_id)
    {
        $entries = array();
        $result = $this->db->query('SELECT * FROM entry WHERE voucher_id = ' . $this->db->quote($voucher_id, 'integer'));
        while ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)) {
            $entries[] = new Entry($row);
        }
        return $entries;
    }
}
?>