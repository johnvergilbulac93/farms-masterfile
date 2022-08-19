<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Sequence;
use App\Models\Supplier;
use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;
use App\Models\BuCheck;
use App\Models\SupplierCheck;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Supplier', [
            'suppliers' => Supplier::query()->when($request->search, function ($query, $search) {
                $query->where('sup_name', 'like', '%' . $search . '%');
            })->paginate(10),
            'total_record' => Supplier::count(),
            'filters' => $request->only(['search'])
        ]);
    }
    public function create()
    {
        $seq = Sequence::where('seq_code', 'SUP')->first();
        return inertia('Supplier/Add', [
            'sequence' => $seq->seq_no
        ]);
    }
    public function save(SupplierRequest $request)
    {
        Supplier::create([
            'sup_code' => $request->sup_code,
            'sup_name' => strtoupper($request->sup_name),
            'sup_address' => strtoupper($request->sup_addr)
        ]);
        Sequence::where('seq_code', 'SUP')->increment('seq_no');
        return redirect()->route('supplier.show')->with('message', 'Successfully added.');
    }
    public function status(Request $request, $id)
    {
        return inertia('Supplier/Status', [
            'business_units' => BusinessUnit::query()->when($request->search, function ($query, $search) {
                $query->orWhere('bu_name', 'like', '%' . $search . '%');
            })->with(['supplier' => function (BelongsTo $query) use ($id) {
                $query->where('sup_code', $id);
            }])->orderBy('id', 'ASC')->paginate(),
            'sup_id' => $id,
            'total_record' => BusinessUnit::with(['customer' => function (BelongsTo $query) use ($id) {
                $query->where('sup_code', $id);
            }])->count(),
            'filters' => $request->only(['search'])
        ]);
    }
    public function apply(Request $request)
    {
        $check = SupplierCheck::where('bu_id', $request->bu_id)->where('sup_code', $request->sup_code)->exists();

        if ($check) {
            SupplierCheck::where('bu_id', $request->bu_id)->where('sup_code', $request->sup_code)->delete();

            return redirect()->back()->with('message', 'Remove successfully.');
        }
        SupplierCheck::create([
            'bu_id' => $request->bu_id,
            'sup_code' => $request->sup_code
        ]);
        return redirect()->back()->with('message', 'Applied successfully.');
    }
    public function edit($id)
    {
        return inertia('Supplier/Edit', [
            "supplier" => Supplier::where('sup_code', $id)->select('sup_code', 'sup_name', 'sup_address')->first()
        ]);
    }
    public function update(SupplierRequest $request)
    {
        Supplier::where('sup_code', $request->sup_code)->update([
            'sup_name' => strtoupper($request->sup_name),
            'sup_address' =>  strtoupper($request->sup_addr)
        ]);
        return redirect()->route('supplier.show')->with('message', 'Successfully updated.');
    }
}
