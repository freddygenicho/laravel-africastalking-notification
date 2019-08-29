<?php


namespace FreddyGenicho\AfricasTalking\Channel;

use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Notifications\Notification;

class AfricasTalkingChannel
{

    /** The AfricasTalking instance
     *
     * @var AfricasTalking
     */
    protected $africasTalking;

    /**
     * @var string
     */
    protected $senderId;

    public function __construct(AfricasTalking $africasTalking, $senderId = null)
    {
        $this->africasTalking = $africasTalking;
        $this->senderId = $senderId;
    }

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return array|void
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('africasTalking', $notification)) {
            return;
        }

        $africasTalkingMessage = $notification->toAfricasTalking($notifiable);
        $sms = $this->africasTalking->sms();

        $payload = [
            'to' => $to,
            'message' => $africasTalkingMessage->message
        ];

        if (isset($this->senderId)) {
            if (empty(trim($this->senderId))) {
                $payload['from'] = $this->senderId;
            }
        }

        return $sms->send($payload);
    }
}
