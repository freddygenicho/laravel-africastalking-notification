<?php


namespace FreddyGenicho\AfricasTalking\Channel;

use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Config\Repository;
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
        $content = trim($message->content);
        $from = $this->getFrom($notifiable, $notification);

        $payload = [
            'to' => $to,
            'message' => $content,
        ];

        if (isset($from)) {
            $payload['from'] = $from;
        }

        $sms = $this->africasTalking->sms();

        return $sms->send($payload);
    }

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return Repository|mixed|null
     */
    protected function getFrom($notifiable, Notification $notification)
    {
        if ($from = $notification->toAfricasTalking($notifiable)->getFrom()) {
            return $from;
        }

        if (function_exists('config') && $from = config('africastalking.sender_id')) {
            return $from;
        }

        return null;
    }
}
