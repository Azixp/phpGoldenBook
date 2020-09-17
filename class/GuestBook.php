<?php
require_once 'Message.php';

class GuestBook
{
    //ATTR
    protected $filePath;

    //__CONSTRUCT
    public function __construct(string $filePath)
    {
        $directory = dirname($filePath);
        if(!is_dir($directory)){
            mkdir($directory, 0777, true);
        }
        if(!file_exists($filePath)){
            touch($filePath);
        }
        $this->setFilePath($filePath);
    }

    //GETTERS
    public function getFilePath() : string { return $this->filePath; }

    
    //METHODES
    public function addMesssage(Message $message)
    {
        file_put_contents($this->filePath, $message->toJSON() . PHP_EOL, FILE_APPEND);
    }

    public function getMessages()
    {
        $contents = trim(file_get_contents($this->filePath));
        if($contents == false){
            return $contents;
        }
        $lines = explode(PHP_EOL, $contents);
        $tabLines = [];
        foreach ($lines as $line) {
            $tabLines[] = Message::fromJSON($line);
        }
        return array_reverse($tabLines);
    }

    //SETTERS
    public function setFilePath(string $filePath)
    {
        $this->filePath = $filePath;
    }
}