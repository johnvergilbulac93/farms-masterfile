<?php

namespace App\Http\Controllers;

use App\Http\Requests\NonTradeCustomerRequest;
use App\Models\BusinessUnit;
use App\Models\NonTradeCustomer;
use Illuminate\Http\Request;

class NonTradeCustomerController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Non-Trade-Customer', [
            'customers' => NonTradeCustomer::query()
                ->join('business_units', 'applied_to_bu', 'business_units.id')
                ->select('cus_id', 'nav_code', 'cus_name', 'applied_to_bu', 'bu_name')
                ->when($request->search, function ($query, $search) {
                    $query->where('nav_code', 'like', '%' . $search . '%');
                    $query->orWhere('cus_name', 'like', '%' . $search . '%');
                    $query->orWhere('bu_name', 'like', '%' . $search . '%');
                })
                ->paginate(10),
            'total_record' => NonTradeCustomer::count(),
            'filters' => $request->only(['search'])
        ]);
    }
    public function create()
    {
        return inertia('Non-Trade-Customer/Add', [
            'business_units' => BusinessUnit::select('id', 'bu_name')->get()
        ]);
    }
    public function save(NonTradeCustomerRequest $request)
    {
        NonTradeCustomer::create([
            'nav_code' => $request->nav_code,
            'cus_name' => strtoupper($request->cus_name),
            'applied_to_bu' => $request->bu_code,
        ]);
        return redirect()->route('non-trade-customer.show')->with('message', 'Successfully added.');
    }
    public function edit($id)
    {
        return inertia('Non-Trade-Customer/Edit', [
            'business_units' => BusinessUnit::select('id', 'bu_name')->get(),
            "customer" => NonTradeCustomer::where('cus_id', $id)->first()
        ]);
    }
    public function update(NonTradeCustomerRequest $request)
    {
        NonTradeCustomer::where('cus_id', $request->id)->update([
            'nav_code' => $request->nav_code,
            'cus_name' => strtoupper($request->cus_name),
            'applied_to_bu' => $request->bu_code,
        ]);
        return redirect()->route('non-trade-customer.show')->with('message', 'Successfully updated.');
    }
}
