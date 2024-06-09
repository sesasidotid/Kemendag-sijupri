<?php

namespace App\Http\Controllers\Notification\Service;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class NotificationSMTPService extends Mailable
{
    use Queueable, SerializesModels;

    private $notificationTemplate;

    private $options;

    public function __construct($notification_template_code, array $options)
    {
        $this->notificationTemplate = new NotificationTemplateService();
        $this->notificationTemplate = $this->notificationTemplate->findById($notification_template_code);
        $this->options = $options;
    }

    public function envelope()
    {
        return new Envelope(
            from: new Address($this->options['from'] ?? env("MAIL_USERNAME"), $this->options['name'] ?? 'do-not-reply'),
            subject: $this->options['subject'] ?? []
        );
    }

    public function content()
    {
        return new Content(
            view: $this->notificationTemplate->template,
            with: $this->options['params'] ?? []
        );
    }

    public function attachments()
    {
        return $this->options['attachments'] ?? [];
    }
}
