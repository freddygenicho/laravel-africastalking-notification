<?php

namespace FreddyGenicho\AfricasTalking\Message;


class AfricasTalkingMessage
{

    /**
     * The text content of the message.
     *
     * @var string
     */
    public $content;

    /**
     * The sender id
     *
     * @var string
     */
    public $from;

    /**
     * set message to be sent
     * @param $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

}
