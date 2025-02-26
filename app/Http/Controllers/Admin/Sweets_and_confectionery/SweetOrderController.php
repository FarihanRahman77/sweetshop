<?php

namespace App\Http\Controllers\Admin\Sweets_and_confectionery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Crm\Party;
use App\Models\Setups\Warehouse;
use App\Models\Setups\Currentstock;
use App\Models\RestaurentManagement\Table;
use App\Models\RestaurentManagement\Order;
use App\Models\RestaurentManagement\OrderDetail;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\RestaurentManagement\Menu;
use App\Models\Voucher\PaymentVoucher;
use App\Models\Voucher\AccountsVoucher;
use App\Models\Voucher\AccountsVoucherDetails;
use App\Models\RestaurentManagement\MenuSpecification;
use App\Models\RestaurentManagement\MenuImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;
use PDF;
class SweetOrderController extends Controller
{
    public function index()
    {


        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
       $data['orders']  = Order::select('id','code', 'order_date')->where('deleted', 'No')->where('order_status', 'Open')->get();
       $data['customers']  = Party::select('id', 'name')->where('deleted', 'No')->where('status', 'Active')->get();
        $data['rooms'] = Warehouse::where('tbl_sister_concern_id', '=', $logged_sister_concern_id)->where('deleted', 'No')->where('status', '=', 'Active')->get();
        $data['menus'] = Menu::leftjoin('tbl_setups_categories', 'tbl_setups_categories.id', '=', 'menus.category_id')
                        ->select('menus.*', 'tbl_setups_categories.name as categoryName')
                        ->where('menus.sister_concern_id', '=', $logged_sister_concern_id)
                        ->where('menus.deleted', 'No')
                        ->where('menus.status', '=', 'Active')
                        ->orderBy('menus.id', 'DESC')
                        ->get();
        return view('admin.Sweets_and_confectionery.order.orderView', $data);
        
    }

    public function getTablePlanning(Request $request)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $tables = Table::where('sister_concern_id', '=', $logged_sister_concern_id)->where('warehouse_id', '=', $request->room_id)->where('deleted', '=', 'No')->get();
        $html = '';
        foreach ($tables as $table) {
            $imageUrl = url('upload/table_images/' . $table->image);
            $statusColor = '';
            if ($table->present_status == 'Available') {
                $statusColor = 'bg-success';
            } elseif ($table->present_status == 'Occupied') {
                $statusColor = 'bg-warning';
            } elseif ($table->present_status == 'Out Of Order') {
                $statusColor = 'bg-danger';
            }
            $html .= '<div class="col-md-3  p-1">
                        <div class="card_rounded border border-secondary p-2">
                            <div class="card-image">
                                <span class="card-notify-badge">' . $table->name . ' - (' . $table->capacity . ' person)</span>
                                <img class="img-fluid" src="' . $imageUrl . '" style="width:100%;height:180px;"alt="Alternate Text" />
                            </div>
                            <div class="card-image-overlay m-auto">
                                <span class="card-detail-badge">Assigned Boy : Rubel Hossain</span>
                                <span class="card-detail-badge">Running Order : 3</span><br>
                                <span class="card-detail-badge ' . $statusColor . '">' . $table->present_status . '</span>
                            </div>
                            <div class="card-body text-center">
                                <div class="ad-title m-auto ">
                                    <a class="btn btn-info" href="#" onclick="viewOrders(' . $table->id . ')"><i class="fa fa-eye"></i> View</a>
                                    <a class="btn btn-primary" href="#" onclick="addOrder(' . $table->id . ')"><i class="fa fa-plus circle"></i> Add Order</a>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        return $html;
    }

    public function getRunningOrders(Request $request)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $order = Order::where('table_id', '=', $request->id)->where('sister_concern_id', '=', $logged_sister_concern_id)->where('deleted', '=', 'No')->where('present_status', '=', 'Running')->get();
    }

    public function customerinfo(Request $request)
	{
		if ($request->id > 0) {
			$partyType = $request->customer_type;
			$customerInfo = Party::where('id', $request->id)
				->where(function ($query) use ($partyType) {
					$query->where('party_type', $partyType)
						->orWhere('party_type', 'Both');
				})
				
				->get()->first();
		} else {
			$customerInfo = Party::where('contact', '=', $request->partyPhoneNumber)->where('party_type', $request->customer_type)->first();
		}

		return $customerInfo;
	}
    
    public function addOrder(Request $request)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $table = Table::where('sister_concern_id', '=', $logged_sister_concern_id)->where('id', '=', $request->id)->where('deleted', '=', 'No')->first();
        $menus = Menu::leftjoin('tbl_setups_categories', 'tbl_setups_categories.id', '=', 'menus.category_id')
            ->select('menus.*', 'tbl_setups_categories.name as categoryName')
            ->where('menus.sister_concern_id', '=', $logged_sister_concern_id)
            ->where('menus.deleted', 'No')
            ->where('menus.status', '=', 'Active')
            ->orderBy('menus.id', 'DESC')
            ->get();
        $menuHtml = '<option value="">Select Menu</option>';
        foreach ($menus as $menu) {
            $menuHtml .= '<option value="' . $menu->id . '">' . $menu->categoryName . ' - ' . $menu->name . ' - (' . $menu->code . ')</option>';
        }
        $table_id = $request->id;
        $data = array(
            'table' => $table,
            'menuHtml' => $menuHtml,
            'table_id' => $table_id
        );
        return $data;
    }

public function addToCart(Request $request)
    {      
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $cartString = 'menu_cart_array_' . $request->table_id;
        $available_quantity = 0;
        $is_available = false;
    
        if (Session::has($cartString)) {
            $cartData = Session::get($cartString);
            foreach ($cartData as $key => $value) {
                if ($value['menu_id'] == $request->menu_id && $value['table_id'] == $request->table_id) {
                    $is_available = true;
                    $cartData[$key]['menu_quantity'] += $request->menu_quantity;
                    Session::put($cartString, $cartData);
                    break;
                }
            }
        }
    
        if (!$is_available) {
            // Fetch menu info if the item doesn't exist in cart
            $menuInfo = Menu::leftJoin('tbl_setups_categories', 'tbl_setups_categories.id', '=', 'menus.category_id')
                ->select('menus.*', 'tbl_setups_categories.name as categoryName')
                ->where('menus.sister_concern_id', $logged_sister_concern_id)
                ->where('menus.deleted', 'No')
                ->where('menus.status', 'Active')
                ->where('menus.id', $request->menu_id)
                ->first();
    
            if ($menuInfo) {
                $available_quantity = $menuInfo->stock_check === 'Yes' 
                    ? CurrentStock::where('deleted', 'No')->where('tbl_menusId', $menuInfo->id)->first()->currentStock ?? 0 
                    : 0;
    
                $item_array = [
                    'menu_id' => $menuInfo->id,
                    'table_id' => $request->table_id,
                    'menu_name' => $menuInfo->name,
                    'menu_code' => $menuInfo->menu_code,
                    'category_name' => $menuInfo->categoryName,
                    'available_qty' => $available_quantity,
                    'menu_quantity' => $request->menu_quantity,
                    'menu_price' => $menuInfo->max_price,
                    'menu_discount' => $menuInfo->discount_percentage,
                    'menu_price_after_discount' => $menuInfo->min_price
                ];
    
                Session::push($cartString, $item_array);
            }
        }
        
        return response()->json(['status' => 'success', 'message' => 'Item added/updated in cart']);
}
   

public function fetch_menu_Cart(Request $request)
{
    $cartString = 'menu_cart_array_' . $request->table_id;
    $logged_sister_concern_id = Session::get('companySettings')[0]['id'];

    $grandTotal = 0;
    $cart = '';
    if (Session::get($cartString) != null) {
        $i = 1;
        foreach (Session::get($cartString) as $keys => $values) {

            $menu_id = Session::get($cartString)[$keys]["menu_id"];
            $table_id = Session::get($cartString)[$keys]["table_id"];
            $menu_name = Session::get($cartString)[$keys]["menu_name"];
            $menu_code = Session::get($cartString)[$keys]["menu_code"];
            $menu_quantity = Session::get($cartString)[$keys]["menu_quantity"];
            $menu_price = Session::get($cartString)[$keys]["menu_price"];
            $category_name = Session::get($cartString)[$keys]["category_name"];
            $menu_discount = Session::get($cartString)[$keys]["menu_discount"];
            $menu_price_after_discount = Session::get($cartString)[$keys]["menu_price_after_discount"];
            
            // Check if 'available_qty' exists, otherwise set a default value
            $available_qty = isset(Session::get($cartString)[$keys]["available_qty"]) ? Session::get($cartString)[$keys]["available_qty"] : 0;

            $totalPrice = Session::get($cartString)[$keys]["menu_quantity"] * $menu_price_after_discount;

            $cart .= '<tr><td style="text-align: center;">' . $i++ . '<input type="hidden" name="ids[]" id="id_' . $menu_id . '_' . $table_id . '" value="' . $menu_id . '" /><input type="hidden" name="table_id[]" id="table_id_' . $menu_id . '_' . $table_id . '" value="' . $menu_id . '" /></td>' .
                '<td>' . $menu_name . ' - ' . $menu_code . '</td>' .
                '<td class="text-center">' . $available_qty . '</td>' .
                '<td><input type="text" class="form-control" style="text-align: center;width: 100%;" id="menu_quantity' . $menu_id . '_' . $table_id . '"  name="menu_quantity[]" onkeyup="loadCartandUpdate(' . $menu_id . ',' . $table_id . ')" value="' . $menu_quantity . '" /></td>' .
                '<td class="tex-right">' . $menu_price . '</td>' .
                '<td><input type="text" class="form-control" style="text-align: center;width: 100%;" id="menu_discount' . $menu_id . '_' . $table_id . '"  name="menu_discount[]" onkeyup="loadCartandUpdate(' . $menu_id . ',' . $table_id . ')" value="' . $menu_discount . '" /></td>' .
                '<td><input type="text" class="form-control" style="text-align: center;width: 100%;" id="menu_price_after_discount' . $menu_id . '_' . $table_id . '"  name="menu_price_after_discount[]" onkeyup="loadCartandUpdate(' . $menu_id . ',' . $table_id . ')" value="' . $menu_price_after_discount . '" readonly/></td>' .
                '<td style="text-align: right;"><span id="totalPrice_' . $menu_id . '_' . $table_id . '">' . numberFormat($totalPrice) . '</span></td>' .
                '<td style="text-align: center;"><a href="#" onclick="itemremoveCart(' . Session::get($cartString)[$keys]["menu_id"] . ', ' . Session::get($cartString)[$keys]["table_id"] . ')" style="color:red;"><i class="fa fa-trash"> </i></a></td></tr>';

            $grandTotal += $totalPrice;
        }
    }
    $cart .= '<tr><td colspan="7" class="text-right" > Total Tk : </td><td id="totalAmount" class="text-right"> ' . numberFormat($grandTotal) . '</td></tr>';
    $data = array(
        'cart' => $cart,
        'totalAmount' => $grandTotal
    );

    return $data;
}

public function update_menu_Cart(Request $request)
{
    // return $request;
    $cartString = 'menu_cart_array_' . $request->table_id;
    if (Session::has($cartString)) {
        $cartData = Session::get($cartString);
        foreach ($cartData as $key => $value) {
                $menu_discount = Session::get($cartString)[$key]["menu_discount"];
            if ($value['menu_id'] == $request->menu_id && $value['table_id'] == $request->table_id) {
                $cartData[$key]['menu_quantity'] = $request->menu_quantity;
                $cartData[$key]['menu_discount'] = $request->menu_discount;

               $cartData[$key]['menu_price_after_discount'] = $cartData[$key]['menu_price'] - ($cartData[$key]['menu_price'] * ($cartData[$key]['menu_discount'] / 100));
                
                
                Session::put($cartString, $cartData);
                return response()->json(['status' => 'success', 'message' => 'Cart updated successfully']);
            }
        }
    }
    return response()->json(['status' => 'error', 'message' => 'Cart data not found']);
}


public function removeCartitem(Request $request)
{
     
    $menu_id = $request->menu_id;
    $table_id = $request->table_id; 
    $data = '';
    $cartData = Session::get('menu_cart_array_' . $table_id); 
    if (is_array($cartData) && count($cartData) > 0) {
        foreach ($cartData as $key => $value) {
            if ($value['menu_id'] == $menu_id && $value['table_id'] == $table_id) {
                unset($cartData[$key]);
                Session::put('menu_cart_array_' . $table_id, $cartData); 
                $data = "Success";
                break;
            }
        }
    } else {
        $data = "No items in cart";
    }
    return response()->json(['message' => $data]);
}

public function checkoutOrder(Request $request)
{   
    //   return $request;
    $table_id = $request->table_id;
    $Party_id = $request->party_id;
    if($Party_id == '0'){
        if($request->contact == ''){
            $Party_id = '6';
        }
        else{
            $party = new Party();
            $party->name = $request->name;
            $party->contact = $request->contact;
            $party->current_due = '0.00';
            $party->opening_due = '0.00';
            $party->party_type = 'Walkin_Customer';
            $party->created_by = auth()->user()->id;
            $party->created_date = date('Y-m-d H:i:s');
            $party->deleted = 'No';
            $party->status = 'Active';
            $party->save();
            $Party_id = $party->id;
        }
        
    }
    else{
        $Party_id = $request->party_id;
    }
    $totalAmount = $request->totalAmount;
    $GrandTotalSum = $request->Grandsum;
    $Current_Payment = $request->current_payment;
    $Payment_Method = $request->payment_method;
    if($request->current_balance >0){
        $Current_Balance = $request->current_balance; 
    }
    else{
        $Current_Balance = '0.00';
    }
   
    $cartString = 'menu_cart_array_' . $table_id;

    if (!Session::has($cartString) || empty(Session::get($cartString))) {
        return response()->json(['status' => 'error', 'message' => 'No items in the cart to checkout']);
    }
    // Start a transaction to ensure atomicity
    DB::beginTransaction();

    try {
        $cartData = Session::get($cartString);
        $grandTotal = 0;
        $totalDiscount = 0;
        $TotalDiscount = 0;
        $Totalamount =0;
        foreach ($cartData as $item) {
            $Totalamount  += $item['menu_quantity'] * $item['menu_price_after_discount'];
            $TotalDiscount = 0;
        }
        $maxCode = Order::where('deleted', 'No')->max('code');
        $maxCode++;
        $maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);
        
        $order = new Order();
        $order->code =  $maxCode;
        $order->table_id = $table_id;
        $order->party_id = $Party_id;
        $order->grand_total = $GrandTotalSum; 
        $order->total_discount = $TotalDiscount;
        $order->vat = $request->Vat;
        $order->grand_discount = $request->GrandDiscount;
        $order->paid_amount = $Current_Payment;
        $order->total_amount = $Totalamount;
        $order->order_status = $request->OrderStatus;
        $order->due = $Current_Balance;
        $order->created_by= auth()->user()->id;
        $order->save();
        $order_id=$order->id;
        foreach ($cartData as $cartItem) {
            
            $itemTotalAmount = $cartItem['menu_quantity'] * $cartItem['menu_price_after_discount'];
            $itemDiscount = 0;
    
            $grandTotal += $itemTotalAmount;
            $totalDiscount += $itemDiscount;
    
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id; 
            $orderDetail->menu_id = $cartItem['menu_id'];
            $orderDetail->unit_price = $cartItem['menu_price'];
            $orderDetail->menu_quantity = $cartItem['menu_quantity'];
            $orderDetail->unit_discount_price = $cartItem['menu_discount'];
            $orderDetail->unit_price_after_discount = $cartItem['menu_price_after_discount'];
            $orderDetail->unit_total_price = $itemTotalAmount;
            $orderDetail->created_by= auth()->user()->id;
            $orderDetail->save();
        }
    
        if (floatval($GrandTotalSum) > 0) {
          
            $maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
            $maxCode++;
            $maxCode = str_pad($maxCode, 6, '000000', STR_PAD_LEFT);;
            $paymentVoucher = new PaymentVoucher();
            $paymentVoucher->party_id = $Party_id;
            $paymentVoucher->voucherNo = $maxCode;
            $paymentVoucher->amount = floatval($GrandTotalSum);
            $paymentVoucher->payment_method = 'Cash';
            $paymentVoucher->resturant_order_id  = $order_id;
            $paymentVoucher->discount  = $TotalDiscount;
            $paymentVoucher->type  = 'Party Payable';
            $paymentVoucher->voucherType  = 'WalkinSale';
            $paymentVoucher->remarks  = 'WalkinSale: ' . ' payment: ' . $GrandTotalSum;
            $paymentVoucher->entryBy  = auth()->user()->id;
            $paymentVoucher->save();
            
            $party = Party::find($Party_id);
            $party->increment('current_due', $GrandTotalSum);

            if (floatval( $Current_Payment) > 0) {
                $maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
                $maxCode++;
                $maxCode = str_pad($maxCode, 6, '000000', STR_PAD_LEFT);
                $paymentVoucher = new PaymentVoucher();
                $paymentVoucher->voucherNo = $maxCode;
                $paymentVoucher->party_id = $Party_id;
                $paymentVoucher->resturant_order_id  = $order_id;
                $paymentVoucher->amount = floatval( $Current_Payment);
                $paymentVoucher->payment_method = 'Cash';
                $paymentVoucher->paymentDate  = $request->date;
                $paymentVoucher->type  = 'Payment Received';
                $paymentVoucher->voucherType  = 'WalkinSale';
                $paymentVoucher->remarks  = 'WalkinSale: ' . ' payment: ' . $GrandTotalSum;
                $paymentVoucher->entryBy  = auth()->user()->id;
                $paymentVoucher->save();
                $party = Party::find($Party_id);
                $party->decrement('current_due',   $Current_Payment);
            }
        }
                                $voucher = new AccountsVoucher();
                                $voucher->vendor_id = $Party_id;
                                $voucher->tbl_resturantOrder_id  = $order_id;
                                $voucher->transaction_date = now();
                                $voucher->amount = floatval($GrandTotalSum);
                                $voucher->payment_method = $request->payment_method;
                                $voucher->deleted = "No";
                                $voucher->status = "Active";
                                $voucher->created_by = Auth::user()->id;
                                $voucher->created_date = date('Y-m-d h:s');
                                $voucher->save();


                                $voucherId = $voucher->id;
                                $salesCoaId = ChartOfAccounts::where('slug', '=', 'Sales')->first()->id;
                                $voucherDetails = new AccountsVoucherDetails();
                                $voucherDetails->tbl_acc_voucher_id = $voucherId;
                                $voucherDetails->tbl_acc_coa_id = $salesCoaId;
                                $voucherDetails->tbl_resturantOrder_id  = $order_id;
                                $voucherDetails->transaction_date = now();
                                $voucherDetails->credit = floatval($GrandTotalSum);
                                $voucherDetails->voucher_title = 'Order amount paid ' . $Current_Payment . ' Tk , Date:  '. (new \DateTime())->format('Y-m-d H:i:s');
                                $voucherDetails->deleted = "No";
                                $voucherDetails->status = "Active";
                                $voucherDetails->created_by = Auth::user()->id;
                                $voucherDetails->created_date = date('Y-m-d h:s');
                                $voucherDetails->save();


                                if ($Current_Payment > 0) {

                                    $voucherDetails = new AccountsVoucherDetails();
                                    $voucherDetails->tbl_acc_voucher_id = $voucherId;
                                    $voucherDetails->tbl_acc_coa_id = $salesCoaId; 
                                    $voucherDetails->tbl_resturantOrder_id  = $order_id;
                                    $voucherDetails->transaction_date =now();
                                    $voucherDetails->debit = floatval($Current_Payment);
                                    $voucherDetails->voucher_title = 'Order done, Date: ' . (new \DateTime())->format('Y-m-d H:i:s');
                                    $voucherDetails->deleted = "No";
                                    $voucherDetails->status = "Active";
                                    $voucherDetails->created_by = Auth::user()->id;
                                    $voucherDetails->created_date = date('Y-m-d H:i:s');
                                    $voucherDetails->save(); 

                                }
        Session::forget($cartString);
        DB::commit();
        return response()->json(['status' => 'success', 'message' => 'Order successfully placed', 'order_id' => $order->id]);
    } catch (Exception $e) {
        DB::rollback();
    
        return response()->json(['status' => 'error', 'message' => 'Checkout failed: ' . $e->getMessage()]);
    }
}

 public function orderlist(){
    $Tables = Table::where('deleted', 'No')->where('status', 'Active')->get();
    return view('admin.Sweets_and_confectionery.order.orderList',['Tables'=>$Tables]);
 }

 public function Orderdetailstablewise(Request $request) {
    $order = DB::table('tbl_restaurant_order')->where('id', $request->id)->first();
    $cartString = 'edit_order_data_' . $order->id; // Fix here
    Session::forget($cartString);
    $orderdatas = DB::table('tbl_restaurant_order')
        ->leftJoin('tbl_restaurant_order_details', 'tbl_restaurant_order_details.order_id', '=', 'tbl_restaurant_order.id')
        ->leftJoin('menus', 'tbl_restaurant_order_details.menu_id', '=', 'menus.id')
        ->leftJoin('tables', 'tbl_restaurant_order.table_id', '=', 'tables.id')
        ->leftJoin('tbl_crm_parties', 'tbl_restaurant_order.party_id', '=', 'tbl_crm_parties.id')
        ->select(
            'tbl_restaurant_order_details.menu_quantity',
            'tbl_restaurant_order_details.unit_total_price',
            'tbl_restaurant_order_details.unit_price',
            'tbl_restaurant_order_details.unit_discount_price',
            'tbl_restaurant_order_details.unit_price_after_discount',
            'tbl_restaurant_order.id as order_id',
            'tbl_restaurant_order.paid_amount',
            'tbl_restaurant_order.order_status',
            'tbl_restaurant_order.table_id',
            'tbl_restaurant_order.total_amount',
            'tbl_restaurant_order.grand_discount',
            'tbl_restaurant_order.code AS ordercode',
            'tbl_restaurant_order.vat',
            'tbl_restaurant_order.paid_amount',
            'tbl_crm_parties.name AS party_name',
            'tbl_crm_parties.code AS party_code',
            'tbl_crm_parties.contact AS party_contact',
            'tables.name AS table_name',
            'tables.id AS table_id',
            'menus.id AS menu_id',
            'menus.name AS menu_name',
            'menus.min_price',
            'tables.capacity AS Capecity_table',
            'tbl_restaurant_order.order_date',
            'tbl_restaurant_order.due',
            'tbl_restaurant_order.grand_total AS order_total',
            'tbl_restaurant_order.party_id'
        )
        ->where('tbl_restaurant_order.deleted', 'No')
        ->where('tbl_restaurant_order.order_status', 'Open')
        ->where('tbl_restaurant_order_details.deleted', 'No')
        ->where('tbl_restaurant_order.id', '=', $order->id)
        ->get();

    foreach ($orderdatas as $orderDetail) {
        $itemArray = [
            'menu_id' => $orderDetail->menu_id,
            'order_id' => $order->id,
            'menu_name' => $orderDetail->menu_name,
            'menu_quantity' => $orderDetail->menu_quantity,
            'unit_price' => $orderDetail->unit_price,
            'unit_discount_price' => $orderDetail->unit_discount_price,
            'unit_total_price' => $orderDetail->unit_total_price,
            'menu_price_after_discount' => $orderDetail->unit_price_after_discount
        ];
        Session::push($cartString, $itemArray);
    }

    return response()->json(['orderdatas' => $orderdatas, 'status' => 'success', 'message' => 'Item added/updated in cart']);
}


public function Edit_item_addToCart(Request $request) {
    //   return $request;
    $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
     $cartString = 'edit_order_data_' . $request->order_id;
     $available_quantity = 0;
        $is_available = false;
    
        if (Session::has($cartString)) {
            $cartData = Session::get($cartString);
            foreach ($cartData as $key => $value) {
                if ($value['menu_id'] == $request->menu_id && $value['order_id'] == $request->order_id) {
                    $is_available = true;
                    $cartData[$key]['menu_quantity'] += $request->menu_quantity;
                    Session::put($cartString, $cartData);
                    break;
                }
            }
        }
    
        if (!$is_available) {
            // Fetch menu info if the item doesn't exist in cart
            $menuInfo = Menu::leftJoin('tbl_setups_categories', 'tbl_setups_categories.id', '=', 'menus.category_id')
                ->select('menus.*', 'tbl_setups_categories.name as categoryName')
                ->where('menus.sister_concern_id', $logged_sister_concern_id)
                ->where('menus.deleted', 'No')
                ->where('menus.status', 'Active')
                ->where('menus.id', $request->menu_id)
                ->first();
    
            if ($menuInfo) {
                $available_quantity = $menuInfo->stock_check === 'Yes' 
                    ? CurrentStock::where('deleted', 'No')->where('tbl_menusId', $menuInfo->id)->first()->currentStock ?? 0 
                    : 0;
    
               $item_array = [
                    'menu_id' => $menuInfo->id,
                    'order_id' => $request->order_id,
                    'menu_name' => $menuInfo->name,
                    'menu_quantity' => $request->menu_quantity,
                    'unit_price' => $menuInfo->max_price,
                    'unit_discount_price' => $menuInfo->discount_percentage,
                    'menu_price_after_discount' => $menuInfo->min_price,
                    'unit_total_price'=> $menuInfo->min_price * $request->menu_quantity,
                ];
    
                Session::push($cartString, $item_array);
            }
        }
        
        return response()->json(['status' => 'success', 'message' => 'Item added in cart']);

}




public function fetch_menu_Cart_edit(Request $request)
{
   
     $cartString = 'edit_order_data_' . $request->order_id;
    // 
    // return    $retrievedOrderData = Session::get($cartString);
    $grandsum = 0;
    $orderTotal = 0 ;
    $cart = '';
    //   return Session::get($cartString);
    if (Session::get($cartString) != null) {
        $i = 1;
        foreach (Session::get($cartString) as $keys => $values) {
            $menu_id = Session::get($cartString)[$keys]["menu_id"];
            $order_id = Session::get($cartString)[$keys]["order_id"];
            $menu_name = Session::get($cartString)[$keys]["menu_name"];
            $menu_quantity = Session::get($cartString)[$keys]["menu_quantity"];
            $unit_price = Session::get($cartString)[$keys]["unit_price"];
            $unit_discount_price = Session::get($cartString)[$keys]["unit_discount_price"];
            // $unit_total_price = Session::get($cartString)[$keys]["unit_total_price"];
            $menu_price_after_discount = Session::get($cartString)[$keys]["menu_price_after_discount"];
            
            
            $totalPrice = Session::get($cartString)[$keys]["menu_quantity"] * $menu_price_after_discount;

            $cart .= '<tr><td style="text-align: center;">' . $i++ . '<input type="hidden" name="ids[]" id="id_' . $menu_id . '_' . $order_id . '" value="' . $menu_id . '" /><input type="hidden" name="ordercode[]" id="ordercode_' . $menu_id . '_' . $order_id . '" value="' . $menu_id . '" /></td>' .
                    '<td>' . $menu_name.'</td>' .
                    '<td><input type="text" class="form-control" style="text-align: center;width: 100%;" id="menu_quantity_details' . $menu_id  . '_' . $order_id  . '"  name="menu_quantity[]" onkeyup="loadCartandUpdatedetails(' . $menu_id  . ',' . $order_id  . ')" value="' . $menu_quantity . '" /></td>' .
                    '<td class="tex-right">' . $unit_price . '</td>' .
                    '<td><input type="text" class="form-control" style="text-align: center;width: 100%;" id="menu_discount_details' .$menu_id  . '_' . $order_id  . '"  name="menu_discount[]" onkeyup="loadCartandUpdatedetails(' . $menu_id  . ',' . $order_id  . ')" value="' . $unit_discount_price .'" />  </td>' .
                    '<td><input type="text" class="form-control" style="text-align: center;width: 100%;" id="menu_price_after_discount_details' . $menu_id  . '_' . $order_id  . '"  name="menu_price_after_discount[]" onkeyup="loadCartandUpdatedetails(' . $menu_id  . ',' . $order_id  . ')" value="' . $menu_price_after_discount . '" readonly/></td>' .
                    '<td style="text-align: right;"><span id="totalPricedetails_' . $menu_id  . '_' . $order_id  . '">' . numberFormat($totalPrice) . '</span></td>' .
                    '<td style="text-align: center;"><a href="#" onclick="itemremoveCartdetails(' . $menu_id  . ',' . $order_id  . ')" style="color:red;"><i class="fa fa-trash"> </i></a></td></tr>';
                     $grandsum += $totalPrice;
        
                }
        } 

        $cart .= '<tr><td colspan="6" class="text-right">Total Tk : </td><td id="totalAmountdetails" class="text-right">' . numberFormat($grandsum) . '</td></tr>';
        
        $data = array(
            'cart' => $cart,
            'totalAmountdetails' => $grandsum,
        );

        return $data;

}


public function update_menu_Cart_details(Request $request)
{
   
    $cartString = 'edit_order_data_' . $request->order_id;
  
  $cartData = Session::get($cartString);

    foreach ($cartData as $key => $value) {
        if ($value['menu_id'] == $request->menu_id && $value['order_id'] == $request->order_id) {
            $cartData[$key]['menu_quantity'] = $request->menu_quantity;
            $cartData[$key]['menu_discount'] = $request->menu_discount;
            // Calculate the price after discount
         $cartData[$key]['menu_price_after_discount'] = $cartData[$key]['unit_price'] - ($cartData[$key]['unit_price'] * ($cartData[$key]['menu_discount'] / 100));
            
            
            Session::put($cartString, $cartData);
            return response()->json(['status' => 'success', 'message' => 'Cart updated successfully']);
    }
}

    return response()->json(['status' => 'error', 'message' => 'Cart data not found']);
}

public function EditremoveCartitem(Request $request)
{
    // return $request;
     
    $menu_id = $request->menu_id;
    $order_id = $request->order_id; 
    $data = '';
    $cartData = Session::get('edit_order_data_' . $order_id); 
    if (is_array($cartData) && count($cartData) > 0) {
        foreach ($cartData as $key => $value) {
            if ($value['menu_id'] == $menu_id && $value['order_id'] == $order_id) {
                unset($cartData[$key]);
                Session::put('edit_order_data_' . $order_id, $cartData); 
                $data = "Success";
                break;
            }
        }
    } else {
        $data = "No items in cart";
    }
    return response()->json(['message' => $data]);
}



public function EditcheckoutOrder(Request $request)
{   
        //  return $request->Grandsum;
    $order_id = $request->order_id;
    $Party_id = $request->party_id;
    if($Party_id == '0'){
        if($request->contact == ''){
            $Party_id = '6';
        }
        else{
            $party = new Party();
            $party->name = $request->name;
            $party->contact = $request->contact;
            $party->current_due = '0.00';
            $party->opening_due = '0.00';
            $party->party_type = 'Walkin_Customer';
            $party->created_by = auth()->user()->id;
            $party->created_date = date('Y-m-d H:i:s');
            $party->deleted = 'No';
            $party->status = 'Active';
            $party->save();
            $Party_id = $party->id;
        }
        
    }
    else{
        $Party_id = $request->party_id;
       
    }
    $totalAmount = $request->totalAmount;
    $previousGrandSum = $request->Previous_Grandsum;
    $GrandTotalSum = $request->Grandsum;

    $Current_Payment = $request->current_payment;
    $Grand_due_sum = $request->Partycurrent_due;
    $Payment_Method = $request->payment_method;
    if($request->Partycurrent_due >0){
        $Current_Balance = $request->Partycurrent_due; 
    }
    else{
        $Current_Balance = '0.00';
    }
   
    $cartString = 'edit_order_data_' . $order_id;

    if (!Session::has($cartString) || empty(Session::get($cartString))) {
        return response()->json(['status' => 'error', 'message' => 'No items in the cart to checkout']);
    }
    // Start a transaction to ensure atomicity
    DB::beginTransaction();

    try {
        $cartData = Session::get($cartString);
        $grandTotal = 0;
        $totalDiscount = 0;
        $TotalDiscount = 0;
        $Totalamount =0;
        
  
        
        foreach ($cartData as $item) {
            $Totalamount += $item['menu_quantity'] * $item['menu_price_after_discount'];
           
        }
        
        
        $order =  Order::find($order_id);
        $order->grand_total = $GrandTotalSum; 
        $order->vat = $request->Vat;
        $order->grand_discount = $request->TotalDiscountAmount;
        $order->paid_amount = $Current_Payment;
        $order->total_amount = $Totalamount;
        $order->order_status = $request->OrderStatus;
        $order->due = $Current_Balance;
        $order->updated_by= auth()->user()->id;
        $order->save();
        $order_id=$order->id;
        foreach ($cartData as $cartItem) {
         
            $menuPrice = isset($cartItem['menu_price']) ? $cartItem['menu_price'] : 0;
            $itemTotalAmount = $cartItem['menu_quantity'] * $cartItem['menu_price_after_discount'];
            $itemDiscount = isset($cartItem['menu_discount']) ? $cartItem['menu_price_after_discount'] : 0;
            $grandTotal += $itemTotalAmount;
            $totalDiscount += $cartItem['menu_quantity'] * $itemDiscount;
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id; 
            $orderDetail->menu_id = $cartItem['menu_id'];
            $orderDetail->unit_price = $menuPrice; 
            $orderDetail->menu_quantity = $cartItem['menu_quantity'];
            $orderDetail->unit_discount_price = $itemDiscount;
            $orderDetail->unit_total_price = $itemTotalAmount;
            $orderDetail->updated_by = auth()->user()->id;
            $orderDetail->save();
        }

        if (floatval($Grand_due_sum) > 0) {
          
            $maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
            $maxCode++;
            $maxCode = str_pad($maxCode, 6, '000000', STR_PAD_LEFT);;
            $paymentVoucher = new PaymentVoucher();
            $paymentVoucher->party_id = $Party_id;
            $paymentVoucher->voucherNo = $maxCode;
            $paymentVoucher->amount = floatval($Grand_due_sum);
            $paymentVoucher->payment_method = 'Cash';
            $paymentVoucher->resturant_order_id  = $order_id;
            $paymentVoucher->discount  = $TotalDiscount;
            $paymentVoucher->type  = 'Party Payable';
            $paymentVoucher->voucherType  = 'WalkinSale';
            $paymentVoucher->remarks  = 'WalkinSale: ' . ' payment: ' . $Grand_due_sum;
            $paymentVoucher->updated_by  = auth()->user()->id;
            $paymentVoucher->save();
            
            $party = Party::find($Party_id);
            $party->increment('current_due', $Grand_due_sum);

            if (floatval( $Current_Payment) > 0) {
                $maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
                $maxCode++;
                $maxCode = str_pad($maxCode, 6, '000000', STR_PAD_LEFT);
                $paymentVoucher = new PaymentVoucher();
                $paymentVoucher->voucherNo = $maxCode;
                $paymentVoucher->party_id = $Party_id;
                $paymentVoucher->resturant_order_id  = $order_id;
                $paymentVoucher->amount = floatval( $Current_Payment);
                $paymentVoucher->payment_method = 'Cash';
                $paymentVoucher->paymentDate  = $request->date;
                $paymentVoucher->type  = 'Payment Received';
                $paymentVoucher->voucherType  = 'WalkinSale';
                $paymentVoucher->remarks  = 'WalkinSale: ' . ' payment: ' . $GrandTotalSum;
                $paymentVoucher->updated_by  = auth()->user()->id;
                $paymentVoucher->save();
                $party = Party::find($Party_id);
                $party->decrement('current_due',   $Current_Payment);
            }
        }
                                $voucher = new AccountsVoucher();
                                $voucher->vendor_id = $Party_id;
                                $voucher->tbl_resturantOrder_id  = $order_id;
                                $voucher->transaction_date = now();
                                $voucher->amount = floatval($Grand_due_sum);
                                $voucher->payment_method = $request->payment_method;
                                $voucher->deleted = "No";
                                $voucher->status = "Active";
                                $voucher->last_updated_by = Auth::user()->id;
                                $voucher->updated_date = date('Y-m-d h:s');
                                $voucher->save();


                                $voucherId = $voucher->id;
                                $salesCoaId = ChartOfAccounts::where('slug', '=', 'Sales')->first()->id;
                                
                                $voucherDetails = new AccountsVoucherDetails();
                                $voucherDetails->tbl_acc_voucher_id = $voucherId;
                                $voucherDetails->tbl_acc_coa_id = $salesCoaId;
                                $voucherDetails->tbl_resturantOrder_id  = $order_id;
                                $voucherDetails->transaction_date = now();
                                $voucherDetails->credit = floatval($Grand_due_sum);
                                $voucherDetails->voucher_title = 'Order amount paid ' . $Current_Payment . ' Tk , Date:  '. (new \DateTime())->format('Y-m-d H:i:s');
                                $voucherDetails->deleted = "No";
                                $voucherDetails->status = "Active";
                                $voucherDetails->last_updated_by = Auth::user()->id;
                                $voucherDetails->updated_date = date('Y-m-d h:s');
                                $voucherDetails->save();

                                if ($Current_Payment > 0) {

                                    $voucherDetails = new AccountsVoucherDetails();
                                    $voucherDetails->tbl_acc_voucher_id = $voucherId;
                                    $voucherDetails->tbl_acc_coa_id = $salesCoaId; 
                                    $voucherDetails->tbl_resturantOrder_id  = $order_id;
                                    $voucherDetails->transaction_date =now();
                                    $voucherDetails->debit = floatval($Current_Payment);
                                    $voucherDetails->voucher_title = 'Order done, Date: ' . (new \DateTime())->format('Y-m-d H:i:s');
                                    $voucherDetails->deleted = "No";
                                    $voucherDetails->status = "Active";
                                    $voucherDetails->last_updated_by = Auth::user()->id;
                                    $voucherDetails->updated_date = date('Y-m-d H:i:s');
                                    $voucherDetails->save(); 
    
                                }
            Session::forget($cartString);
        DB::commit();
        return response()->json(['status' => 'success', 'message' => 'Order successfully Updated', 'order_id' => $order->id]);
    } catch (Exception $e) {
        DB::rollback();
    
        return response()->json(['status' => 'error', 'message' => 'Checkout failed: ' . $e->getMessage()]);
    }
}

public function getorderlist(Request $request, $filterByTypeDateParty) {
    
    $filterbytable = '';
    $filter = Carbon::now()->toDateString();

   
    $filterByDatetableArray = explode("@", $filterByTypeDateParty);
    $filterDays = $filterByDatetableArray[0]; 

   
    if ($filterDays !== "Today" && $filterDays !== 'FilterBytable') {
        $filter = Carbon::now()->subDays($filterDays)->format('Y-m-d'); 
    }
 
  

    // if (count($filterByDatetableArray) == 2 && !empty($filterByDatetableArray[1])) {
    //     $filterbytable = $filterByDatetableArray[1]; 
    // }

 
 $orderdata = DB::table('tbl_restaurant_order')
    ->leftJoin('tbl_restaurant_order_details', 'tbl_restaurant_order.id', '=', 'tbl_restaurant_order_details.order_id')
    ->leftJoin('tbl_inventory_products', 'tbl_restaurant_order_details.menu_id', '=', 'tbl_inventory_products.id')
    ->leftJoin('tbl_voucher_payment_vouchers', 'tbl_restaurant_order.id', '=', 'tbl_voucher_payment_vouchers.resturant_order_id')
    ->leftJoin('tbl_crm_parties', 'tbl_restaurant_order.party_id', '=', 'tbl_crm_parties.id')
    ->select(
        'tbl_restaurant_order.id as order_id', 
        'tbl_restaurant_order.paid_amount', 
        'tbl_restaurant_order.vat', 
        'tbl_restaurant_order.code', 
        'tbl_restaurant_order.grand_discount', 
        'tbl_restaurant_order.order_status', 
        'tbl_restaurant_order.table_id',
        'tbl_restaurant_order.order_date', 
        'tbl_restaurant_order.due', 
        'tbl_restaurant_order.grand_discount', 
        'tbl_restaurant_order.grand_total AS order_total',
        'tbl_restaurant_order.party_id',
        'tbl_voucher_payment_vouchers.payment_method',
        'tbl_restaurant_order_details.id AS order_detail_id',
        'tbl_restaurant_order_details.menu_quantity', 
        'tbl_restaurant_order_details.menu_id', 
        'tbl_restaurant_order_details.product_broken_type', 
        'tbl_restaurant_order_details.unit_total_price', 
        'tbl_restaurant_order_details.unit_price', 
        'tbl_restaurant_order_details.sub_quantity', 
        'tbl_restaurant_order_details.sub_unit_price',
        'tbl_crm_parties.name AS party_name', 
        'tbl_crm_parties.code AS party_code', 
        'tbl_crm_parties.contact AS party_contact', 
        'tbl_crm_parties.address AS party_address', 
        'tbl_inventory_products.name AS menu_name'
    )
   
    ->where('tbl_restaurant_order.deleted', 'No')
    ->where('tbl_restaurant_order_details.deleted', 'No')
    ->when(!empty($filter), function ($query) use ($filter) {  
        $query->where('tbl_restaurant_order.order_date', '>=', $filter);
    })
   
    ->orderBy('tbl_restaurant_order.id', 'DESC')
    ->get();


    $output = array('data' => array());
    $groupedOrders = []; 
    
    foreach ($orderdata as $orders) {
      
        if (!isset($groupedOrders[$orders->order_id])) {
            
            $groupedOrders[$orders->order_id] = [
                'menu_items' => '',
                'party_name' => $orders->party_name,
                'product_broken_type' => $orders->product_broken_type,
                'party_address' => $orders->party_address,
                'sub_quantity' => $orders->sub_quantity,
                'paid_amount' => $orders->paid_amount,
                'payment_method' => $orders->payment_method,
                'code' => $orders->code,
                'grand_discount' => $orders->grand_discount,
                'vat' => $orders->vat,
                'sub_unit_price' => $orders->sub_unit_price,
                'party_contact' => $orders->party_contact,
                'order_total' => $orders->order_total,
                'due' => $orders->due,
                'order_status' => $orders->order_status,
                'order_date' => $orders->order_date,
                'order_id' => $orders->order_id
            ];
        }
    
                if ($orders->product_broken_type == 'Yes'){
                $qty=$orders->sub_quantity.' '.'piece';
                $unitPrice=$orders->sub_unit_price;
            }else{
                $qty=$orders->menu_quantity;
                $unitPrice=$orders->unit_price;
            }
      
        // $groupedOrders[$orders->order_id]['menu_items'] .= '<b>Menu Name: </b>' . $orders->menu_name . '<br><b>Menu Quantity: </b>' . $qty. '<br>'.'<br>';
    }
    
 
    $i = 1;
    foreach ($groupedOrders as $order) {
        $status = $order['order_status'] == 'Open'
            ? '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;" title="' . $order['order_status'] . '"></i></center>'
            : ($order['order_status'] == 'Pending'
                ? '<center><i class="fas fa-times-circle" style="color:Yellow; font-size:16px;" title="' . $order['order_status'] . '"></i></center>'
                : '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;" title="' . $order['order_status'] . '"></i></center>');
        
        $button = '<td style="width: 12%;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                               
                                 <li class="action"><a class="btn" onclick="confirmDelete(' . $order['order_id'] . ')"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                 <li class="action"><a class="btn" onclick="printorderBill(' . $order['order_id']  . ')"><i class="fas fa-file-pdf"></i> Invoice</a></li>
                                </ul>
                            </div>
                        </td>'; 
                        
        $output['data'][] = array(
            $i++ . '<input type="hidden" name="id" id="id" value="' . $order['order_id'] . '" />',
         $order['code'],
         $order['order_date'],
         '<b>Party: </b>' . $order['party_name'] . '<br><b>Contact: </b>' . $order['party_contact'] . '<br><b>Address: </b>' . $order['party_address'],
            '<b>Total: </b>'. $order['order_total']. '<br><b>Discount: </b>' . $order['grand_discount']. '<br><b>Vat: </b>' . $order['vat']. '<br><b>Ait: </b>' . $order['vat']. '<br><b>Grand Total: </b>' . $order['order_total']. '<br><b>Paid Amount: </b>' . $order['paid_amount'] ,
            $order['payment_method'] ,
            $order['order_status'],
            $button
        );
    }
    
    return $output;
}


public function listedit(Request $request){
    $orders =  Order::find($request->id);
    return $orders;
}

public function orderdelete(Request $request)
    {
        $orders =  Order::find($request->id);
        $orders->deleted = 'Yes';
        $orders->status = "Inactive";
        $orders->deleted_by = auth()->user()->id;
        $orders->deleted_date = date('Y-m-d H:i:s');
        $orders->save();


        $orderDetail =  OrderDetail::where('id', '=', $orders->id)->first();
        $orderDetail->order_id = $orders->id; 
        $orderDetail->status = 'Inactive'; 
        $orderDetail->deleted = 'Yes';
        $orderDetail->deleted_by = auth()->user()->id;
        $orderDetail->save();

        $paymentVoucher = PaymentVoucher::where('resturant_order_id', '=', $orders->id)->first();
        $paymentVoucher->status = 'Inactive'; 
        $paymentVoucher->deleted = 'Yes';
        $paymentVoucher->deleted_by = auth()->user()->id;
        $paymentVoucher->save();               



         
      $voucher = AccountsVoucher::where('tbl_resturantOrder_id', '=', $request->id)->first();
       $voucher->deleted = "Yes";
        $voucher->status = "Inactive";
        $voucher->deleted_by = Auth::user()->id;
        $voucher->save();

        $voucherDetails =  AccountsVoucherDetails::where('tbl_resturantOrder_id', '=', $request->id)->first();
       $voucherDetails->deleted = "Yes";
        $voucherDetails->status = "Inactive";
        $voucherDetails->deleted_by = Auth::user()->id;
        $voucherDetails->save();


       


        return response()->json(['success' => 'order deleted successfully']);
}
    public function createPDF($id)
    {
      
        

        $orderinvoicedata = DB::table('tbl_restaurant_order_details')
        ->leftJoin('tbl_restaurant_order', 'tbl_restaurant_order_details.order_id', '=', 'tbl_restaurant_order.id')
      
        ->leftJoin('tbl_inventory_products', 'tbl_restaurant_order_details.menu_id', '=', 'tbl_inventory_products.id')
        ->leftJoin('tbl_crm_parties', 'tbl_restaurant_order.party_id', '=', 'tbl_crm_parties.id')
        ->select(
            'tbl_restaurant_order_details.id', 
            'tbl_restaurant_order_details.menu_quantity', 
            'tbl_restaurant_order.id as order_id', 
            'tbl_restaurant_order.paid_amount', 
            'tbl_restaurant_order.grand_discount', 
            'tbl_restaurant_order.vat', 
            'tbl_restaurant_order.due', 
            'tbl_restaurant_order.created_by', 
            'tbl_restaurant_order_details.menu_id', 
            'tbl_restaurant_order_details.unit_total_price', 
            'tbl_restaurant_order_details.unit_price', 
            'tbl_crm_parties.name AS party_name', 
            'tbl_crm_parties.code AS party_code', 
            'tbl_crm_parties.contact AS party_contact', 
            'tbl_inventory_products.name AS menu_name',
            'tbl_restaurant_order.order_date', 
            'tbl_restaurant_order.due', 
            'tbl_restaurant_order.grand_total AS order_total',
            'tbl_restaurant_order.party_id'
        )
        ->where('tbl_restaurant_order_details.deleted', 'No') 
        ->where('tbl_restaurant_order.deleted', 'No') 
        ->where('tbl_restaurant_order.id',$id)
          ->get();

          
        //   $customPaper = array(0,0,283.80,567.00);

        $pdf = PDF::loadView('admin.Sweets_and_confectionery.order.order_invoice', ['orderinvoicedata'=> $orderinvoicedata]);
        return $pdf->stream('order_invoice-pdf.pdf', array("Attachment" => false));
}
}
