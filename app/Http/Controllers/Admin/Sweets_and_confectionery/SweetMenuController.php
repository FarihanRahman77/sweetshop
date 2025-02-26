<?php

namespace App\Http\Controllers\Admin\Sweets_and_confectionery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\inventory\Product;
use App\Models\Setups\Warehouse;
use App\Models\Crm\Party;
use App\Models\Setups\Currentstock;
use App\Models\hotelManagement\Building;
use App\Models\sweetsandConfectionary\OrderModel;
use App\Models\sweetsandConfectionary\OrderDetail;
use App\Models\sweetsandConfectionary\Food;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\Voucher\PaymentVoucher;
use App\Models\Voucher\AccountsVoucher;
use App\Models\Voucher\AccountsVoucherDetails;
use App\Models\Setups\SisterConcernCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;
use App\Models\setups\Category;
use App\Models\Setups\Brand;
use App\Models\Setups\Unit;
use PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Traits\PaymentVoucherTrait;


class SweetMenuController extends Controller
{
    use PaymentVoucherTrait;
    public function index()
    {    
        $data['categories'] = Category::where('deleted', 'No')->where('status','=','Active')->where('name','!=','Service')->get();
        $data['brands'] = Brand::where('deleted', 'No')->where('status','=','Active')->where('name','!=','Service')->get();
        $data['units'] = Unit::where('deleted', 'No')->where('status','=','Active')->get();
        $data['warehouses'] = Warehouse::where('deleted', 'No')->where('status','=','Active')->get();
        $data['sisterconcern'] = DB::table('tbl_settings_company_settings')->where('deleted', 'No')->where('status', 'Active') ->get();
             
        return view('admin.Sweets_and_confectionery.menu.menuView', $data);
    }


    public function create()
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];

        $categories = SisterConcernCategory::leftjoin('tbl_setups_categories', 'tbl_setups_categories.id', '=', 'tbl_setups_sisterconcern_categories.category_id')
            ->select('tbl_setups_categories.name', 'tbl_setups_sisterconcern_categories.*')
            ->where('tbl_setups_sisterconcern_categories.sister_concern_id', '=', $logged_sister_concern_id)
            ->where('tbl_setups_sisterconcern_categories.deleted', 'No')
            ->where('tbl_setups_categories.deleted', 'No')
            ->where('tbl_setups_sisterconcern_categories.status', '=', 'Active')
            ->where('tbl_setups_categories.status', '=', 'Active')
            ->get();
        
        return view('admin.Sweets_and_confectionery.menu.menuAdd', ['categories' => $categories]);
    }


    public function getMenu()
    {
        $products = DB::table('tbl_inventory_products')
            ->leftjoin('tbl_setups_brands', 'tbl_inventory_products.brand_id', '=', 'tbl_setups_brands.id')
            ->leftjoin('tbl_setups_units', 'tbl_inventory_products.unit_id', '=', 'tbl_setups_units.id')
            ->leftjoin('tbl_setups_categories', 'tbl_inventory_products.category_id', '=', 'tbl_setups_categories.id')
            ->select('tbl_inventory_products.id', 'tbl_inventory_products.status', 'tbl_inventory_products.type', 'tbl_inventory_products.image', 'tbl_inventory_products.name', 'tbl_inventory_products.model_no', 'tbl_inventory_products.code', 'tbl_inventory_products.barcode_no', 'tbl_inventory_products.opening_stock', 'tbl_inventory_products.current_stock', 'tbl_inventory_products.remainder_quantity', 'tbl_inventory_products.purchase_price', 'tbl_inventory_products.sale_price', 'tbl_inventory_products.discount', 'tbl_setups_categories.name as categoryName', 'tbl_setups_brands.name as brandName', 'tbl_setups_units.name as unitName')
            ->where('tbl_inventory_products.deleted', 'No')
            ->orderBy('tbl_inventory_products.id', 'DESC')
            ->get();

        $output = array('data' => array());
        $i = 1;
        foreach ($products as $product) {
            $status = "";
            if ($product->status == 'Active') {
                $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;"></i></center>';
            } else {
                $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;"></i></center>';
            }
            $imageUrl = url('upload/product_images/thumbs/' . $product->image);
            if($product->type == 'service'){
                $button = '<td style="width: 12%;">
                <div class="btn-group">
                    <button type="button" class="btn btn-cyan dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                        <li class="action liDropDown" onclick="editProduct(' . $product->id . ')"  ><a  class="btn" ><i class="fas fa-edit"></i> Edit </a></li></li>
                        <li class="action liDropDown"><a   class="btn"  onclick="confirmDelete(' . $product->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
                        </li> 
                        </ul>
                    </div>
                </td>';
            }else{
                $button = '<td style="width: 12%;">
                <div class="btn-group">
                    <button type="button" class="btn btn-cyan dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                        <li class="action liDropDown" onclick="editProduct(' . $product->id . ')"  ><a  class="btn" ><i class="fas fa-edit"></i> Edit </a></li></li>
                        <li class="action liDropDown" onclick="editOpenStock(' . $product->id . ')"  ><a  class="btn" ><i class="fas fa-edit"></i> Update Opening Stock</a></li></li>
                    </li>
                        <li class="action liDropDown"><a   class="btn"  onclick="confirmDelete(' . $product->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
                        </li> 
                        </ul>
                    </div>
                </td>';
            }
           

            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $product->id . '" />',
                '<b>Name: </b>'.$product->name . '<br><b>Code: </b>' . $product->code,
                '<b>Category: </b>' . $product->categoryName . ' <br><b>Brand: </b>' . $product->brandName . '<br><b>Unit: </b>' . $product->unitName . '<br><b>Type: </b>' . Str::ucfirst($product->type),
                '<center><img style="max-width:50px; max-height:80px;" src="' . $imageUrl . '" alt="no image" /></center>',
                '<b>OS: </b>' . $product->opening_stock . '<br><b>RQ: </b>' . $product->remainder_quantity . '<br><b>Available: </b>' . $product->current_stock,
                '<b>CP: </b>' . Session::get('companySettings')[0]['currency'] . ' ' . $product->purchase_price . '<br><b>PP: </b>' . Session::get('companySettings')[0]['currency'] . ' ' . $product->sale_price,
                $status,
                // $button
            );
        }
        return $output;
    }


    public function getmenucarddetails(Request $request)
    {
        $menu_id = $request->id;
        // $menu = Product::find($menu_id);
        $menu =DB::table('tbl_inventory_products')
        ->leftJoin('tbl_setups_brands', 'tbl_inventory_products.brand_id', '=', 'tbl_setups_brands.id')
        ->leftJoin('tbl_setups_units', 'tbl_inventory_products.unit_id', '=', 'tbl_setups_units.id')
        ->leftJoin('tbl_currentstock', 'tbl_inventory_products.id', '=', 'tbl_currentstock.tbl_productsId') // Corrected join condition
        ->leftJoin('tbl_setups_categories', 'tbl_inventory_products.category_id', '=', 'tbl_setups_categories.id') // Corrected join condition
        ->select(
            'tbl_inventory_products.id', 
            'tbl_inventory_products.status', 
            'tbl_inventory_products.type', 
            'tbl_inventory_products.image', 
            'tbl_inventory_products.name', 
            'tbl_inventory_products.model_no', 
            'tbl_inventory_products.code', 
            'tbl_inventory_products.barcode_no',
            'tbl_inventory_products.opening_stock', 
            'tbl_inventory_products.current_stock', 
            'tbl_inventory_products.remainder_quantity',
            'tbl_inventory_products.purchase_price', 
            'tbl_inventory_products.sale_price', 
            'tbl_inventory_products.discount', 
            'tbl_setups_categories.name as categoryName', 
            'tbl_setups_brands.name as brandName', 
            'tbl_setups_units.name as unitName',
            'tbl_currentstock.broken_remaining', 
            'tbl_currentstock.broken_damage', 
            'tbl_currentstock.broken_quantity', 
            'tbl_currentstock.broken_sold'
        )
        ->where('tbl_inventory_products.deleted', 'No')
        ->where('tbl_inventory_products.status', 'Active')
        ->where('tbl_setups_brands.deleted', 'No')
        ->where('tbl_setups_brands.status', 'Active')
        ->where('tbl_setups_categories.deleted', 'No')
        ->where('tbl_setups_categories.status', 'Active')
        ->where('tbl_inventory_products.id', '=', $menu_id)
        ->orderBy('tbl_inventory_products.id', 'DESC')
        ->first();
    

       $menuImages = DB::table('tbl_inventory_products')
        ->where('id', '=', $request->id)
        ->where('deleted', 'No')
        ->where('status', '=', 'Active')
        ->get();
        $imageHtml = '';
        if (count($menuImages) > 1) {
            $imageUrl = '';
            foreach ($menuImages as $image) {
                $imageUrl .= asset('upload/product_images/thumbs/' . $image->image);
                $imageHtml .= '<div class="col-md-4">
                                    <img src="' . $imageUrl . '" class="img-fluid productItem menuimg" alt="{{$image->image}}">
                                </div>';
            }
        } else {
            $imageUrl = '';
            foreach ($menuImages as $image) {
                $imageUrl .= asset('upload/product_images/thumbs/' . $image->image);
                $imageHtml .= '<div class="d-flex justify-content-center " >
                                <img src="' . $imageUrl . '" class="img-fluid" style="width:200px;" alt="{{ $image->image }}">
                            </div>';
            }
        }

        $data = array('menu' => $menu, 'imageHtml' => $imageHtml);
        return $data;
    }



    public function clearCart(Request $request)
	{
        $userId = auth()->user()->id;
		Session::forget('menu_item_purchase_cart_array_' . $userId);
		return response()->json('Success');
		
	}



    public function checkoutmenuOrder(Request $request)
    {  
       // return $request;
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];

        $Party_id = $request->partyid;
        $party = Party::find($Party_id);
        
        if (!$party) {
            $party = new Party();
            $party->name = $request->partyname;
            $party->contact = $request->partyPhoneNumber;
            $party->current_due = '0.00';
            $party->opening_due = '0.00';
            $party->party_type = 'Walkin_Customer';
            $party->created_by = auth()->user()->id;
            $party->created_date = now(); 
            $party->deleted = 'No';
            $party->status = 'Active';
            $party->save();
            $Party_id = $party->id;
        }

        $totalAmount = $request->totalAmount;
        
        $Current_Balance = '0.00';
        $userId = auth()->user()->id;
        $cartString = 'menu_item_purchase_cart_array_' . $userId;
        
        if (!Session::has($cartString) || empty(Session::get($cartString))) {
            return response()->json(['status' => 'error', 'message' => 'No items in the cart to checkout']);
        }
        
        DB::beginTransaction();
        try {
            $due=$request->totalAmount - $request->payment;
            $cartData = Session::get($cartString);
            $maxCode = OrderModel::where('deleted', 'No')->max('code');
            $maxCode++;
            $maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);
            $order = new OrderModel();
            $order->code =  $maxCode;
            $order->discount = $request->discount;
            $order->vat = $request->vat;
            $order->ait = $request->ait;
            $order->grand_total = $request->grandTotal;
            $order->total_amount = $request->totalAmount;
            $order->payment_method = $request->payment_method;
            $order->party_id = $Party_id;
            $order->paid_amount = $request->payment;
            $order->order_status = 'Closed';
            $order->due =$due;
            $order->created_by= auth()->user()->id;
            $order->save();
            $order_id=$order->id;
            foreach ($cartData as $cartItem) {
                 
                $menuPrice = isset($cartItem['menu_price']) ? $cartItem['menu_price'] : 0;
                $itemTotalAmount = $cartItem['menu_quantity'] * $cartItem['menu_price_after_discount'];
                $subitemTotalAmount = $cartItem['sell_qty'] * $cartItem['menu_price_after_break'];
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id; 

                if ($cartItem['quantity_type'] == 'broken quantity') {
                    $orderDetail->product_broken_type = 'Yes';
                    $orderDetail->sub_quantity = $cartItem['sell_qty'];
                    $orderDetail->sub_unit_price = $cartItem['menu_price_after_break'];
                    $orderDetail->menu_id = $cartItem['product_id'];
                    $orderDetail->unit_price = $cartItem['menu_price_after_discount'];
                    $orderDetail->menu_quantity = $cartItem['menu_quantity'];
                    $orderDetail->unit_discount_price = '0';
                    $orderDetail->unit_price_after_discount = $cartItem['menu_price'];
                    $orderDetail->unit_total_price = $subitemTotalAmount;
                } else {
                    $orderDetail->product_broken_type = 'No'; 
                    $orderDetail->sub_quantity = 0; 
                    $orderDetail->sub_unit_price = 0;
                    $orderDetail->menu_id = $cartItem['product_id'];
                    $orderDetail->unit_price = $cartItem['menu_price_after_discount'];
                    $orderDetail->menu_quantity = $cartItem['menu_quantity'];
                    $orderDetail->unit_discount_price = '0';
                    $orderDetail->unit_price_after_discount = $cartItem['menu_price'];
                    $orderDetail->unit_total_price = $itemTotalAmount;
                }
                
                $orderDetail->created_by= auth()->user()->id;
                $orderDetail->save();

                $Currentstock = Currentstock::where("tbl_productsId", $cartItem['product_id'])
                                ->where("deleted", 'No')
                                ->first();
            
            if ($Currentstock) {
                $Currentstock->decrement('currentStock', $cartItem['menu_quantity']);
                $Currentstock->increment('salesStock', $cartItem['menu_quantity']); 
                $Currentstock->broken_quantity = $cartItem['broken_qty']; 
                $Currentstock->broken_sold     = $cartItem['sell_qty'];
                $Currentstock->broken_remaining = $cartItem['broken_qty'] - $cartItem['sell_qty'];
                $Currentstock->broken_perslice_price = $cartItem['menu_price_after_break'];
                $Currentstock->entryBy         = auth()->user()->id;
                $Currentstock->entryDate       = date('Y-m-d H:i:s');
                $Currentstock->save();
            } else {
                $Currentstock_insert = new Currentstock();
                $Currentstock_insert->tbl_productsId  = $cartItem['product_id'];
                $Currentstock_insert->currentStock    = $cartItem['Current_Stock'];
                $Currentstock_insert->salesStock      = $cartItem['menu_quantity'];
                $Currentstock_insert->broken_quantity = $cartItem['broken_qty']; 
                $Currentstock_insert->broken_sold     = $cartItem['sell_qty'];
                $Currentstock_insert->broken_remaining = $cartItem['broken_qty'] - $cartItem['sell_qty'];
                $Currentstock_insert->broken_perslice_price = $cartItem['menu_price_after_break'];
                $Currentstock_insert->entryBy         = auth()->user()->id;
                $Currentstock_insert->entryDate       = date('Y-m-d H:i:s');
                $Currentstock_insert->save();
            }

            }
        
                $payemntMethod=ChartOfAccounts::find($request->payment_method);

                $maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
                $maxCode++;
                $maxCode = str_pad($maxCode, 6, '000000', STR_PAD_LEFT);

                $this->storePartyPayable($maxCode, $Party_id, $request->totalAmount, $order_id,$payemntMethod->name, $request->payment_method,$voucherType='WalkinSale', $type='Party Payable', $remarks='WalkinSale: ' . ' party payable: ' . $request->totalAmount);
                if($request->payment >0){
                    $this->storePaymentReceived($maxCode, $Party_id, $request->payment, $order_id,$payemntMethod->name, $request->payment_method,$voucherType='WalkinSale', $type='Payment Received', $remarks='WalkinSale: ' . 'payment received: ' . $request->payment);
                }

                $voucher = new AccountsVoucher();
                $voucher->tbl_resturantOrder_id  = $order_id;
                $voucher->vendor_id = $Party_id;
                $voucher->transaction_date = now();
                $voucher->amount = floatval($totalAmount);
                $voucher->payment_method = 'Cash';
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
                $voucherDetails->transaction_date = now();
                $voucherDetails->credit = floatval($totalAmount);
                $voucherDetails->voucher_title = 'Order amount paid ' . $totalAmount . ' Tk , Date:  '. (new \DateTime())->format('Y-m-d H:i:s');
                $voucherDetails->deleted = "No";
                $voucherDetails->status = "Active";
                $voucherDetails->created_by = Auth::user()->id;
                $voucherDetails->created_date = date('Y-m-d h:s');
                $voucherDetails->save();

            Session::forget($cartString);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Order successfully placed', 'menuorder_id' => $order->id]);
        } catch (Exception $e) {
            DB::rollback();
        
            return response()->json(['status' => 'error', 'message' => 'Checkout failed: ' . $e->getMessage()]);
        }
    }

    public function getMenu_itms_list()
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];

        $categories = SisterConcernCategory::leftjoin('tbl_setups_categories', 'tbl_setups_categories.id', '=', 'tbl_setups_sisterconcern_categories.category_id')
            ->select('tbl_setups_categories.name', 'tbl_setups_sisterconcern_categories.*')
            ->where('tbl_setups_categories.category_type', '=', 'Sweets_and_confectionery')
            ->where('tbl_setups_sisterconcern_categories.sister_concern_id', '=', $logged_sister_concern_id)
            ->where('tbl_setups_sisterconcern_categories.deleted', 'No')
            ->where('tbl_setups_categories.deleted', 'No')
            ->where('tbl_setups_sisterconcern_categories.status', '=', 'Active')
            ->where('tbl_setups_categories.status', '=', 'Active')
            ->get();

        $defaultParty=Party::find(1);
        $payemntMethods=ChartOfAccounts::where('parent_id','5')->get();
        return view('admin.Sweets_and_confectionery.menu.menu_itms_lists', ['categories' => $categories,'defaultParty'=>$defaultParty,'payemntMethods'=>$payemntMethods]);
    }



    public function addtocard(Request $request) {
        if (!auth()->check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    
        $userId = auth()->user()->id;
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $cartString = 'menu_item_purchase_cart_array_' . $userId;
        $available_quantity = 0;
        $is_available = false;
    
        $cartData = Session::get($cartString, []);
        
        foreach ($cartData as $key => $value) {
            if ($value['product_id'] == $request->id && $value['user_id'] == $userId) {
                $cartData[$key]['menu_quantity'] += $request->menu_quantity;
                Session::put($cartString, $cartData);
                $is_available = true;
                break;
            }
        }
    
        if (!$is_available) {
            $menuInfo = Product::leftJoin('tbl_setups_categories', 'tbl_setups_categories.id', '=', 'tbl_inventory_products.category_id')
                ->select('tbl_inventory_products.*', 'tbl_setups_categories.name as categoryName', 'tbl_inventory_products.image')
                ->where('tbl_inventory_products.sister_concern_id', '=', $logged_sister_concern_id)
                ->where('tbl_inventory_products.deleted', 'No')
                ->where('tbl_inventory_products.status', '=', 'Active')
                ->where('tbl_inventory_products.id', $request->id)
                ->first();
    
            if (!$menuInfo) {
                return response()->json(['error' => 'Menu item not found'], 404);
            }
    
            if ($menuInfo->stock_check == 'Yes') {
                $currentStockInfo = CurrentStock::where('deleted', 'No')
                    ->where('tbl_productsId', $menuInfo->id)
                    ->first();
    
                $available_quantity = $currentStockInfo ? $currentStockInfo->currentStock : 0;
    
                if ($request->menu_quantity > $available_quantity) {
                    return response()->json(['error' => 'Not enough stock available'], 400);
                }
            }
    
            $item_array = [
                'product_id'                   => $menuInfo->id,
                'user_id'                      => $userId,
                'menu_name'                    => $menuInfo->name,
                'menu_code'                    => $menuInfo->code,
                'Current_Stock'                => $menuInfo->current_stock ?? 0, 
                'category_name'                => $menuInfo->categoryName,
                'available_qty'                => $available_quantity,
                'menu_quantity'                => $request->menu_quantity,
                'menu_price'                   => $menuInfo->purchase_price,
                'menu_discount'                => $menuInfo->discount,
                'menu_price_after_discount'    => $menuInfo->sale_price,
                'menu_image'                   => $menuInfo->image,
                'quantity_type'                => 'full quantity',
                'menu_price_after_break'       => 0,
                'broken_qty'                   => 0,
                'sell_qty'                     => 0
            ];
    
            $cartData[] = $item_array;
            Session::put($cartString, $cartData);
        }
    
        return response()->json(['success' => 'Item added to cart'], 200);
    }


    // public function fetch_menu_Cart_item()
    // {
    //     $userId = auth()->user()->id;
    //     $cartString = 'menu_item_purchase_cart_array_' . $userId;
    //     $logged_sister_concern_id = Session::get('companySettings')[0]['id'];

    //     $grandTotal = 0;
    //     $cart = '';
    //     $cartData = Session::get($cartString);  

    //     if ($cartData != null && count($cartData) > 0) {
    //         $i = 1;
    //         foreach ($cartData as $key => $values) {
    //             $product_id = $values['product_id'];
    //             $userId = $values['user_id'];
    //             $menu_name = $values['menu_name'];
    //             $menu_code = $values['menu_code'];
    //             $menu_quantity = $values['menu_quantity'];
    //             $menu_price = $values['menu_price'];
    //             $category_name = $values['category_name'];
    //             $available_qty = $values['available_qty'];
    //             $menu_discount = $values['menu_discount'];
    //             $menu_price_after_discount = $values['menu_price_after_discount'];
    //             $menu_price_after_Break = $values['menu_price_after_break'] ;
    //             $menu_image = $values['menu_image'];
    //             $menu_quantity_type = $values['quantity_type'];
    //             $menu_broken_quantity = $values['broken_qty'];
    //             $menu_broken_Sell_quantity = $values['sell_qty'];
    //             $subtotal = floatval($menu_quantity) * floatval($menu_price_after_discount);
    //             // $subtotal = (float)$menu_quantity * (float)$menu_price_after_discount;
    //             //$quantity_show = $menu_quantity * $menu_price_after_discount;
    //             if ($menu_quantity_type == 'broken quantity') {
               
    //                 $subtotal_show = round(floatval($menu_broken_Sell_quantity) * floatval($menu_price_after_Break), 2);
    //             } else {
                   
    //                  $subtotal_show = round(floatval($menu_quantity) * floatval($menu_price_after_discount), 2);
                
    //             }
                

                           
    //             $cart .= '<tr class="text-center" width="100%">
    //                             <input type="hidden" name="ids[]" id="id_' . $product_id . '" value="' . $product_id . '"/><input type="hidden" name="user_id[]" id="user_id_' . $userId . '" value="' . $product_id . '" />
    //                             <input type="hidden" name="min_price[]"  id="min_price_' . $product_id . '_' . $userId . '"   value="' . $menu_price_after_discount . '"/>
    //                             <td width="15%" class="p-1"> 
    //                                 <img class="img-fluid" src="' . asset('upload/product_images/thumbs/' . $menu_image) . '" alt="' . $menu_image . '"  id="carditemimg" /> 
    //                             </td>
    //                             <td width="25%" class="p-1">
    //                                 ' . $menu_name . '
    //                             </td>
    //                             <td width="20%" class="p-1"> 
    //                                 <input type="text" class="form-control text-center" style="width: 100%;"  id="menu_quantity_' . $product_id . '_' . $userId . '" name="menu_quantity[]" oninput="loadmenuCartandUpdate(' . $product_id . ',' . $userId . ')" value="'. $menu_quantity . '" step="1" min="0"/>
    //                             </td>
    //                             <td width="10%" class="p-1" id="menusubtotal">
    //                                 ' .$subtotal. '
    //                             </td>
    //                             <td width="10%" class="p-1" id="menubreak_item_subtotal">
    //                                 ' .$menu_broken_Sell_quantity. '
    //                             </td>
    //                             <td width="10%" class="p-1" id="menubreak_item_subtotal_price">
    //                                 ' .$subtotal_show. '
    //                             </td>
    //                             <td width="10%" class="d-flex justify-content-right">
    //                                 <a href="#" onclick="deleteCartItem('.$product_id.','.$userId.')" class="text-danger mx-2"> <i class="fa fa-trash text-danger"></i> </a>
    //                                 <a href="#" onclick="cutitems('.$product_id.')"  class="text-danger mx-2"> <i class="fa fa-cut text-danger"></i> </a>
    //                             </td>
    //                      </tr>';
                      

    //             $grandTotal += $subtotal_show; 
    //             }
    //             $Grandtotal_amount = (float)$grandTotal; 
              
    //             $cart .= '<tr>
    //                             <td colspan="5" class="text-right">Total Tk:</td>
    //                             <td  class="text-right" > <span id="totalAmount"> ' . $Grandtotal_amount . '<sapn></td>
    //                             <td></td>
    //                      </tr>';
    //         } 
    //         else {
    //             $cart = '<tr><td colspan="3" class="text-center">Your cart is empty.</td></tr>';
    //         }

    //         $data = [
    //             'cart' => $cart,
    //             'totalAmount' => $grandTotal
    //         ];

    //     return response()->json($data);
    // }   


    public function fetch_menu_Cart_item()
    {
        $userId = auth()->user()->id;
        $cartString = 'menu_item_purchase_cart_array_' . $userId;
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];

        $grandTotal = 0;
        $cart = '';
        $cartData = Session::get($cartString);  

        if ($cartData != null && count($cartData) > 0) {
            $i = 1;
            foreach ($cartData as $key => $values) {
                $product_id = $values['product_id'];
                $userId = $values['user_id'];
                $menu_name = $values['menu_name'];
                $menu_code = $values['menu_code'];
                $menu_quantity = $values['menu_quantity'];
                $menu_price = $values['menu_price'];
                $category_name = $values['category_name'];
                $available_qty = $values['available_qty'];
                $menu_discount = $values['menu_discount'];
                $menu_price_after_discount = $values['menu_price_after_discount'];
                $menu_price_after_Break = $values['menu_price_after_break'] ;
                $menu_image = $values['menu_image'];
                $menu_quantity_type = $values['quantity_type'];
                $menu_broken_quantity = $values['broken_qty'];
                $menu_broken_Sell_quantity = $values['sell_qty'];
                $subtotal = floatval($menu_quantity) * floatval($menu_price_after_discount);
                // $subtotal = (float)$menu_quantity * (float)$menu_price_after_discount;
                //$quantity_show = $menu_quantity * $menu_price_after_discount;
                if ($menu_quantity_type == 'broken quantity') {
                   //return $menu_broken_Sell_quantity;
                    $subtotal_show = round(floatval($menu_broken_Sell_quantity) * floatval($menu_price_after_Break), 2);
                } else {
                   
                     $subtotal_show = round(floatval($menu_quantity) * floatval($menu_price_after_discount), 2);
                
                }
                
            
                           
                $cart .= '<tr class="text-center" width="100%">  
                                <input type="hidden" name="ids[]" id="id_' . $product_id . '" value="' . $product_id . '"/><input type="hidden" name="user_id[]" id="user_id_' . $userId . '" value="' . $product_id . '" />
                                <input type="hidden" name="min_price[]"  id="min_price_' . $product_id . '_' . $userId . '"   value="' . $menu_price_after_discount . '"/>
                                <td  class="p-1"> 
                                    <img class="img-fluid rounded-circle" src="' . asset('upload/product_images/thumbs/' . $menu_image) . '" alt="' . $menu_image . '"  id="carditemimg" /> 
                                </td>
                                <td class="p-1">
                                    ' . $menu_name . '
                                </td>
                                <td class="p-1">
                                    <input type="text" class="form-control text-center" style="width: 100%;"  id="menu_quantity_' . $product_id . '_' . $userId . '" name="menu_quantity[]" oninput="loadmenuCartandUpdate(' . $product_id . ',' . $userId . ');validateNumericInput(this);" value="'. $menu_quantity . '" step="1" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                </td>
                                <td class="p-1" id="menubreak_item_subtotal">
                                    ' .$menu_broken_Sell_quantity. '
                                </td>
                                <td class="p-1" id="menusubtotal">
                                    ' .$subtotal.'
                                </td>
                                
                                <td class="p-1" id="menubreak_item_subtotal_price">
                                    ' .$subtotal_show. '
                                </td>

                                <td class="d-flex justify-content-right">
                                    <a href="#" onclick="deleteCartItem('.$product_id.','.$userId.')" class="text-danger mx-2"> <i class="fa fa-trash text-danger"></i> </a>
                                    <a href="#" onclick="cutitems('.$product_id.')"  class="text-danger mx-2"> <i class="fas fa-box-open text-danger"></i> </a>
                                </td>
                            </tr>';
                      

                $grandTotal += $subtotal_show; 
                }
                //$Grandtotal_amount = (float)$grandTotal; 
              
                
            } 
            
            
            else {
                $cart = '<tr><td colspan="3" class="text-center">Your cart is empty.</td></tr>';
            }

            $data = [
                'cart' => $cart,
                'totalAmount' => $grandTotal
            ];

        return response()->json($data);
    }





    public function fetch_menu_Cart_item_modaldata(Request $request)
    {
         // return $request;
        $productId = $request->input('product_id'); 
        if (!$productId) {
            return response()->json(['cart' => 'Product ID not received.']);
        }
        $userId = auth()->user()->id;
        $cartString = 'menu_item_purchase_cart_array_' . $userId;
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $grandTotal = 0;
        $cart = '';
        $cartData = Session::get($cartString);
    
        if ($cartData != null && count($cartData) > 0) {
            $i = 1;
            foreach ($cartData as $key => $values) {
                if ($values['product_id'] == $productId) {  
                    $product_id = $values['product_id'];
                    $userId = $values['user_id'];
                    $menu_name = $values['menu_name'];
                    $menu_code = $values['menu_code'];
                    $menu_quantity = $values['menu_quantity'];
                    $menu_price = $values['menu_price'];
                    $category_name = $values['category_name'];
                    $available_qty = $values['available_qty'];
                    $menu_image = $values['menu_image'];
                    $menu_price_after_discount = $values['menu_price_after_discount'];
                    $breaksubtotal =$menu_quantity * $menu_price_after_discount;
    
                    $cart .= '<tr>  
                                <input type="hidden" name="ids[]" id="Productid" value="' . $product_id . '"/>
                                <input type="hidden" name="user_id[]" id="user_id" value="' . $userId . '" />
    
                                <td style="width: 15%; margin-top:14px; text-align: center; white-space: nowrap;">
                                    
                                    <img src="' . asset('upload/product_images/thumbs/' . $menu_image) . '" alt="' . $menu_image . '" id="carditemimg" />
                                </td>
                                <td style="width: 40%;margin-top:14px; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $menu_name . '</td>
                               
                                <td style="width: 25%; text-align: center; margin-top:14px;">
                                    <input type="number" class="form-control text-center" style="width: 100%;"  id="menu_quantity_break" name="menu_quantity[]"  value="'. $menu_quantity . '" step="1" min="0" readonly/>
                                </td>
                                <td style="width: 20%; text-align: center; margin-top:14px;">
                                    <input type="number" class="form-control text-center" style="width: 100%;"  id="menusubtotal_break" name="menusubtotal_break[]"  value="'. $breaksubtotal . '" step="1" min="0" readonly/>
                                </td>
                                
                               
                            </tr>';
                }
            }
        } else {
            $cart = '<tr><td colspan="3" class="text-center">Your cart is empty.</td></tr>';
        }
    
        $data = [
            'cart' => $cart,
        ];
    
        return response()->json($data);
    }







    public function removeCartmenuitem(Request $request)
    {
      
        $product_id = $request->menu_id;
        $userId = $request->userId; 
        $data = '';
        $cartData = Session::get('menu_item_purchase_cart_array_' . $userId); 
        if (is_array($cartData) && count($cartData) > 0) {
            foreach ($cartData as $key => $value) {
                if ($value['product_id'] == $product_id && $value['user_id'] == $userId) {
                    unset($cartData[$key]);
                    Session::put('menu_item_purchase_cart_array_' . $userId, $cartData); 
                    $data = "Success";
                    break;
                }
            }
        } else {
            $data = "No items in cart";
        }
        return response()->json(['message' => $data]);
    }








    public function updateCartmenuitem(Request $request){
        $data = ""; 
        $userId=$request->userId;
        $menuId=$request->menu_id;
        $cartString = 'menu_item_purchase_cart_array_' . $userId;
        $cartData = Session::get($cartString);
        
            if ($cartData) {
                foreach ($cartData as $key => $value) {
                    if ($value['product_id'] == $menuId && $value['user_id'] == $userId) {
                        $cartData[$key]['menu_quantity'] = $request->menu_quantity;
                        $cartData[$key]['menu_price_after_discount'] = $request->min_price;
                        Session::put($cartString, $cartData);
                        $data = ["status" => "success", "message" => "Cart updated successfully."];
                        break; 
                    }
                }
        } else {
            $data = ["status" => "error", "message" => "Cart data not found."];
        }
        return response()->json($data); 
    }


    public function updatebreakCartmenuitem(Request $request){
         // return $request->TotalsellSlice;
          $request;
                $data = ""; 
            $userId=$request->SetBreakSelluserId;
            $menuId=$request->SetBreakSellProductId;
            $cartString = 'menu_item_purchase_cart_array_' . $userId;
            
            $cartData = Session::get($cartString);
        
                if ($cartData) {
                    foreach ($cartData as $key => $value) {
                        if ($value['product_id'] == $menuId && $value['user_id'] == $userId) {
                            $cartData[$key]['menu_price_after_break'] = $request->breakslicepRiece;
                            $cartData[$key]['quantity_type'] = 'broken quantity';
                            $cartData[$key]['broken_qty'] = $request->menu_BreakQuantity;
                            $cartData[$key]['sell_qty'] = $request->TotalsellSlice;
                            Session::put($cartString, $cartData);
                            $data = ["status" => "success", "message" => "Cart updated successfully."];
                            break; 
                        }
                    }
            } 
            else {
                
                $data = ["status" => "error", "message" => "Cart data not found."];
            }
            return response()->json($data);
         }


    
    public function createmenuPDF($id)
    {
        
        $orderinvoicedata = DB::table('tbl_restaurant_order_details')
        ->leftJoin('tbl_restaurant_order', 'tbl_restaurant_order_details.order_id', '=', 'tbl_restaurant_order.id')
        ->leftJoin('tbl_crm_parties', 'tbl_restaurant_order.party_id', '=', 'tbl_crm_parties.id')
        ->leftJoin('tbl_inventory_products', 'tbl_restaurant_order_details.menu_id', '=', 'tbl_inventory_products.id')
 
        ->select(
            'tbl_restaurant_order_details.id', 
            'tbl_restaurant_order_details.menu_quantity', 
            'tbl_restaurant_order.id as order_id', 
            'tbl_restaurant_order.paid_amount', 
            'tbl_restaurant_order.grand_discount', 
            'tbl_restaurant_order.vat', 
            'tbl_restaurant_order.code AS restaurant_order_code', 
            'tbl_restaurant_order.due', 
            'tbl_restaurant_order.created_by', 
            'tbl_crm_parties.name AS party_name',  
            'tbl_crm_parties.contact AS party_contact', 
            'tbl_restaurant_order_details.menu_id', 
            'tbl_restaurant_order_details.product_broken_type', 
            'tbl_restaurant_order_details.unit_total_price', 
            'tbl_restaurant_order_details.unit_price', 
            'tbl_restaurant_order_details.sub_quantity', 
            'tbl_restaurant_order_details.sub_unit_price', 
            'tbl_inventory_products.name AS menu_name',
            'tbl_restaurant_order.order_date', 
            'tbl_restaurant_order.due', 
            'tbl_restaurant_order.grand_total AS order_total',
        
        )
        ->where('tbl_restaurant_order_details.deleted', 'No') 
        ->where('tbl_restaurant_order.deleted', 'No') 
        ->where('tbl_restaurant_order.id',$id)
          ->get();
                $customPaper = array(0,0,283.80,567.00);
                // $customPaper = array(0,0,567.00,283.80);
                $pdf = PDF::loadView('admin.Sweets_and_confectionery.menu.MenuOrderInvoice', ['orderinvoicedata'=> $orderinvoicedata])->setPaper($customPaper, 'Portrait');
                return $pdf->stream('MenuOrderInvoice.pdf', array("Attachment" => false));
    }



    public function getmenuRemainquantity(Request $request){
        // return $request;
        $Currentstock = Currentstock::where("tbl_productsId", $request->breakProduct_id)
        ->where("deleted", 'No')
        ->first();
    
            if ($Currentstock) {
                if ($Currentstock->broken_remaining >= $request->broken_remain_quantity) {
                    return response()->json(['success' => true, 'Currentstock' => $Currentstock]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Not Enough Remaining Item']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Currentstock not found']);
            }
    }



    // public function store(Request $request)
    // {

    //     $request->validate([
    //         'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
    //         'sort_code' => 'numeric|required',
    //         'max_price' => 'numeric|required',
    //         'min_price' => 'numeric|required',
    //         'discount_percentage' => 'numeric|required',
    //         'category_id' => 'required|numeric',
    //         'specNames' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
    //         'specValues' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
    //         'notes' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u'
    //     ]);

    //     $slug = preg_replace('/[^A-Za-z0-9-]+/', '_', $request->name);
    //     $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
    //     $maxCode = Menu::where('deleted', 'No')->max('code');
    //     $maxCode++;
    //     $maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);
    //     DB::beginTransaction();
    //     try {
    //         $menu = new Menu();
    //         $menu->name = $request->name;
    //         $menu->sort_code = $request->sort_code;
    //         $menu->slug = $slug;
    //         $menu->code = $maxCode;
    //         $menu->max_price = $request->max_price;
    //         $menu->min_price = $request->min_price;
    //         $menu->discount_percentage = $request->discount_percentage;
    //         $menu->category_id = $request->category_id;
    //         // $menu->firstLetter=$request->firstLetter;
    //         $menu->sister_concern_id = $logged_sister_concern_id;
    //         $menu->remarks = $request->notes;
    //         $menu->status = 'Active';
    //         $menu->created_by = auth()->user()->id;
    //         $menu->created_date = date('Y-m-d H:i:s');
    //         $menu->deleted = 'No';
    //         $menu->save();

    //         $specNames = explode(",", $request->specNames);
    //         $specValues = explode(",", $request->specValues);
    //         if ($specNames[0] != -1 || $specValues[0] != -1) {
    //             $i = 0;
    //             foreach ($specNames as  $specName) {
    //                 $spec = new MenuSpecification();
    //                 $spec->menu_id  = $menu->id;
    //                 $spec->text = $specName;
    //                 $spec->value = $specValues[$i];
    //                 $spec->created_by = auth()->user()->id;
    //                 $spec->created_date = date('Y-m-d H:i:s');
    //                 $spec->save();
    //                 $i++;
    //             }
    //         }

    //         if ($request->totalFilesToBeUploaded > 0) {
    //             for ($x = 0; $x < $request->totalFilesToBeUploaded; $x++) {
    //                 if ($request->hasFile('image' . $x)) {
    //                     $request->validate([
    //                         'image'   =>  'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
    //                     ]);
    //                     $file = $request->file('image' . $x);
    //                     $name = $file->getClientOriginalName();
    //                     $uploadPath = 'upload/menu_images/thumbs/';
    //                     $uploadResizePath = 'upload/menu_images/resizes/';
    //                     $uploadPathOriginal = 'upload/menu_images/';
    //                     $imageName = time() . $name;
    //                     $imageUrl = $uploadPath . $imageName;
    //                     $resizeUrl = $uploadResizePath . $imageName;
    //                     Image::make($file)->resize(360, 360)->save($resizeUrl);
    //                     Image::make($file)->resize(100, 100)->save($imageUrl);
    //                     $file->move(public_path($uploadPathOriginal), $imageName);
    //                 } else {
    //                     $imageName = "no_image.png";
    //                 }

    //                 $images = new MenuImage();
    //                 $images->image = $imageName;
    //                 $images->menu_id = $menu->id;
    //                 $images->save();
    //             }
    //         }

    //         DB::commit();
    //         return response()->json(['success' => 'Menu saved successfully']);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => "rollBack! Please try again" . $e]);
    //     }
    // }



    // public function edit(Request $request)
    // {
    //     $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
    //     $menu = Menu::find($request->id);
    //     $menuImages = MenuImage::where('menu_id', '=', $request->id)->where('deleted', '=', 'No')->get();
    //     $menuSpecifications = MenuSpecification::where('menu_id', '=', $request->id)->where('deleted', '=', 'No')->get();
    //     $categories = SisterConcernCategory::leftjoin('tbl_setups_categories', 'tbl_setups_categories.id', '=', 'tbl_setups_sisterconcern_categories.category_id')
    //         ->select('tbl_setups_categories.name', 'tbl_setups_sisterconcern_categories.*')
    //         ->where('tbl_setups_sisterconcern_categories.sister_concern_id', '=', $logged_sister_concern_id)
    //         ->where('tbl_setups_sisterconcern_categories.deleted', 'No')
    //         ->where('tbl_setups_categories.deleted', 'No')
    //         ->where('tbl_setups_sisterconcern_categories.status', '=', 'Active')
    //         ->where('tbl_setups_categories.status', '=', 'Active')
    //         ->get();
    //     $imageHtml = '';
    //     foreach ($menuImages as $image) {
    //         $imageUrl = url('upload/menu_images/' . $image->image);
    //         $imageHtml .= '<img class="m-1 menu-img" style="width:70px;height:70px;" src="' . $imageUrl . '" alt="' . $image->image . '" />
    //         <a href="##" class="cross-btn text-danger" onclick="deleteImage(' . $image->id . ')">X</a>';
    //     }

    //     $specHtml = '';
    //     foreach ($menuSpecifications as $spec) {
    //         $specHtml .= '<div class="row" id="' . $spec->id . '">
    //                         <div class=" col-5 mt-2">
    //                             <input class="form-control input-sm"  id="specName" type="text" name="specName" placeholder="Name" value="' . $spec->text . '">
    //                             <span class="text-danger" id="specError" ></span>
    //                         </div>
    //                         <div class=" col-5 mt-2">
    //                             <input class="form-control input-sm"  id="specValue" type="text" name="specValue" placeholder=" Value" value="' . $spec->value . '">
    //                             <span class="text-danger" id="specError"></span>
    //                         </div>
    //                         <div class=" col-1 mt-2">
    //                             <button type="button" class="btn btn-cyan btn-md add" onclick="addNewSpecRowService()">
    //                             <span class="glyphicon glyphicon-plus"style="font-size: 18px; font-weight:800;"><strong>+</strong></span></button>
    //                         </div>
    //                         <div class="col-1 mt-2">
    //                             <button type="button" class="btn btn-danger btn-md add" onclick="deletePrevSpecRow(' . $spec->id . ');">
    //                             <span class="glyphicon glyphicon-plus" style="font-size: 18px; font-weight:800;"><strong>x</strong></span></button>
    //                         </div>
    //                     </div>';
    //     }

    //     $data = array(
    //         'menu' => $menu,
    //         'imageHtml' => $imageHtml,
    //         'specHtml' => $specHtml,
    //     );
    //     return $data;
    // }



    // public function menuImageDelete(Request $request)
    // {
    //     $menuImage = MenuImage::find($request->id);
    //     $menuImage->deleted = "Yes";
    //     $menuImage->status = "Inactive";
    //     $menuImage->deleted_by = auth()->user()->id;
    //     $menuImage->deleted_date = date('Y-m-d H:i:s');
    //     $menuImage->save();
    //     $menuImages = MenuImage::where('menu_id', '=', $menuImage->menu_id)->where('deleted', '=', 'No')->get();
    //     $imageHtml = '';
    //     foreach ($menuImages as $image) {
    //         $imageUrl = url('upload/menu_images/' . $image->image);
    //         $imageHtml .= '<img class="m-1 menu-img" style="width:70px;height:70px;" src="' . $imageUrl . '" alt="' . $image->image . '" />
    //         <a href="##" class="cross-btn text-danger" onclick="deleteImage(' . $image->id . ')">X</a>';
    //     }

    //     return response()->json(['success' => 'Image deleted successfully', 'imageHtml' => $imageHtml]);
    // }


    // public function menuSpecDelete(Request $request)
    // {
    //     $menuSpec = MenuSpecification::find($request->id);
    //     $menuSpec->deleted = "Yes";
    //     $menuSpec->status = "Inactive";
    //     $menuSpec->deleted_by = auth()->user()->id;
    //     $menuSpec->deleted_date = date('Y-m-d H:i:s');
    //     $menuSpec->save();
    //     $menuSpecs = MenuSpecification::where('menu_id', '=', $menuSpec->menu_id)->where('deleted', '=', 'No')->get();
    //     $specHtml = '';
    //     foreach ($menuSpecs as $spec) {
    //         $specHtml .= '<div class="row" id="' . $spec->id . '">
    //                         <div class=" col-5 mt-2">
    //                             <input class="form-control input-sm"  id="specName" type="text" name="specName" placeholder="Name" value="' . $spec->text . '">
    //                             <span class="text-danger" id="specError" ></span>
    //                         </div>
    //                         <div class=" col-5 mt-2">
    //                             <input class="form-control input-sm"  id="specValue" type="text" name="specValue" placeholder=" Value" value="' . $spec->value . '">
    //                             <span class="text-danger" id="specError"></span>
    //                         </div>
    //                         <div class=" col-1 mt-2">
    //                             <button type="button" class="btn btn-cyan btn-md add" onclick="addNewSpecRowService()">
    //                             <span class="glyphicon glyphicon-plus"style="font-size: 18px; font-weight:800;"><strong>+</strong></span></button>
    //                         </div>
    //                         <div class="col-1 mt-2">
    //                             <button type="button" class="btn btn-danger btn-md add" onclick="deletePrevSpecRow(' . $spec->id . ');">
    //                             <span class="glyphicon glyphicon-plus" style="font-size: 18px; font-weight:800;"><strong>x</strong></span></button>
    //                         </div>
    //                     </div>';
    //     }

    //     return response()->json(['success' => 'Spec deleted successfully', 'specHtml' => $specHtml]);
    // }


    // public function update(Request $request)
    // {


    //     $request->validate([
    //         'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
    //         'maximum_price' => 'numeric|required',
    //         'minimum_price' => 'numeric|required',
    //         'discount_percentage' => 'numeric|required',
    //         'category_id' => 'required|numeric',
    //         'specNames' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
    //         'specValues' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
    //         'notes' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u'
    //     ]);
    //     $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
    //     $slug = preg_replace('/[^A-Za-z0-9-]+/', '_', $request->name);
    //     DB::beginTransaction();
    //     try {
    //         $menu = Menu::find($request->id);
    //         $menu->name = $request->name;
    //         $menu->sort_code = $request->sort_code;
    //         $menu->slug = $slug;
    //         // $menu->firstLetter=$request->firstLetter;
    //         $menu->max_price = $request->maximum_price;
    //         $menu->min_price = $request->minimum_price;
    //         $menu->discount_percentage = $request->discount_percentage;
    //         $menu->category_id = $request->category_id;
    //         $menu->sister_concern_id = $logged_sister_concern_id;
    //         $menu->remarks = $request->remarks;
    //         $menu->status = $request->status;
    //         $menu->updated_by = auth()->user()->id;
    //         $menu->updated_date = date('Y-m-d H:i:s');
    //         $menu->save();

    //         $specNames = explode(",", $request->specNames);
    //         $specValues = explode(",", $request->specValues);
    //         if ($specNames[0] != -1 || $specValues[0] != -1) {
    //             $i = 0;
    //             foreach ($specNames as  $specName) {
    //                 $spec = new MenuSpecification();
    //                 $spec->menu_id  = $request->id;
    //                 $spec->text = $specName;
    //                 $spec->value = $specValues[$i];
    //                 $spec->created_by = auth()->user()->id;
    //                 $spec->created_date = date('Y-m-d H:i:s');
    //                 $spec->save();
    //                 $i++;
    //             }
    //         }

    //         if ($request->hasFile('image')) {
    //             $request->validate([
    //                 'image'   =>  'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
    //             ]);
    //             $file = $request->file('image');
    //             $name = $file->getClientOriginalName();
    //             $uploadPath = 'upload/menu_images/thumbs/';
    //             $uploadResizePath = 'upload/menu_images/resizes/';
    //             $uploadPathOriginal = 'upload/menu_images/';
    //             $imageName = time() . $name;
    //             $imageUrl = $uploadPath . $imageName;
    //             $resizeUrl = $uploadResizePath . $imageName;
    //             Image::make($file)->resize(360, 360)->save($resizeUrl);
    //             Image::make($file)->resize(100, 100)->save($imageUrl);
    //             $file->move(public_path($uploadPathOriginal), $imageName);

    //             $images = new MenuImage();
    //             $images->image = $imageName;
    //             $images->menu_id = $request->id;
    //             $images->save();
    //         }

    //         DB::commit();
    //         return response()->json(['success' => 'Menu updated successfully']);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => "rollBack! Please try again" . $e]);
    //     }
    // }



   
    
    // public function delete(Request $request)
    // {
    //     $menu = Menu::find($request->id);
    //     $menu->status = "Inactive";
    //     $menu->deleted = "Yes";
    //     $menu->deleted_by = auth()->user()->id;
    //     $menu->deleted_date = date('Y-m-d H:i:s');
    //     $menu->save();
    //     $menuImages = MenuImage::where('menu_id', '=', $request->id)->where('deleted', '=', 'No')->get();
    //     foreach ($menuImages as $image) {
    //         $images = MenuImage::find($image->id);
    //         $images->status = "Inactive";
    //         $images->deleted = "Yes";
    //         $images->deleted_by = auth()->user()->id;
    //         $images->deleted_date = date('Y-m-d H:i:s');
    //         $images->save();
    //     }
    //     $menuSpecifications = MenuSpecification::where('menu_id', '=', $request->id)->where('deleted', '=', 'No')->get();
    //     foreach ($menuSpecifications as $spec) {
    //         $specs = MenuSpecification::find($spec->id);
    //         $specs->status = "Inactive";
    //         $specs->deleted = "Yes";
    //         $specs->deleted_by = auth()->user()->id;
    //         $specs->deleted_date = date('Y-m-d H:i:s');
    //         $specs->save();
    //     }
    //     return response()->json(['success' => 'Menu deleted successfully']);
    // }
}
