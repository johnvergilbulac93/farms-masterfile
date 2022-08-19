<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return inertia('Dashboard', [
            'item' => Item::count(),
            'customer' => Customer::count(),
            'supplier' => Supplier::count(),
            'business_unit' => BusinessUnit::count(),
        ]);
    }
}
