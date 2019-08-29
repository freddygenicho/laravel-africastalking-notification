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
     * AfricasTalkingChannel constructor.
     * @param AfricasTalking $africasTalking
     */
    public function __construct(AfricasTalking $africasTalking)
    {
        $this->africasTalking = $africasTalking;
    }

    /**
     * Send the given notification.
     * @param $notifiable
     * @param Notification $notification
     * @return array|void
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('africasTalking', $notification)) {
            return;
        }

        $message = $notification->toAfricasTalking($notifiable);

        $content = $message->content;
        $from = $message->from;

        $payload = [
            'to' => $to,
            'message' => $content,
        ];

        if (isset($from)) {
            $payload['from'] = $from;
        } else {
            $from = config('africastalking.sender_id');
            if (isset($from)) {
                $payload['from'] = $from;
            }
        }

        $sms = $this->africasTalking->sms();

        return $sms->send($payload);
    }
}
