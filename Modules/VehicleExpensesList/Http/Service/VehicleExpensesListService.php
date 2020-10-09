<?php


namespace Modules\VehicleExpensesList\Http\Service;


use App\Http\Services\ResponseService;
use Modules\VehicleExpensesList\Http\Repository\VehicleExpensesListRepository;
use Illuminate\Http\Response;

class VehicleExpensesListService extends ResponseService
{
    private $vehicle ;
    public function __construct()
    {
        $this->vehicle = new VehicleExpensesListRepository();
    }
    public function index($request)
    {
        $data = $this->vehicle->index($request);
        if ($data) {
            return $this->responseWithSuccess($data);
        } else {
            return $this->responseWithFailure(Response::HTTP_BAD_REQUEST, __('messages.No Content'));
        }
    }
}
