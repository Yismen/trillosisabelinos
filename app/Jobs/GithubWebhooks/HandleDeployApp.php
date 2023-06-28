<?php

namespace App\Jobs\GithubWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Spatie\GitHubWebhooks\Models\GitHubWebhookCall;
use Symfony\Component\Process\Exception\ProcessFailedException;

class HandleDeployApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public function __construct(
        public GitHubWebhookCall $webhookCall
    )
    {
        //
    }
    
    public function handle(): void
    {
        
        // $process = new Process(['chmod +x ../deploy.sh']);
        $process = new Process(['../deploy.sh']);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

        Log::alert($process->getOutput());
    }
}
