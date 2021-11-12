<?php

require_once __DIR__ . '/../includes/functions.php';

class Gender extends Dbh
{
    private function selectGenders()
    {
        $sql = 'SELECT id, name FROM genders ORDER BY id ASC';
        $sth = $this->connectDatabase()->prepare($sql);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    public function getGenderOptions()
    {
        $sth = $this->selectGenders();
        $gender = '<option disabled selected value>性別</option>';
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $gender .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
        return $gender;
    }
}
