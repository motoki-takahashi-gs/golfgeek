<?php

require_once __DIR__ . '/../includes/functions.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendEmail extends Dbh
{
    private $senderHost;
    private $senderUserName;
    private $senderEmail;
    private $senderPassword;
    private $senderName;
    private $userType;
    private $userId;
    private $recipientEmail;
    private $recipientName;
    private $emailSubject;
    private $emailBody;
    private $questionId;

    public function __construct($userType, $userId)
    {
        $this->senderHost = $_ENV['EMAIL_SENDER_HOST'];
        $this->senderUserName = $_ENV['EMAIL_SENDER_USER_NAME'];
        $this->senderEmail = $_ENV['EMAIL_SENDER_EMAIL'];
        $this->senderPassword = $_ENV['EMAIL_SENDER_PASSWORD'];
        $this->senderName = 'Golf Geek サポート';
        $this->userType = $userType;
        $this->userId = $userId;
    }

    public function setContentsForSos($questionId)
    {
        $this->questionId = $questionId;
        if ($this->userType == 'golfers') {
            $this->emailSubject = 'SOSをお受けしました。';
            $this->emailBody = '<p>SOSいただきありがとうございます。<br>返信があり次第お知らせいたします。</p>';
            $this->emailBody .= '<p>▼以下のURLからログインして、内容をご確認いただけます。<br>';
        } else if ($this->userType == 'teaching_pros') {
            $this->userId = filter_input(INPUT_POST, 'golfer_id');
            $this->questionId = filter_input(INPUT_POST, 'question_id');
            $this->emailSubject = 'SOSに対して返信がありました。';
            $this->emailBody = '<p>お待たせいたしました。<br>SOSに対して返信がありました。</p>';
            $this->emailBody .= '<p>▼以下のURLからログインして内容をご確認ください。<br>';
        }
        $this->emailBody .= 'http://' . $_SERVER['HTTP_HOST'] . '/question-details.php?id=' . $this->questionId . '</p>';
    }

    public function setContentsForSignUp($verificationKey)
    {
        $this->emailSubject = '仮のアカウントが作成されました。';
        $this->emailBody = '<p>アカウントを作成いただき、ありがとうございます。</p>';
        $this->emailBody .= '<p>▼ログインした状態で以下のURLにアクセスすると、アカウントが認証されます。<br>';
        $this->emailBody .= 'http://' . $_SERVER['HTTP_HOST'] . '/signup-verification.php?key=' . $verificationKey . '</p>';
    }

    private function selectGolfer()
    {
        $sql = "SELECT first_name, last_name, email FROM golfers WHERE id = " . $this->userId;
        $sth = $this->connectDatabase()->prepare($sql);
        $status = $sth->execute();
        return $status == false ? $this->getSqlError($sth) : $sth;
    }

    private function setRecipientInfo()
    {
        $sth = $this->selectGolfer();
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        $this->recipientEmail = $row['email'];
        $this->recipientName = $row['last_name'] . " " . $row['first_name'];
    }

    public function sendEmail()
    {
        $this->setRecipientInfo();

        //Load Composer's autoloader
        require_once '../vendor/autoload.php';

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->senderHost;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->senderUserName;                     //SMTP username
            $mail->Password   = $this->senderPassword;                               //SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = "UTF-8";

            //Recipients
            $mail->setFrom($this->senderEmail, $this->senderName);
            $mail->addAddress($this->recipientEmail, $this->recipientName);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo($this->senderEmail, $this->senderName);
            // $mail->addCC('cc@example.com');
            $mail->addBCC($this->senderEmail);

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $this->emailSubject;
            $mail->Body    = $this->emailBody;
            // $mail->AltBody = '';

            $mail->send();
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
