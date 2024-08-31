<?php

namespace App\Repositories;

use App\Models\CmeMap;

class CmeMapRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new CmeMap();
    }

    public function storeMultiple(array $params)
    {
        return $this->model->insert($params);
    }

    public function update(array $params,$mapped_id)
    {
        return $this->model->find($mapped_id)->update($params);
    }

    public function destroy(CmeMap $cmeMap)
    {
        return $cmeMap->delete();
    }

}
