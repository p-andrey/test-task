<?php

namespace App\Jobs;

use App\Contracts\NHTSAClientInterface;
use App\Models\Make;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportModelsJob implements ShouldQueue
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
        Make::whereNotNull('remote_id')->each(function (Make $make) {
            foreach ($this->NHTSAClient->getAllModelsByMakeId($make->remote_id) as $item) {
                $model = $make->models()->where('remote_id', $item['id'])->first();
                if ($model) {
                    $model->update(['name' => $item['name']]);
                } else {
                    $make->models()->create(['remote_id' => $item['id'], 'name' => $item['name']]);
                }
            }
        });
    }
}
