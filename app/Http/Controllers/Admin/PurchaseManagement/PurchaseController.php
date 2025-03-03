<?php

namespace App\Http\Controllers\Admin\PurchaseManagement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setups\CompanySetting;
use App\Models\Setups\Category;
use App\Models\inventory\Product;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseProduct;
use App\Models\Voucher\PaymentVoucher;
use App\Models\Setups\Brand;
use App\Models\Setups\Currentstock;
use App\Models\Crm\Party;
use App\Models\inventory\SerializeProduct;
use App\Models\Setups\Warehouse;
use App\Models\User;
use App\Models\Accounts\Voucher;
use App\Models\Voucher\AccountsVoucher;
use App\Models\Voucher\AccountsVoucherDetails;
use App\Models\Accounts\VoucherDetails;
use App\Models\Accounts\AccountConfiguration;
use App\Models\Accounts\ChartOfAccounts;
use Illuminate\Support\Facades\DB;
use Exception;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
	/* function __construct()
	{
		$this->middleware('permission:purchase.view', ['only' => ['index', 'getProducts']]);
		$this->middleware('permission:purchase.add', ['only' => ['add', 'checkOutCart']]);
		$this->middleware('permission:purchase.delete', ['only' => ['delete']]);
	} */

	public function index()
	{
		$suppliers = Party::select('id', 'name')->where('deleted', 'No')->where('status', 'Active')->whereIn('party_type', ["Both", "Supplier"])->get();
		return view('admin.PurchaseManagement.purchase.view-purchase', compact('suppliers'));
	}







	public function add()
	{             
		$data['logged_sister_concern_id'] = Session::get('companySettings')[0]['id'];
		$data['categories'] = Category::where('deleted', 'No')->where('status', 'Active')->get();
		$data['brands'] = Brand::where('deleted', 'No')->where('status', 'Active')->get();
		$data['products'] = Product::where('deleted', 'No')->where('status', 'Active')->where('type', '!=', 'service')->get();
		$data['suppliers'] = Party::where('deleted', 'No')->where('status', 'Active')->whereIn('party_type', ['Supplier', 'Both'])->get();
		$data['warehouses'] = Warehouse::where('deleted', 'No')->where('status', 'Active')->get();
		//$data['coas'] = ChartOfAccounts::where('deleted', 'No')->where('status', 'Active')/* ->where('parent_id', '=', '30') */->get();
		$data['sisterConcerns']=CompanySetting::where('deleted','=','No')->where('status','=','Active')->get();
		return view('admin.PurchaseManagement.purchase.add-purchase', $data);
	}





	public function supplierDue(Request $request)
	{
		$supplierDue = Party::find($request->id);
		return $supplierDue->current_due;
	}


	public function getPurchase(Request $request, $filterByTypeDateParty)
	{

		$tempFilterByTypeDatePartyArray = $filterByTypeDateParty;

		$filterByTypeDatePartyArray = explode("@", $tempFilterByTypeDatePartyArray);
		$filterBy = $filterByTypeDatePartyArray[0]; //  filterType d
		$filteringData = $filterByTypeDatePartyArray[1]; // days/partyId

		if ($filterBy === "days") {

			if ($filteringData != "Today") {
				$filteringData = Carbon::now()->subDays($filteringData)->format('Y-m-d 00:00:01');
				$request->request->add(['filterByDate' => $filteringData]);
			}else{
				$filteringData = Carbon::now()->toDateString(); //=> "2020-03-09"
				$request->request->add(['filterByDate' => $filteringData]);
			}

		} else {
			$request->request->add(['filterByParty' => $filteringData]);
		}
		
		$purchases = DB::table('tbl_purchases')
			->join('tbl_crm_parties', 'tbl_purchases.supplier_id', '=', 'tbl_crm_parties.id')
			->leftjoin('users', 'tbl_purchases.created_by', '=', 'users.id')
			->leftjoin('tbl_accounts_coas', 'tbl_accounts_coas.id', '=', 'tbl_purchases.coa_id')
			->leftjoin('tbl_settings_company_settings', 'tbl_settings_company_settings.id', '=', 'tbl_purchases.sister_concern_id')
			->select(
				'tbl_purchases.purchase_no',
				'tbl_purchases.created_date',
				'tbl_purchases.total_amount',
				'tbl_purchases.current_payment',
				'tbl_purchases.discount',
				'tbl_purchases.carrying_cost',
				'tbl_purchases.id',
				'tbl_purchases.grand_total',
				'tbl_purchases.status as purchaseStatus',
				'tbl_crm_parties.name',
				'tbl_crm_parties.code',
				'tbl_crm_parties.address',
				'tbl_crm_parties.contact',
				'tbl_crm_parties.alternate_contact',
				'users.name as userName',
				'tbl_accounts_coas.name as coaName',
				'tbl_settings_company_settings.name as companyname'
			)
			->where('tbl_purchases.deleted', 'No')
			->when($request->has('filterByDate'), function ($query) use ($request) {
				$query->where('tbl_purchases.date', '>=', $request->filterByDate);
			})
			->when($request->has('filterByParty'), function ($query) use ($request) {
				$query->where('tbl_purchases.supplier_id', $request->filterByParty);
			})
			->orderBy('tbl_purchases.id', 'DESC')
			->get();

		$output = array('data' => array());
		$i = 1;
		foreach ($purchases as $purchase) {
			$button = '<td style="width: 12%;">
			<div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<i class="fas fa-cog"></i>  <span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
						<li class="action" onclick="printPurchase(' . $purchase->id . ')"  ><a  class="btn" ><i class="fas fa-print"></i> View Details </a></li>
						</li> 
						<li class="action" onclick="addBarcode(' . $purchase->id . ')"  ><a  class="btn" ><i class="fas fa-barcode"></i> Add BArcode </a></li>
						</li> 
						<li class="action"><a   class="btn"  onclick="purchaseReturn(' . $purchase->id . ')" ><i class="fas fa-undo-alt"></i> Return Purchase </a></li>
						</li>
						<li class="action"><a   class="btn"  onclick="confirmDelete(' . $purchase->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
						</li>
					</ul>   
				</div>
			</td>';
			$badgeColor = '';
			if ($purchase->purchaseStatus == 'Active') {
				$badgeColor = 'success';
			} else {
				$badgeColor = 'danger';
			}
			$grandTotal = floatval($purchase->total_amount) - floatval($purchase->discount) + floatval($purchase->carrying_cost);
			$output['data'][] = array(
				$i++ . '<input type="hidden" name="id" id="id" value="' . $purchase->id . '" />',
				$purchase->purchase_no,
				date("d-m-Y h:i a", strtotime($purchase->created_date)),
				// $purchase->coaName,
				 $purchase->companyname ,
				'<b>Name: </b>' . $purchase->name . '<br><b>Contact: </b>' . $purchase->contact . '<br><b>Alt. Contact: </b>' . $purchase->alternate_contact . '<br><b>Address: </b>' . substr(str_pad($purchase->address, 4), 0, 25),
				'<b>Total: </b>' . $purchase->total_amount . '<br><b>Discount: </b>' . $purchase->discount . '<br><b>Transport: </b>' . $purchase->carrying_cost . '<br><b>GrandTotal: </b>' . $grandTotal . '  <br><b>Paid : </b>' . $purchase->current_payment,
				
				$purchase->userName,
				'<span class="badge badge-pill badge-' . $badgeColor . ' text-center">' . $purchase->purchaseStatus . '</span>',
				$button
			);
		}
		return $output;
	}


	public function addToCart(Request $request)
	{
		$data = '';
		$available_quantity = 0;
		$checkQuantity = 0;
		$productId = null;
		$product_type = '';
		if (Session::get("purchase_cart_array") != null) {
			$is_available = 0;
			foreach (Session::get("purchase_cart_array") as $keys => $values) {
				if ((Session::get("purchase_cart_array")[$keys]['product_id'] == $request->id && Session::get("purchase_cart_array")[$keys]['warehouse_id'] == $request->warehouseId) || (Session::get("purchase_cart_array")[$keys]['barcode_no'] == $request->barcode && $request->barcode != '')) {
					$is_available++;
					session()->put("purchase_cart_array." . $keys . ".product_quantity", Session::get("purchase_cart_array")[$keys]['product_quantity'] + $request->quantity);
					$checkQuantity = Session::get("purchase_cart_array")[$keys]['product_quantity'];
					$productId = $request->id;
					$product_type = Session::get("purchase_cart_array")[$keys]['product_type'];
				}
			}
			if ($is_available == 0) {
				if (isset($request->barcode)) {
					$productInfo = Product::where('deleted', 'No')->where('type', '!=', 'service')->where('status', 'Active')->where('barcode_no', $request->barcode)->first();
				} else if (isset($request->id)) {
					$productInfo = Product::where('deleted', 'No')->where('type', '!=', 'service')->where('status', 'Active')->where('id', $request->id)->first();
					$currentStockInfo = CurrentStock::where('deleted', 'No')->where('tbl_productsId', $productInfo->id)->where('tbl_wareHouseId', $request->warehouseId)->first();
					if ($currentStockInfo) {
						$available_quantity = $currentStockInfo->currentStock;
					} else {
						$available_quantity = 0;
					}
					$productId = $productInfo->id;
				}
				$temQuantity = array();
				$maxNumber = array();
				if ($productInfo->type == 'serialize') {
					$maxNumber = SerializeProduct::where('tbl_productsId', $productId)->max('serial_no');
					$temQuantity = $request->quantity;
				}
				$checkQuantity = $request->quantity;
				$product_type = $productInfo->type;
				$item_array = [
					'product_id'               =>     $productInfo->id,
					'product_name'             =>     $productInfo->name . ' - ' . $productInfo->code,
					'product_image'            =>     $productInfo->image,
					'available_qty'            =>     $available_quantity,
					'product_price'            =>     $productInfo->purchase_price,
					'product_quantity'         =>     $request->quantity,
					'product_discount'         =>     $productInfo->discount,
					'barcode_no'        	   =>     $productInfo->barcode_no,
					'warehouse_id'        	   =>     $request->warehouseId,
					'warehouse_name'           =>     $request->warehouseName,
					'product_type'        	   =>     $productInfo->type,
					'items_in_box'        	   =>     $productInfo->items_in_box,
					'serialNumbers'        	   =>     [$maxNumber],
					'stockQuantities'          =>     [$temQuantity]
				];
				Session::push('purchase_cart_array', $item_array);
			}
		} else {
			if (isset($request->barcode)) {
				$productInfo = Product::where('deleted', 'No')->where('type', '!=', 'service')->where('status', 'Active')->where('barcode_no', $request->barcode)->first();
			} else if (isset($request->id)) {
				$productInfo = Product::where('deleted', 'No')->where('type', '!=', 'service')->where('status', 'Active')->where('id', $request->id)->first();
				$currentStockInfo = CurrentStock::where('deleted', 'No')->where('tbl_productsId', $productInfo->id)->where('tbl_wareHouseId', $request->warehouseId)->first();
				if ($currentStockInfo) {
					$available_quantity = $currentStockInfo->currentStock;
				} else {
					$available_quantity = 0;
				}
				$productId = $productInfo->id;
				$checkQuantity = $request->quantity;
				$product_type = $productInfo->type;
			}
			$temQuantity = array();
			$maxNumber = array();
			if ($productInfo->type == 'serialize') {
				$serializeProduct =  DB::table('tbl_serialize_products')->orderBy('id', 'desc')
					->where('tbl_productsId', $productInfo->id)
					->first();
				if ($serializeProduct) {
					$maxNumber = $serializeProduct->serial_no + 1;
				}
				$temQuantity = $request->quantity;
			}

			$item_array = [
				'product_id'               =>     $productInfo->id,
				'product_name'             =>     $productInfo->name . ' - ' . $productInfo->code,
				'product_image'            =>     $productInfo->image,
				'available_qty'            =>     $available_quantity,
				'product_price'            =>     $productInfo->purchase_price,
				'product_quantity'         =>     $request->quantity,
				'product_discount'         =>     $productInfo->discount,
				'barcode_no'        	   =>     $productInfo->barcode_no,
				'warehouse_id'        	   =>     $request->warehouseId,
				'warehouse_name'           =>     $request->warehouseName,
				'product_type'        	   =>     $productInfo->type,
				'items_in_box'        	   =>     $productInfo->items_in_box,
				'serialNumbers'        	   =>     [$maxNumber],
				'stockQuantities'          =>     [$temQuantity]
			];
			Session::push('purchase_cart_array', $item_array);
		}
		$data .= "Success";
		return response()->json(['data' => $data, 'productId' => $productId, 'quantity' => $checkQuantity, 'warehouseId' => $request->warehouseId, 'product_type' => $product_type]);
	}

	public function fetchCart()
	{
		$grandTotal = 0;
		$cart = '';
		if (Session::get('purchase_cart_array') != null) {
			$i = 1;
			foreach (Session::get('purchase_cart_array') as $keys => $values) {
				if (Session::get("purchase_cart_array")[$keys]["product_discount"] > 0) {
					$unitPrice = Session::get("purchase_cart_array")[$keys]["product_price"];
					$totalPrice = Session::get("purchase_cart_array")[$keys]["product_quantity"] * $unitPrice;
				} else {
					$unitPrice = Session::get("purchase_cart_array")[$keys]["product_price"];
					$totalPrice = Session::get("purchase_cart_array")[$keys]["product_quantity"] * $unitPrice;
				}
				$productId = Session::get("purchase_cart_array")[$keys]["product_id"];
				$warehouseId = Session::get("purchase_cart_array")[$keys]["warehouse_id"];
				$productType = Session::get("purchase_cart_array")[$keys]["product_type"];
				if ($productType == "serialize") {
					$btn = ' <a href="#" onclick="showSerializTable(' . Session::get("purchase_cart_array")[$keys]["product_id"] . ', ' . Session::get("purchase_cart_array")[$keys]["warehouse_id"] . ', ' . Session::get("purchase_cart_array")[$keys]["product_quantity"] . ')"> <i class="fa fa-edit"> </i> </a>';
					$updateQty = "'" . "updateQty" . "'";
				} else {
					$btn = '';
					$updateQty = '';
				}
				$cart .= '<tr><td style="text-align: center;">' . $i++ . '<input type="hidden" name="ids[]" id="id_' . $productId . '_' . $warehouseId . '" value="' . $productId . '" /><input type="hidden" name="warehouseIds[]" id="warehouse_id_' . $productId . '_' . $warehouseId . '" value="' . $productId . '" /></td>' .
							'<td>' . Session::get("purchase_cart_array")[$keys]["product_name"] . ' [' . Session::get("purchase_cart_array")[$keys]["warehouse_name"] . ']</td>' .
							'<td style="text-align: center;"><span id="available_qty_' . $productId . '_' . $warehouseId . '">' . Session::get("purchase_cart_array")[$keys]["available_qty"] . '</span></td>' .
							'<td><input type="text" class="form-control quantityUpdate only-number" style="text-align: center;width: 80%;" id="quantity_' . $productId . '_' . $warehouseId . '" name="quantity[]" onkeyup="loadCartandUpdate(' . $productId . ',' . $warehouseId . ',' . $updateQty . ')" value="' . Session::get("purchase_cart_array")[$keys]["product_quantity"] . '" />' . $btn . '</td>' .
							'<td><input type="text" class="form-control" style="text-align: center;width: 100%;" id="unitPrice_' . $productId . '_' . $warehouseId . '"  name="unitPrice[]" onkeyup="loadCartandUpdate(' . $productId . ',' . $warehouseId . ')" value="' . $unitPrice . '" /></td>' .
							'<td style="text-align: right;"><span id="totalPrice_' . $productId . '_' . $warehouseId . '">' . numberFormat($totalPrice) . '</span></td>' .
							'<td style="text-align: center;">
								<a href="#" onclick="removeCartProduct(' . Session::get("purchase_cart_array")[$keys]["product_id"] . ', ' . Session::get("purchase_cart_array")[$keys]["warehouse_id"] . ')" style="color:red;"><i class="fa fa-trash"> </i> </a>								
							</td>
						</tr>';
				$grandTotal += $totalPrice;
			}
		}
		$cart .= '<tr><td colspan="5" class="text-right" > Total Tk : </td><td id="totalAmount" class="text-right"> ' . numberFormat($grandTotal) . '</td><td></td></tr>';
		$data = array(
			'cart' => $cart,
			'totalAmount' => $grandTotal
		);
		return response()->json(['data' => $data]);
	}

	public function removeProduct(Request $request)
	{
		$id = $request->id;
		$warehouseId = $request->warehouse_id;
		$data = '';
		$cartData = Session::get('purchase_cart_array');
		foreach (Session::get("purchase_cart_array") as $keys => $values) {
			if (Session::get("purchase_cart_array")[$keys]['product_id'] == $id && Session::get("purchase_cart_array")[$keys]['warehouse_id'] == $warehouseId) {
				unset($cartData[$keys]);
				Session::put('purchase_cart_array', $cartData);
				$data = "Success";
				break;
			}
		}
		$data = "Success";
		return response()->json(['data' => $data]);
	}

	public function updateCart(Request $request)
	{
		if (Session::get("purchase_cart_array") != null) {
			foreach (Session::get("purchase_cart_array") as $keys => $values) {
				if (Session::get("purchase_cart_array")[$keys]['product_id'] == $request->id && Session::get("purchase_cart_array")[$keys]['warehouse_id'] == $request->warehouseId) {
					session()->put("purchase_cart_array." . $keys . ".product_quantity", $request->quantity);
					session()->put("purchase_cart_array." . $keys . ".product_price", $request->unitPrice);
					// Serialize Product
					if (Session::get("purchase_cart_array")[$keys]['product_type'] == "serialize") {
						if ($request->has('product_type') && $request->product_type == true) {
							$serialNumbers = (explode(",", $request->serialNumbers));
							$stockQuantities = (explode(",", $request->stockQuantities));
							session()->put("purchase_cart_array." . $keys . ".serialNumbers", $serialNumbers);
							session()->put("purchase_cart_array." . $keys . ".stockQuantities", $stockQuantities);
						} else {
							$tempSerialNum = array(false);
							$tempQuantity = array($request->quantity);
							session()->put("purchase_cart_array." . $keys . ".serialNumbers", $tempSerialNum);
							session()->put("purchase_cart_array." . $keys . ".stockQuantities", $tempQuantity);
						}
					}
					// End Serialize Product
					$data = "Success";
				}
			}
		} else {
			$data = "";
		}
		return response()->json(['data' => $data]);
	}

	public function clearCart(Request $request)
	{
		Session::forget('purchase_cart_array');
		$data = "Success";
		return response()->json(['data' => $data]);
	}
	//=========== Start Serialize Product ===========//
	public function showSerializTable(Request $request)
	{
		$trId  = 0;
		$rows = '';
		foreach (Session::get("purchase_cart_array") as $keys => $values) {
			if (Session::get("purchase_cart_array")[$keys]['product_id'] == $request->id && Session::get("purchase_cart_array")[$keys]['warehouse_id'] == $request->warehouseId) {
				$product_id = Session::get("purchase_cart_array")[$keys]['product_id'];
				$warehouse_id = Session::get("purchase_cart_array")[$keys]['warehouse_id'];
				$items_in_box = Session::get("purchase_cart_array")[$keys]['items_in_box'];
				$function = '';
				if (Session::get("purchase_cart_array")[$keys]['stockQuantities'] && Session::get("purchase_cart_array")[$keys]['serialNumbers'][0] != false) {
					foreach (Session::get("purchase_cart_array")[$keys]['stockQuantities'] as $key => $stockQty) {
						$serialNum = Session::get("purchase_cart_array")[$keys]['serialNumbers'][$key];
						if ($key == 0) {
							$function = 'onchange="generateSerialNo(this.value)"';
						}
						$rows .= '<tr id="row' . $key . '">' .
							'<td>' . ($key + 1) . '</td>' .
							'<td><input class="form-control input-sm stockQuantity' . $key .
							'" id="stockQuantity" type="text" name="stockQuantity" placeholder=" Quantity... " required oninput="calculateTotalQuantity()" onblur="loadCartandUpdate(' . $product_id . ',' . $warehouse_id . ',' . TRUE . ')" value="' . $stockQty . '"  ></td>';
						$rows .=
							'<td><input class="form-control input-sm serialNo' . $key .
							'" id="serialNo" type="text" name="serialNo" placeholder=" Serial Number... " required value="' . $serialNum . '" ' . $function . '><td><a href="#" onclick="removeRow(' . $key . ')" style="color:red;"><i class="fa fa-trash"> </i> </a></td></td></tr>';
					}
				} else {
					$tempSerialNums = array();
					$tempQuantities = array();
					$serializeProduct =  DB::table('tbl_serialize_products')->orderBy('id', 'desc')
						->where('tbl_productsId', $product_id)
						->first();
					if ($serializeProduct) {
						$maxNumber = $serializeProduct->serial_no;
					}
					$totalQuantity = count(Session::get("purchase_cart_array")[$keys]['stockQuantities']) == 1 ? Session::get("purchase_cart_array")[$keys]['stockQuantities'][0] : 0;
					if ($trId == 0) {
						$function = 'onchange="generateSerialNo(this.value)"';
					}
					$avarageQty = ceil($totalQuantity / $items_in_box);
					for ($i = 0; $i < $avarageQty; $i++) {
						if ($totalQuantity < $items_in_box) {
							$items_in_box = $totalQuantity;
						}
						$rows .= '<tr id="row' . $i . '">' .
							'<td>' . ($i + 1) . '</td>' .
							'<td><input class="form-control input-sm stockQuantity' . $i .
							'" id="stockQuantity" type="text" name="stockQuantity" placeholder=" Quantity... " required oninput="calculateTotalQuantity()" onblur="loadCartandUpdate(' . $product_id . ',' . $warehouse_id . ',' . TRUE . ')" value="' . $items_in_box . '"  ></td>';
						$rows .=
							'<td><input class="form-control input-sm serialNo' . $i .
							'" id="serialNo" type="text" name="serialNo" placeholder=" Serial Number... " required value="' . ++$maxNumber . '" ' . $function . '><td><a href="#" onclick="removeRow(' . $i . ')" style="color:red;"><i class="fa fa-trash"> </i> </a></td></td></tr>';
						$tempSerialNums[$i] = $maxNumber;
						$tempQuantities[$i] = $items_in_box;
						$totalQuantity -= $items_in_box;
					}
					session()->put("purchase_cart_array." . $keys . ".serialNumbers", $tempSerialNums);
					session()->put("purchase_cart_array." . $keys . ".stockQuantities", $tempQuantities);
				}
			}
		}
		return response()->json(['displayTable' => $rows]);
	}
	//=========== End Serialize Product ===========//



	public function barcodeGenerate(Request $request){
		$data = "";
		if (Session::get("purchase_cart_array") != null) {
			foreach (Session::get("purchase_cart_array") as $keys => $values) {
				if (Session::get("purchase_cart_array")[$keys]['product_id'] == $request->id && Session::get("purchase_cart_array")[$keys]['warehouse_id'] == $request->warehouseId) {
				return	session()->put("purchase_cart_array." . $keys . ".product_quantity", $request->quantity);
				}
			}
		} else {
			$data = "";
		}
		return response()->json(['data' => $data]);
	}





	public function checkOutCart(Request $request)
	{
		//  return $request;
		$request->validate([
			'supplier' => 'required',
			'category' => 'required'
		]);

		DB::beginTransaction();
		try {
			$purchaseNo = Purchase::where('deleted', 'No')->max('purchase_no');
			$purchaseNo++;
			$purchaseNo = str_pad($purchaseNo, 6, '0', STR_PAD_LEFT);
			$purchase = new Purchase();
			$purchase->supplier_id = $request->supplier_id;
			$purchase->purchase_no = $purchaseNo;
			$purchase->coa_id = $request->category;
			$purchase->sister_concern_id = $request->sister_concern_id;
			$purchase->date = $request->date;
			$purchase->total_amount = floatval($request->total_amount);
			$purchase->discount = floatval($request->discount);
			$purchase->carrying_cost = floatval($request->carrying_cost);
			$grand_total = floatval($request->grand_total);
			$purchase->grand_total = $grand_total;
			$purchase->previous_due = floatval($request->previous_due);
			$purchase->current_balance = floatval($request->current_balance);
			$purchase->total_with_due = floatval($request->total_with_due);
			$current_payment = floatval($request->current_payment);
			$purchase->current_payment = $current_payment;
			$purchase->created_by = auth()->user()->id;
			$purchase->created_date = date('Y-m-d H:i:s');
			$purchase->save();
			$purchase_id = $purchase->id;
			foreach (Session::get("purchase_cart_array") as $keys => $values) {
				$product_id = Session::get("purchase_cart_array")[$keys]["product_id"];
				$warehouse_id = Session::get("purchase_cart_array")[$keys]["warehouse_id"];
				$product = Product::find($product_id);
				$unit_id = $product->unit_id;
				$unit_price = Session::get("purchase_cart_array")[$keys]["product_price"];
				$quantity = Session::get("purchase_cart_array")[$keys]["product_quantity"];
				$product->increment('purchase_quantity', $quantity);
				$product->increment('current_stock', $quantity);
				$subtotal = $unit_price * $quantity;
				$product->increment('total_purchase_price', $subtotal);
				$lot_no = PurchaseProduct::where("product_id", $product_id)->max('lot_no');
				$lot_no++;
				$tbl_purchase_products = new PurchaseProduct();
				$tbl_purchase_products->purchase_id = $purchase_id;
				$tbl_purchase_products->product_id = $product_id;
				$tbl_purchase_products->warehouse_id = $warehouse_id;
				$tbl_purchase_products->sister_concern_id = $request->sister_concern_id;
				$tbl_purchase_products->unit_id = $unit_id;
				$tbl_purchase_products->unit_price = floatval($unit_price);
				$tbl_purchase_products->quantity = $quantity;
				$tbl_purchase_products->lot_no = $lot_no;
				$tbl_purchase_products->subtotal = floatval($subtotal);
				$tbl_purchase_products->created_by = auth()->user()->id;
				$tbl_purchase_products->created_date = date('Y-m-d H:i:s');
				$tbl_purchase_products->save();
				// Start Serialize Product
				if (Session::get("purchase_cart_array")[$keys]["product_type"] == 'serialize') {
					$quantity = 0;
					if (Session::get("purchase_cart_array")[$keys]['stockQuantities']) {
						foreach (Session::get("purchase_cart_array")[$keys]['stockQuantities'] as $key => $stockQty) {
							$serialNum = Session::get("purchase_cart_array")[$keys]['serialNumbers'][$key];
							$serializeProduct = new SerializeProduct();
							$serializeProduct->tbl_productsId = $product_id;
							$serializeProduct->serial_no = $serialNum;
							$serializeProduct->warehouse_id = $warehouse_id;
							$serializeProduct->purchase_id = $purchase_id;
							$serializeProduct->quantity = $stockQty;
							$serializeProduct->created_by = auth()->user()->id;
							$serializeProduct->created_date = date('Y-m-d H:i:s');
							$serializeProduct->save();
							$quantity += $stockQty;
						}
					}
				}
				// End Serialize Product
				if (Session::get("purchase_cart_array")[$keys]["product_type"] == 'service') {
					continue;
				}
				$Currentstock = Currentstock::where("tbl_productsId", $product_id)
					->where("tbl_wareHouseId", $warehouse_id)
					->where("deleted", 'No');
				if ($Currentstock->first()) {
					$Currentstock->sister_concern_id = $request->sister_concern_id;
					$Currentstock->increment('currentStock', $quantity);
					$Currentstock->increment('purchaseStock', $quantity);
				} else {
					$Currentstock_insert = new Currentstock();
					$Currentstock_insert->tbl_productsId = $product_id;
					$Currentstock_insert->tbl_wareHouseId = $warehouse_id;
					$Currentstock_insert->currentStock = $quantity;
					$Currentstock_insert->purchaseStock = $quantity;
					$Currentstock_insert->sister_concern_id = $request->sister_concern_id;
					$Currentstock_insert->break_Quantity = 0;
					$Currentstock_insert->broken_quantity = 0;
					$Currentstock_insert->broken_sold = 0;
					$Currentstock_insert->broken_damage = 0;
					$Currentstock_insert->broken_remaining = 0;
					$Currentstock_insert->broken_perslice_price = 0;
					$Currentstock_insert->entryBy = auth()->user()->id;
					$Currentstock_insert->entryDate = date('Y-m-d H:i:s');
					$Currentstock_insert->save();
				}
			}
			$party = Party::find($request->supplier_id);
			$party->decrement('current_due', ($grand_total - $current_payment));

			$maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
			$maxCode++;
			$maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);;
			$paymentVoucher = new PaymentVoucher();
			$paymentVoucher->voucherNo = $maxCode;
			$paymentVoucher->party_id = $request->supplier_id;
			$paymentVoucher->purchase_id = $purchase_id;
			$paymentVoucher->amount = floatval($request->grand_total);
			$paymentVoucher->payment_method = 'Cash';
			$paymentVoucher->paymentDate  = $request->date;
			$paymentVoucher->type  = 'Payable';
			$paymentVoucher->voucherType  = 'Local Purchase';
			$paymentVoucher->remarks  = 'payable for purchase code: ' . $purchaseNo . ' payment: ' . $request->grand_total;
			$paymentVoucher->entryBy  = auth()->user()->id;
			$paymentVoucher->save();
			if (floatval($request->current_payment) > 0) {
				$maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
				$maxCode++;
				$maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);;
				$paymentVoucher = new PaymentVoucher();
				$paymentVoucher->voucherNo = $maxCode;
				$paymentVoucher->party_id = $request->supplier_id;
				$paymentVoucher->purchase_id = $purchase_id;
				$paymentVoucher->amount = floatval($request->current_payment);
				$paymentVoucher->payment_method = $request->payment_method;
				$paymentVoucher->paymentDate  = $request->date;
				$paymentVoucher->type  = 'Payment';
				$paymentVoucher->voucherType  = 'Local Purchase';
				$paymentVoucher->remarks  = 'Payment for purchase code: ' . $purchaseNo . ' payment: ' . $request->grand_total;
				$paymentVoucher->entryBy  = auth()->user()->id;
				$paymentVoucher->save();
			}



			/* accounts part start */
			$voucher = new AccountsVoucher();
			$voucher->vendor_id = $request->supplier_id;
			$voucher->transaction_date = $request->date;
			$voucher->amount = floatval($request->grand_total);
			$voucher->payment_method = $request->payment_method;
			$voucher->purchase_id = $purchase_id;
			$voucher->deleted = "No";
			$voucher->status = "Active";
			$voucher->created_by = Auth::user()->id;
			$voucher->created_date = date('Y-m-d h:s');
			$voucher->save();
			$voucherId = $voucher->id;

			

			$voucherDetails = new AccountsVoucherDetails();
			$voucherDetails->tbl_acc_voucher_id = $voucherId;
			$voucherDetails->tbl_acc_coa_id = $request->category;
			$voucherDetails->debit = floatval($request->grand_total);
			$voucherDetails->voucher_title = 'Purchase created with Purchase code ' . $purchaseNo;
			$voucherDetails->deleted = "No";
			$voucherDetails->status = "Active";
			$voucherDetails->created_by = Auth::user()->id;
			$voucherDetails->created_date = date('Y-m-d H:i:s');
			$voucherDetails->save();

			if ($request->current_payment > 0) {
				$voucherDetails = new AccountsVoucherDetails();
				$voucherDetails->tbl_acc_voucher_id = $voucherId;
				$voucherDetails->tbl_acc_coa_id = $request->category;
				$voucherDetails->credit = floatval($request->current_payment);
				$voucherDetails->voucher_title = 'Purchase amount paid with Purchase code ' . $purchaseNo;
				$voucherDetails->deleted = "No";
				$voucherDetails->status = "Active";
				$voucherDetails->created_by = Auth::user()->id;
				$voucherDetails->created_date = date('Y-m-d h:s');
				$voucherDetails->save();
			}

			$cashId = ChartOfAccounts::where('slug', '=', 'cash')->first();
			$cash = ChartOfAccounts::find($cashId->id);
			$cash->decrement('amount', $request->current_payment);
			/* accounts part end */


			Session::forget('purchase_cart_array');
			DB::commit();
			return response()->json(['Success' => 'Product purchased successfully', 'purchaseId' => $purchase_id]);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => 'Purchase rollBack!']);
		}
	}






	public function delete(Request $request)
	{       
		// return $request;
		DB::beginTransaction();
		try {
			$purchase = Purchase::find($request->id);
			$purchase->deleted = 'Yes';
			$purchase->deleted_date = date('Y-m-d H:i:s');
			$purchase->save();
			$currentPaymentInCash = $purchase->current_payment;

			$party = Party::find($purchase->supplier_id);
			$party->current_due = ($party->current_due - $purchase->current_payment + $purchase->grand_total);
			$party->save();

			$tbl_purchase_products = PurchaseProduct::where("purchase_id", $request->id)->get();
			foreach ($tbl_purchase_products as $purchase_product) {
				$purchaseProduct = PurchaseProduct::find($purchase_product->id);
				$purchaseProduct->deleted = 'Yes';

				$purchaseProduct->deleted_date = date('Y-m-d H:i:s');
				$purchaseProduct->deleted_by = auth()->user()->id;
				$purchaseProduct->save();

				$product = product::find($purchase_product->product_id);
				$quantity = intval($purchaseProduct->quantity);
				$unit_price = floatval($product->unit_price);
				$product->decrement('purchase_quantity', $quantity);
				$product->decrement('current_stock', $quantity);
				$subtotal = floatval($unit_price * $quantity);
				$product->decrement('total_purchase_price', $subtotal);

				$currentstock = Currentstock::where("tbl_productsId", $purchase_product->product_id)
					->where("tbl_wareHouseId", $purchase_product->warehouse_id)
					->where("deleted", 'No');
				if ($currentstock->get()) {
					$currentstock->decrement('currentStock', $quantity);
					$currentstock->increment('purchaseDelete', $quantity);
				} else {
					$currentstock_insert = new Currentstock();
					$currentstock_insert->tbl_productsId = $purchase_product->product_id;
					$currentstock_insert->tbl_wareHouseId = $purchase_product->warehouse_id;
					$currentstock_insert->currentStock = -$quantity;
					$currentstock_insert->purchaseDelete = $quantity;
					$currentstock_insert->entryBy = auth()->user()->id;
					$currentstock_insert->entryDate = date('Y-m-d H:i:s');
					$currentstock_insert->save();
				}
			}

			$purchaseId = $request->id;
			$result = SerializeProduct::where('purchase_id', $purchaseId)->update(['deleted' => 'Yes', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
			/*PaymentVoucher::where('purchase_id', '=', $request->id)->update(['deleted' => 'Yes', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
			//
			$voucher = Voucher::where('purchase_id', '=', $request->id)->first();
			$voucherId = $voucher->id;
			$voucher->update(['deleted' => 'Yes', 'status' => 'Inactive','deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
			VoucherDetails::where('tbl_acc_voucher_id', $voucherId)->update(['deleted' => 'Yes', 'status' => 'Inactive', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
            */
            
            PaymentVoucher::where('purchase_id', $purchaseId)->update(['deleted' => 'Yes', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
            ///
            $voucher = AccountsVoucher::where('purchase_id', '=', $purchaseId)->first();
            $voucherId = $voucher->id;
            $voucher->update(['deleted' => 'Yes', 'status' => 'Inactive', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
            AccountsVoucherDetails::where('tbl_acc_voucher_id', $voucherId)->update(['deleted' => 'Yes', 'status' => 'Inactive', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
            /* accounts part */
            $cashId = ChartOfAccounts::where('slug', '=', 'cash')->first();
            $cash = ChartOfAccounts::find($cashId->id);
            $cash->increment('amount', $currentPaymentInCash);
            /* accounts part end */
            
			DB::commit();
			return response()->json(['Success' => 'Purchase deleted!']);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => 'Purchase delete rollBack!']);
		}
	}


	public function createPDF($id)
	{
		 $invoice = DB::table('tbl_purchase_products')
			->join('tbl_purchases', 'tbl_purchase_products.purchase_id', '=', 'tbl_purchases.id')
			->join('tbl_crm_parties', 'tbl_purchases.supplier_id', '=', 'tbl_crm_parties.id')
			->join('tbl_inventory_products', 'tbl_purchase_products.product_id', '=', 'tbl_inventory_products.id')
			->leftjoin('users', 'tbl_purchases.created_by', '=', 'users.id')
			->where([['tbl_purchases.id', '=', $id], ['tbl_purchases.deleted', '=', 'No']])
			->select(
				'tbl_purchase_products.*',
				'users.name as entryBy',
				'tbl_purchases.date',
				'tbl_purchases.total_amount',
				'tbl_purchases.grand_total',
				'tbl_purchases.current_payment',
				'tbl_purchases.purchase_no',
				'tbl_crm_parties.contact',
				'tbl_crm_parties.name as supplier_name',
				'tbl_crm_parties.code',
				'tbl_crm_parties.address',
				'tbl_inventory_products.name',
				'tbl_inventory_products.id as productId',
				'tbl_inventory_products.code as productCode',
				'tbl_inventory_products.image',
				'tbl_inventory_products.type'
			)->get();

		$purchaseId  = $id;
		$purchases = Purchase::where('id', $purchaseId)->get();
		$pdf = PDF::loadView('admin.PurchaseManagement.purchase.purchase-report',  ['invoice' => $invoice, 'purchases' => $purchases]);
		return $pdf->stream('purchase-report-pdf.pdf', array("Attachment" => false));
	}




	//barcode
	public function addBarcode($id){
		//return $id;
		return view('admin.PurchaseManagement.purchase.barcode.barcodeIndex');
	}




}
