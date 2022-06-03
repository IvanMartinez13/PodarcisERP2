<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubtaskAddMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = "Nueva tarea";

    public $user;
    public $task;
    public $project;
    public $subtask;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($task, $project, $user, $subtask)
    {

        $this->user = $user;
        $this->task = $task;
        $this->project = $project;
        $this->subtask = $subtask;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.subtask_add');
    }
}
