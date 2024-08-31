<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\PrivateForumInvite;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PrivateForumInviteImport implements ToCollection,WithHeadingRow
{
    protected $private_forum_rule_id;
    protected $forum_id;

    public function __construct($private_forum_rule_id,$forum_id){
        $this->private_forum_rule_id = $private_forum_rule_id;
        $this->forum_id = $forum_id;
    }

    public function collection(Collection $collection)
    {
        Log::info(['Import invitation selected' => $collection]);
        foreach($collection as $c){
         PrivateForumInvite::create([
                'mobile_number' => $c['mobile_number'],
                'email' => $c['email'],
                'private_forum_rule_id' => $this->private_forum_rule_id,
                'forum_id' => $this->forum_id,
            ]);
        }
    }
}



