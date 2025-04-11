<?php

namespace Eyegil\NotificationSmtp\Services;

use Eyegil\NotificationBase\Dtos\NotificationDto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Mail\Factory as MailFactory;
use DOMDocument;

class SMTPEngineService extends Mailable
{
    use Queueable, SerializesModels;

    private string $template;

    private NotificationDto $notificationDto;

    public function __construct(string $template, NotificationDto $notificationDto)
    {
        $this->template = $template;
        $this->notificationDto = $notificationDto;
    }

    public function envelope()
    {
        return new Envelope(
            from: new Address($this->notificationDto->from ?? env("MAIL_FROM_ADDRESS", 'do-not-reply@eyegil.com'), $this->notificationDto->alias ?? env("MAIL_FROM_NAME", 'do-not-reply')),
            subject: $this->notificationDto->subject ?? 'No Subject'
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: $this->template,
        );
    }

    public function attachments()
    {
        $attachments = [];
        if ($this->notificationDto->attachments)
            foreach ($this->notificationDto->attachments as $index => $attachment) {
                $attachments[] = Attachment::fromData(fn() => base64_decode($attachment['content']), $attachment['filename'])
                    ->withMime($attachment['mime']);
            }
        return $attachments;
    }

    // public function send($mailer)
    // {
    //     return $this->withLocale($this->locale, function () use ($mailer) {
    //         $this->prepareMailableForDelivery();

    //         $mailer = $mailer instanceof MailFactory
    //             ? $mailer->mailer($this->mailer)
    //             : $mailer;

    //         return $mailer->send($this->buildView(), $this->buildViewData(), function ($message) {
    //             $this->embedInlineData($message);

    //             $this->buildFrom($message)
    //                 ->buildRecipients($message)
    //                 ->buildSubject($message)
    //                 ->buildTags($message)
    //                 ->buildMetadata($message)
    //                 ->runCallbacks($message)
    //                 ->buildAttachments($message);
    //         });
    //     });
    // }
    // private function embedInlineData(&$message)
    // {
    //     $dom = new DOMDocument();
    //     @$dom->loadHTML($this->template, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    //     $imgTags = $dom->getElementsByTagName('img');
    //     $cidCounter = 1;

    //     foreach ($imgTags as $imgTag) {
    //         $src = $imgTag->getAttribute('src');

    //         if (preg_match('/^data:image\/(?<mime>[^;]+);base64,(?<data>.+)$/', $src, $matches)) {
    //             $imgTag->setAttribute('src', $message->embedData(base64_decode($matches['data']), 'image_' . $cidCounter++ . '.' . $matches['mime']));
    //         }
    //     }
    //     $dom->saveHTML();
    // }
}
