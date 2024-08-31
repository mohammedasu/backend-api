<?php
namespace App\Services;
use App\Repositories\CaseCommentRepository;
use Illuminate\Support\Facades\Log;

class CaseCommentService
{
    protected $repository;
    public function __construct()
    {
        $this->repository = new CaseCommentRepository();
    }
    
    public function destroy($id)
    {
        Log::info('CaseCommentService | destroy', ['id' => $id]);
        $where = ['case_id' => $id];
        return $this->repository->destroy($where);
    }

    public function updateStatus($request)
    {
        Log::info('CaseCommentService | updateStatus', $request->all());
        $params = ['is_approved' => $request->is_approved];
        $where = ['id' => $request->id];
        
        $case = $this->repository->updateWithTrashed($where,$params);
    }
}