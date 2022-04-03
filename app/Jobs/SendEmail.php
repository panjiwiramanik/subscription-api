<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $template;
    private $data;
    private $subject;
    private $recipient;
    private $cc;
    private $replyTo;
    private $from;
    private $fromName;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->template = $data["template"];
        $this->data = $data["data"];
        $this->subject = $data["subject"];
        $this->recipient = $data["recipient"];
        
        if (isset($data["from"]) && $data["from"] != "") {
            $this->from = $data["from"];
        }

        if (isset($data["fromname"]) && $data["fromname"] != "") {
            $this->fromName = $data["fromname"];
        }

        if (isset($data["replyTo"]) && $data["replyTo"] != "") {
            $this->replyTo = $data["replyTo"];
        }
        
        if (isset($data["cc"]) && $data["cc"] != "") {
            $this->cc = $data["cc"];
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::send($this->template, $this->data, function ($message) {
            $message->from($this->from, $this->fromName);
            $message->to($this->recipient);
            $message->subject($this->subject);

            if (!empty($this->cc)) {
                $message->cc($this->cc);
            }

            if ($this->replyTo != "") {
                $message->replyTo($this->replyTo);
            }
        });
    }
}
