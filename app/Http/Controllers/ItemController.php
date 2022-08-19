<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Inertia\Inertia;
use App\Models\Sequence;
use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Models\ItemCheck;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Item', [
            'items' => Item::query()->when($request->search, function ($query, $search) {
                $query->where('itemcode', 'like', '%' . $search . '%');
                $query->orWhere('description', 'like', '%' . $search . '%');
            })
                ->paginate(10),
            'total_record' => Item::count(),
            'filters' => $request->only(['search'])
        ]);
    }
    public function create()
    {
        $seq = Sequence::where('seq_code', 'ITM')->first();
        return inertia('Item/Add', [
            'sequence' => str_pad($seq->seq_no, 8, '0', STR_PAD_LEFT)
        ]);
    }
    public function save(ItemRequest $request)
    {
        Item::create([
            'itemcode' => $request->itemcode,
            'description' => strtoupper($request->description),
        ]);
        Sequence::where('seq_code', 'ITM')->increment('seq_no');
        return redirect()->route('item.show')->with('message', 'Successfully added.');
    }
    public function status(Request $request, $id)
    {
        return inertia('Item/Status', [
            'business_units' => BusinessUnit::query()->when($request->search, function ($query, $search) {
                $query->orWhere('bu_name', 'like', '%' . $search . '%');
            })->with(['item' => function (BelongsTo $query) use ($id) {
                $query->where('itemcode', $id);
            }])->orderBy('id', 'ASC')->paginate(),
            'itemcode' => $id,
            'total_record' => BusinessUnit::with(['item' => function (BelongsTo $query) use ($id) {
                $query->where('itemcode', $id);
            }])->count(),
            'filters' => $request->only(['search'])
        ]);
    }
    public function apply(Request $request)
    {
        $check = ItemCheck::where('bu_id', $request->bu_id)->where('itemcode', $request->itemcode)->exists();

        if ($check) {
            ItemCheck::where('bu_id', $request->bu_id)->where('itemcode', $request->itemcode)->delete();

            return redirect()->back()->with('message', 'Remove successfully.');
        }
        ItemCheck::create([
            'bu_id' => $request->bu_id,
            'itemcode' => $request->itemcode
        ]);
        return redirect()->back()->with('message', 'Applied successfully.');
    }
    public function edit($id)
    {
        return inertia('Item/Edit', [
            "item" => Item::whereId($id)->select('itemcode', 'description', 'id')->first()
        ]);
    }
    public function update(ItemRequest $request)
    {
        Item::whereId($request->id)->update([
            'itemcode' => $request->itemcode,
            'description' =>  strtoupper($request->description)
        ]);
        return redirect()->route('item.show')->with('message', 'Successfully updated.');
    }
}
