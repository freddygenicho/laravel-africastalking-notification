<?php

namespace FreddyGenicho\AfricasTalking\Message;


class AfricasTalkingMessage
{

    /**
     * The text content of the message.
     *
     * @var string
     */
    public $message;

    /**
     * set message to be sent
     * @param $message
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

}
