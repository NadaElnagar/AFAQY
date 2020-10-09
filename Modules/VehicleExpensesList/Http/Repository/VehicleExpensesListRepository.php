<?php


namespace Modules\VehicleExpensesList\Http\Repository;


use Modules\VehicleExpensesList\Entities\FuelEntries;
use Modules\VehicleExpensesList\Entities\InsurancePayments;
use Modules\VehicleExpensesList\Entities\Services;
use Modules\VehicleExpensesList\Entities\Vehicles;
use Modules\VehicleExpensesList\Transformers\FuelEntriesCollection;
use Modules\VehicleExpensesList\Transformers\FuelEntriesResource;
use DB;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use function GuzzleHttp\Promise\all;

class VehicleExpensesListRepository
{

    public function index($request)
    {
        $direction = $request->direction;
        //user send true or false will handle as asc and desc
        $direction = (isset($direction) && $direction) ? 'asc' : 'desc';
        $perPage = $request->input('perPage', 15);
        $fuel = FuelEntries::with('vehicles');
        $services = Services::with('vehicles');
        $InsurancePayments = InsurancePayments::with('vehicles');

        //search by name
        if ($request->has('name')) {
            $name = $request->name;
            $fuel = $this->searchByName($fuel, $name);
            $services = $this->searchByName($services, $name);
            $InsurancePayments = $this->searchByName($InsurancePayments, $name);
        }

        ///you didn't need this condition if you do not use pagination
        if ($request->has('sort')) {
            if ($request->sort == 'date') {
                $fuel->orderBy('entry_date', $direction);
                $services->orderBy('created_at', $direction);
                $InsurancePayments->orderBy('contract_date', $direction);
            }
            if ($request->sort == 'cost') {
                $fuel->orderBy('cost', $direction);
                $services->orderBy('total', $direction);
                $InsurancePayments->orderBy('amount', $direction);
            }
        }

        if ($request->has('minimum_cost') && $request->minimum_cost == true) {
            $fuel->orderBy('cost', 'asc');
            $services->orderBy('total', 'asc');
            $InsurancePayments->orderBy('amount', 'asc');
        }

        if ($request->has('maximum_cost') && $request->maximum_cost == true) {
            $fuel->orderBy('cost', 'desc');
            $services->orderBy('total', 'desc');
            $InsurancePayments->orderBy('amount', 'desc');
        }

        if ($request->maximum_date == true) {
            $fuel->orderBy('entry_date', 'desc');
            $services->orderBy('created_at', 'desc');
            $InsurancePayments->orderBy('contract_date', 'desc');
        }


        $fuel = $fuel->get();
        $services = $services->select('id', DB::raw('DATE(created_at) as entry_date'), 'total as cost', 'vehicle_id')->get();
        $InsurancePayments = $InsurancePayments->select('id', 'contract_date as entry_date', 'amount as cost', 'vehicle_id')->get();


        $allItems = $this->filterTypeOption($request, $fuel, $services, $InsurancePayments);
        if ($request->has('sort')) {
            $allItems = $this->sort($allItems, $request->sort, true);
        }
        //pagination by any of result
        $allItems = new FuelEntriesCollection($allItems);

        return $allItems;
    }

    private function filterTypeOption($request, $fuel, $services, $InsurancePayments)
    {
        $array = [];
        if ($request->expense_type && $request->expense_type != null) {
            $type = $request->expense_type;
            if (strpos($type, 'fuel') !== false) {
                $array = $fuel;
            }
            if (strpos($type, 'services') !== false) {
                $array = (!empty($array)) ? $array->merge($services) : $services;
            }
            if (strpos($type, 'insurance') !== false) {
                $array = (!empty($array)) ? $array->merge($InsurancePayments) : $InsurancePayments;
            }
        }
        if (empty($array)) {
            $array = $fuel->merge($services)->merge($InsurancePayments);
        }
        if ($request->has('minimum_cost') && $request->minimum_cost == true) {
            $array = $array->sortBy->cost;
        }

        if ($request->has('maximum_cost') && $request->maximum_cost == true) {
            $array = $array->sortByDesc->cost;
        }

        if ($request->has('maximum_date') && $request->maximum_date == true) {
            $array = $array->sortByDesc->created_at;
        }

        return $array;
    }

    private function searchByName($query, $name)
    {
        $query = $query->whereHas('vehicles', function ($q) use ($name) {
            $q->where('vehicles.name', 'like', '%' . $name . '%');
        });
        return $query;
    }

    private function sort($result, $sort, $direction)
    {
        if ($sort == 'date') {
            $sort = 'created_at';
        } else {
            $sort = $sort;
        }
        return $this->sort_arr_of_obj($result, $sort, $direction);
    }

    function sort_arr_of_obj($array, $sortby, $direction)
    {

        $sortedArr = array();
        $tmp_Array = array();

        foreach ($array as $k => $v) {
            $tmp_Array[] = strtolower($v->$sortby);
        }

        if ($direction == 'asc') {
            asort($tmp_Array);
        } else {
            arsort($tmp_Array);
        }

        foreach ($tmp_Array as $k => $tmp) {
            $sortedArr[] = $array[$k];
        }

        return $sortedArr;

    }
}
