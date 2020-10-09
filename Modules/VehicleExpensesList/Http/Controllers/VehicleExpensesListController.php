<?php

namespace Modules\VehicleExpensesList\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\VehicleExpensesList\Http\Service\VehicleExpensesListService;

class VehicleExpensesListController extends Controller
{
    private $vehicle ;
    public function __construct()
    {
        $this->vehicle = new VehicleExpensesListService();
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        return  $this->vehicle->index($request);
    }


}
