<?php
class Message
{
    //CONST
    const LIMIT_USERNAME = 5;
    const LIMIT_USERMESSAGE = 10;

    //ATTR
    protected $userName;
    protected $userMessage;
    protected $messageDate;

    //__CONSTRUCT
    public function __construct(string $userName, string $userMessage, ?DateTime $messageDate = null)
    {
        $this->setUserName($userName);
        $this->setUserMessage($userMessage);

        if(!(isset($messageDate))){
            $createDate = new DateTime('Now');
            $createDate->setTimezone(new DateTimeZone('Europe/Paris'));
            $this->setMessageDate($createDate);
        }else{
            $messageDate->setTimezone(new DateTimeZone('Europe/Paris'));
            $this->setMessageDate($messageDate);
        }
    }

    //STATIC METHODES
    public static function fromJSON(string $jsonData)
    {
        return json_decode($jsonData);
    }

    public static function toHTML($username, $message, $date) : string 
    {   
        $user = htmlentities($username); 
        $userMessage = nl2br(htmlentities($message));
        $dateMessage = htmlentities($date);

        return "<p><strong>$user</strong> <em>$dateMessage</em><br>$userMessage</p>";  
    } 

    //METHODES
    public function isValid() : bool
    {
        if((strlen($this->userName) >= self::LIMIT_USERNAME) && (strlen($this->userMessage) >= self::LIMIT_USERMESSAGE)){
            return true;
        }else{
            return false;
        }
    }

    public function getErrors() : array
    {
        $errors = [];
        if(strlen($this->userName) < self::LIMIT_USERNAME){
            $errors['errorUserName'] = 'Your login is too short !';
        }
        if(strlen($this->userMessage) < self::LIMIT_USERMESSAGE){
            $errors['errorMessage'] = 'Your message is too short !';
        }
        return $errors;
    }

    public function toJSON() : string
    {
        $data = [
            'username' => $this->userName,
            'message' => $this->userMessage,
            'date' => $this->messageDate,
        ];

        return json_encode($data);
    }

    //GETTERS
    public function getUserName() : string { return $this->username; }
    public function getUserMessage() : string { return $this->userMessage; }
    public function getMessageDate() : string { return $this->messageDate; }

    //SETTERS
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }

    public function setUserMessage(string $userMessage)
    {
        $this->userMessage = $userMessage;
    }

    public function setMessageDate(DateTime $messageDate)
    {
        $this->messageDate = $messageDate->format('d/m/yy à H:i:s');
    }
}