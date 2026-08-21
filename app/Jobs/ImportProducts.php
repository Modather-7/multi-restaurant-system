<?php

namespace App\Jobs;

use App\Imports\ProductsImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ImportProducts implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $path, protected int $restaurantId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::import(
            new ProductsImport($this->restaurantId),
            $this->path
        );
    }
}
