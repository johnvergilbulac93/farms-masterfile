<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\BuCheck;
use App\Models\BusinessUnit;
use App\Models\Customer;
use App\Models\Sequence;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Customer', [
            'customers' => Customer::query()->when($request->search, function ($query, $search) {
                $query->where('cus_code', 'like', '%' . $search . '%');
                $query->orWhere('cus_name', 'like', '%' . $search . '%');
                $query->orWhere('cus_type', 'like', '%' . $search . '%');
            })
                ->paginate(10),
            'total_record' => Customer::count(),
            'filters' => $request->only(['search'])
        ]);
    }
    public function status(Request $request, $id)
    {
        return inertia('Customer/Status', [
            'business_units' => BusinessUnit::query()->when($request->search, function ($query, $search) {
                $query->orWhere('bu_name', 'like', '%' . $search . '%');
            })->with(['customer' => function (BelongsTo $query) use ($id) {
                $query->where('cus_code', $id);
            }])->orderBy('id', 'ASC')->paginate(),
            'cus_id' => $id,
            'total_record' => BusinessUnit::with(['customer' => function (BelongsTo $query) use ($id) {
                $query->where('cus_code', $id);
            }])->count(),
            'filters' => $request->only(['search'])
        ]);
    }
    public function apply(Request $request)
    {
        $check = BuCheck::where('bu_id', $request->bu_id)->where('cus_code', $request->cus_code)->exists();

        if ($check) {
            BuCheck::where('bu_id', $request->bu_id)->where('cus_code', $request->cus_code)->delete();

            return redirect()->back()->with('message', 'Remove successfully.');
        }
        BuCheck::create([
            'bu_id' => $request->bu_id,
            'cus_code' => strtoupper($request->cus_code)
        ]);
        return redirect()->back()->with('message', 'Applied successfully.');
    }
    public function edit($id)
    {
        return inertia('Customer/Edit', [
            'cus_id' => $id,
            "customer" => Customer::where('cus_code', $id)->first()
        ]);
    }
    public function update(CustomerRequest $request)
    {
        Customer::where('cus_code', $request->cus_code)->update([
            'cus_name' => strtoupper($request->cus_name),
            'cus_type' =>  strtoupper($request->cus_type)
        ]);
        return redirect()->route('customer.show')->with('message', 'Successfully updated.');
    }
    public function create()
    {
        $bu = BusinessUnit::get();
        $result = array();
        foreach ($bu as $row) {
            $res = Sequence::whereId($row->seq_id)->first();
            $result[] = [
                'id' => $row->id,
                'bu_name' => $row->bu_name,
                'seq_code'  => $res ?  $res->seq_code . '-' . str_pad($res->seq_no, 5, '0', STR_PAD_LEFT) : 0
            ];
        }
        return inertia('Customer/Add', [
            'business_units' => $result
        ]);
    }
    public function save(CustomerRequest $request)
    {

        $bu =  BusinessUnit::whereId($request->bu_id)->first();
        BuCheck::create([
            'bu_id' => $request->bu_id,
            'cus_code' => strtoupper($request->cus_code)
        ]);
        Customer::create([
            'cus_code' => strtoupper($request->cus_code),
            'cus_name' => strtoupper($request->cus_name),
            'cus_type' =>  strtoupper($request->cus_type)

        ]);
        Sequence::whereId($bu->seq_id)->increment('seq_no');
        return redirect()->route('customer.show')->with('message', 'Successfully added.');
    }
}
