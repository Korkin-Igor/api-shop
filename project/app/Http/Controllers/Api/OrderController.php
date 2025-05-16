<?php

namespace App\Http\Controllers\Api;

use App\Actions\OrdersShowAction;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Order $order)
    {
        if (auth()->user()->can('view', $order)) {
            return OrdersShowAction::execute($request);
        } else {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
    }
}
