<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Import;
use App\Models\Lead;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeadsImport;

class ProcessLeadsImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $fileName;
    protected $importId;

    public function __construct($fileName, $importId)
    {
        $this->fileName = $fileName;
        $this->importId = $importId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $import = Import::with('leads')->findOrFail($this->importId);

        try {
            $importedData = Excel::import(new LeadsImport($import), public_path().'/uploads/imports/' . $this->fileName);
            $import->status = 1;
            $import->save();
        } catch (\Exception $e) {
            $import->update([
                'status' => 3,
                'errors' => $e->getMessage(),
            ]);
        }
    }
}
