<?php

require_once __DIR__ . '/../includes/functions.php';

class Verification extends Dbh
{
    private $golferId;
    private $verificationKey;
    private $verificationMessage;

    public function __construct()
    {
        $this->golferId = isset($_SESSION['golfer_id']) ? $_SESSION['golfer_id'] : null;
        $this->verificationKey = filter_input(INPUT_GET, 'key');
    }

    public function getGolferId()
    {
        return $this->golferId;
    }

    public function getVerificationKey()
    {
        return $this->verificationKey;
    }

    private function selectGolfer($verified)
    {
        $sql = 'SELECT id FROM golfers WHERE id = :id AND verification_key = :verification_key AND verified = ' . $verified;
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':id', $this->golferId, PDO::PARAM_INT);
        $sth->bindValue(':verification_key', $this->verificationKey, PDO::PARAM_STR);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    public function getGolfer($verified)
    {
        $sth = $this->selectGolfer($verified);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    private function updateGolfer()
    {
        $sql = 'UPDATE golfers SET verified = 1 WHERE id = :id AND verification_key = :verification_key';
        $sth = $this->connectDatabase()->prepare($sql);
        $sth->bindValue(':id', $this->golferId, PDO::PARAM_INT);
        $sth->bindValue(':verification_key', $this->verificationKey, PDO::PARAM_STR);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : true;
    }

    public function updateAccountAsVerified()
    {
        if ($this->updateGolfer() != true) return;
        $this->setVerificationMessage('アカウントが認証されました！');
    }

    public function setVerificationMessage($message)
    {
        $this->verificationMessage = $message;
    }

    public function getVerificationMessage()
    {
        return $this->verificationMessage;
    }
}
