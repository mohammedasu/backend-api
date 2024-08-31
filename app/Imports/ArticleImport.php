<?php

namespace App\Imports;

use App\Models\Article;
use App\Community;
use App\Services\CommunityService;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationData;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ArticleImport implements ToModel, WithStartRow,WithValidation, WithHeadingRow,SkipsOnFailure
{

    use Importable,SkipsFailures;

    public function model(array $row)
    {
        $community_service = new CommunityService();
        $where = ['title' => $row['community']];
        $community = $community_service->fetch($where);
        $timestamp = ($row['article_schedule_date']) ? Carbon::parse($row['article_schedule_date']) : null;
        return new Article([
            'community_id' => ($community) ? $community->id : null,
            'card_name' => $row['card_name'],
            'article_timestamp' => $timestamp,
            'header' => $row['header'],
            'journal' => $row['journal'],
            'small_description' => $row['small_description'],
            'link' => $row['link'],
            'ip_address' => '127.0.0.1',
            'is_active' => 0
        ]);
    }

    /**
     * @return int
     */
    public function startRow() : int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
             'community' => 'required',
        ];
    }

}
