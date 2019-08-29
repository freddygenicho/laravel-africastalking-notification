<?php


namespace FreddyGenicho\Africastalking\Channel;

use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Notifications\Notification;

class AfricasTalkingChannel
{

    /** The AfricasTalking instance
     *
     * @var AfricasTalking
     */
    protected $africasTalking;

    public function __construct(AfricasTalking $africasTalking)
    {
        $this->africasTalking = $africasTalking;
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
        return $sms->send(['to' => $to, 'message' => $africasTalkingMessage->message]);
    }
}
