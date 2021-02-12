<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Report extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $bookLink;
    public $bookTitle;

    /**
     * Create a new message instance.
     *
     * @param string $report
     * @param string $bookLink
     * @param string $bookTitle
     */
    public function __construct(string $report, string $bookLink, string $bookTitle)
    {
        $this->report = $report;
        $this->bookLink = $bookLink;
        $this->bookTitle = $bookTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.report')
            ->to('admin@admin.com')
            ->subject(__('report.report'));
    }
}
