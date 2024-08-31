<?php

namespace App\Repositories;

use App\Models\Cme;
use App\Constants\Constants;

class CmeRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Cme();
    }

    public function getAll($request)
    {
        $cmes = $this->model->query();
        if ($request->has('search')) {
            $cmes->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('nopagination')) {
            return $cmes->orderBy('id', 'desc')->get();
        }
        return $cmes->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
    }

    public function store(array $params)
    {
        return $this->model->create($params);
    }

    public function update(array $params, Cme $cme)
    {
        $cme->update($params);
        return $cme->refresh();
    }

    public function destroy(Cme $cme)
    {
        $cme->questions()->delete();
        $cme->attachments()->delete();
        $cme->delete();
    }

    public function updateWithTrashed($where, $request)
    {
        $entity = $this->model::withTrashed()->where($where)->first();
        if (!empty($entity)) {
            $entity->update($request);
            return $entity->refresh();
        }
    }
}
