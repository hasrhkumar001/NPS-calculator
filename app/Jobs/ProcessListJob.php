<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\Users;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessListJob implements ShouldQueue
{
    public $mergedIds;
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct($mergedIds)
    {
        $this->mergedIds =$mergedIds;
    }

    /**
     * Execute the job.
     */
    public function handle($mergedIds)
    {
        foreach ($mergedIds as $id) {
            $user = Users::find($id) ?: Admin::find($id);
            // Process user or admin
        }
    }
}
