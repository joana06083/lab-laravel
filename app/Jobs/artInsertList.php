<?php

namespace App\Jobs;

use App\Models\ArticleInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class artInsertList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $arrData;

    /**
     * Create a new job instance.
     * @param  \App\Models\ArticleInfo  $artdetails
     * @return void
     */
    public function __construct($arrData)
    {
        printf("created a job!");
        $this->arrData = $arrData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ArticleInfo::insert($this->arrData);
        printf("Insert into article success!");

    }
}
