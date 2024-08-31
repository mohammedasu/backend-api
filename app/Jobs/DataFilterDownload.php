<?php

namespace App\Jobs;

use App\Exceptions\CustomErrorException;
use App\Exports\DataFilterExport;
use App\Helpers\DataFilterHelper;
use App\Http\Controllers\DataFiltersController;
use App\Models\DataFilter;
use App\Repositories\DataFilterRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DataFilterDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataFilter;

    public function __construct(DataFilter $dataFilter)
    {
        $this->dataFilter = $dataFilter;
    }

    public function handle(){

        try {

            $dataFilter = DataFilterHelper::getFilterData($this->dataFilter->id, 'download');

            $filename =  $this->dataFilter->name . Carbon::now()->toDateTimeString() . '_data_filter.csv';

            Excel::store(new DataFilterExport($dataFilter), 'download/' . $filename, 's3');

            $params['download_in_process'] = false;
            $params['download_processed_at'] = Carbon::now();
            $params['download_file_name'] = $filename;
            $data_filter_repository = new DataFilterRepository();
            $data = $data_filter_repository->update($params,['id' => $this->dataFilter->id]);
            if(!$data) {
                throw new CustomErrorException(null, 'Something went wrong with download csv file', 500);
            }

            return;

        }catch(\Exception $e){
            Log::info(['Exception while computing download' => $e->getMessage()]);
            throw new CustomErrorException($e->getMessage(), 'Exception while computing download', 500);
        }
    }
}
