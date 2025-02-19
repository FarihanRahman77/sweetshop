<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\Party;
use App\Models\inventory\Product;
use App\Models\inventory\DamageProduct;
use App\Models\inventory\SaleOrder;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $supplier = Party::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('party_type', '=', 'Supplier')->count();
        $customer = Party::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('party_type', '=', 'Customer')->count();
        $walkin = Party::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('party_type', '=', 'Walkin_Customer')->count();

        $product = Product::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('type', '!=', 'service')->count();
        $service = Product::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('type', '=', 'service')->count();
        $damages = DamageProduct::where('deleted', '=', 'No')->where('status', '=', 'Active')->count();

        $pending =   SaleOrder::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('order_status', '=', 'Pending')->count();
        $servicing = SaleOrder::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('order_status', '=', 'Servicing')->count();
        $cancelled = SaleOrder::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('order_status', '=', 'Cancelled')->count();
        $delivered = SaleOrder::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('order_status', '=', 'Delivered')->count();
        $ready =     SaleOrder::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('order_status', '=', 'ReadyToDeliverd')->count();
        $completed = SaleOrder::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('order_status', '=', 'Completed')->count();

        return view('admin.includes.dashboard', [
            'supplier' => $supplier,
            'customer' => $customer,
            'walkin' => $walkin,
            'product' => $product,
            'service' => $service,
            'damages' => $damages,
            'pending' => $pending, 'servicing' => $servicing, 'cancelled' => $cancelled,
            'delivered' => $delivered, 'ready' => $ready, 'completed' => $completed
        ]); 

        
    }
}
