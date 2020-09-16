<?php

namespace App\Jobs;

use App\Contracts\NHTSAClientInterface;
use App\Models\Make;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportMakesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var NHTSAClientInterface
     */
    private $NHTSAClient;

    /**
     * Create a new job instance.
     *
     * @param  NHTSAClientInterface  $NHTSAClient
     */
    public function __construct(NHTSAClientInterface $NHTSAClient)
    {
        $this->NHTSAClient = $NHTSAClient;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->NHTSAClient->getAllMakes() as $item) {
            $model = Make::where('remote_id', $item['id'])->first();
            if ($model) {
                $model->update(['name' => $item['name']]);
            } else {
                Make::create(['remote_id' => $item['id'], 'name' => $item['name']]);
            }
        }
    }
}
