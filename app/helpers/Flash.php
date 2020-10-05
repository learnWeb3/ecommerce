<?php

class Flash
{

    public $messages;
    public $type;

    public function __construct(array $messages, string $type)
    {
        $this->messages = $messages;
        $this->type = $type;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getType()
    {
        return $this->type;
    }

    public function updateMessages(array $old_messages)
    {
        $this->messages = array_merge($old_messages, $this->getMessages());
        return $this;
    }

    public function setMessages(array $messages)
    {
        $this->messages = $messages;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function storeInSession()
    {
        if (isset($_SESSION['flash'])) {
            $this->updateMessages($_SESSION['flash']->getMessages());
        }
        $_SESSION['flash'] = $this;

        return $this;
    }

    public static function getFlash()
    {
        if (isset($_SESSION["flash"])) {
            return $_SESSION["flash"];
        } else {
            return array();
        }
    }

    public static function removeFlash()
    {
        unset($_SESSION["flash"]);
    }
}
