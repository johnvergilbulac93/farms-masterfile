<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use App\Http\Requests\BURequest;
use App\Models\Sequence;
use Illuminate\Support\Facades\DB;

class BUController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Business-Unit', [
            'business_units' => BusinessUnit::query()->when($request->search, function ($query, $search) {
                $query->where('bu_name', 'like', '%' . $search . '%');
            })->select('bu_name', 'bu_code', 'id', 'bu_type', 'server')
                ->paginate(10),
            'total_record' => BusinessUnit::count(),
            'filters' => $request->only(['search'])
        ]);
    }
    public function create()
    {
        return inertia('BU/Add');
    }
    public function save(BURequest $request)
    {
        BusinessUnit::create([
            'bu_name' => strtoupper($request->bu_name),
            'bu_code' => strtoupper($request->bu_code),
            'bu_type' => $request->bu_type,
            'bu_seq_code' => strtoupper($request->bu_seq_code),
            'server'  => $request->bu_server,

        ]);
        Sequence::create([
            'seq_code' => strtoupper($request->bu_seq_code),
            'seq_no'    => 1
        ]);
        $sequence = Sequence::where('seq_code', strtoupper($request->bu_seq_code))->first();
        BusinessUnit::where('bu_seq_code', $sequence->seq_code)->update([
            'seq_id' => $sequence->id
        ]);
        return redirect()->route('bu.show')->with('message', 'Successfully added.');
    }
    public function edit($id)
    {
        return inertia('BU/Edit', [
            "business_unit" => BusinessUnit::whereId($id)->select('bu_name', 'bu_code', 'id', 'bu_type', 'bu_seq_code', 'server')->first()
        ]);
    }
    public function update(BURequest $request)
    {
        BusinessUnit::whereId($request->id)->update([
            'bu_name' => strtoupper($request->bu_name),
            'bu_code' => strtoupper($request->bu_code),
            'bu_type' => $request->bu_type,
            'bu_seq_code' => strtoupper($request->bu_seq_code),
            'server'  => $request->bu_server,
        ]);

        return redirect()->route('bu.show')->with('message', 'Successfully updated.');
    }
}
