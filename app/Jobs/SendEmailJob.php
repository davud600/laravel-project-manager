<?php

namespace App\Jobs;

use App\Mail\ProjectEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $toEmail;
    private $emailData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $toEmail, array $emailData)
    {
        $this->toEmail = $toEmail;
        $this->emailData = $emailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->toEmail)
            ->send(new ProjectEmail($this->emailData));
    }
}
