<?php

namespace App\Jobs\GithubWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\GitHubWebhooks\Models\GitHubWebhookCall;
use Symfony\Component\Process\Exception\ProcessFailedException;

class HandleDeployApp implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public GitHubWebhookCall $webhookCall
    ) {
    }

    public function handle(): void
    {
        $process = Process::run(['chmod +x ../deploy.sh']);
        $process = Process::run(['sh ../deploy.sh']);

        echo $process->output();

        Log::alert($process->output());
    }
}
