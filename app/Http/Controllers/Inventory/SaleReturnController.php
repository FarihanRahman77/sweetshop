<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inventory\Sale;
use App\Models\inventory\SaleReturn;
use App\Models\Setups\Currentstock;
use App\Models\Crm\Party;
use App\Models\inventory\SaleProduct;
use App\Models\inventory\Product;
use App\Models\inventory\SaleProductReturn;
use Illuminate\Support\Facades\Auth;
use App\Models\RestaurentManagement\Order;
use App\Models\RestaurentManagement\OrderDetail;
use App\Models\Accounts\PaymentVoucher;
use App\Models\inventory\TemporarySale;
use App\Models\inventory\TempSaleProduct;
use App\Models\inventory\Warehouse;
use App\Models\inventory\Due;
use App\Models\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherDetails;
use App\Models\Accounts\ChartOfAccounts;
use Illuminate\Support\Facades\DB;
use Exception;

class SaleReturnController extends Controller
{
	public function saleReturn($id)
	{

		$sale = Order::where(['deleted' => 'No', 'id' => $id])->get()->first();

		//$customer = Party::where('deleted','No')->where('status','Active')->where('party_type','Customer')->where('id',$sale->customer_id)->first();
		$customer = Party::where('deleted', 'No')->where('status', 'Active')->where('id', $sale->party_id)->first();
		// $sale['customer_name'] = $customer->name;
		$sale['party_id'] = $customer->id;

		$saleProducts = DB::table('tbl_restaurant_order_details')
			->where('order_id', $id)
			->where('deleted', 'No')
			->where('status', 'Active')
			->get();

		
		$saleProducts = DB::table('tbl_restaurant_order_details')
					->join('tbl_inventory_products', 'tbl_inventory_products.id', '=', 'tbl_restaurant_order_details.menu_id')
					->join('tbl_settings_company_settings', 'tbl_restaurant_order_details.sister_concern_id', 'tbl_settings_company_settings.id')
					->select('tbl_restaurant_order_details.*', 'tbl_inventory_products.name as productname', 'tbl_restaurant_order_details.unit_price as sale_price', 'tbl_inventory_products.id as product_id', 'tbl_settings_company_settings.name')
					->where('tbl_restaurant_order_details.order_id', $sale->id)
					->where('tbl_restaurant_order_details.deleted', 'No')
					->where('tbl_restaurant_order_details.status', 'Active')
					->get();

		$returnedQtyArray = array();
		$i = 0;
		foreach ($saleProducts as $saleProduct) {
			//  $returnedQtyArray[$i] = SaleProductReturn::select('return_qty')
			//  ->where('sale_product_id', $saleProduct->product_id)
			//  ->get()
			//  ->first();

			$returnedQtyData = DB::table('sale_product_returns')
				->join('tbl_restaurant_order_details', 'sale_product_returns.sale_product_id', '=', 'tbl_restaurant_order_details.id')
				//->join('sales', 'tbl_restaurant_order_details.sale_id', '=', 'sales.id')
				->where('sale_product_returns.product_id', $saleProduct->product_id)
				// ->where('sale_product_returns.warehouse_id',  $saleProduct->warehouse_id)
				->where('tbl_restaurant_order_details.order_id', $id)
				->where('sale_product_returns.deleted', 'No')
				->sum('sale_product_returns.return_qty');
			$returnedQtyArray[$i] = $returnedQtyData;
			$i++;
		}
		$warehouses = DB::table('tbl_settings_company_settings')->where('deleted', 'No')->where('status', 'Active')->get();
		return view('admin.inventoryManagement.sale.sale-return', ['customer' => $customer, 'sale' => $sale, 'saleProducts' => $saleProducts, 'returnedQtyArray' => $returnedQtyArray, 'warehouses' => $warehouses]);
	}

	public function saleReturnList($type)
	{
		$saleType = $type;
		$customerType = ['Walkin_Customer'];
		if ($saleType != "walkin_sale") {
			$customerType = ['Customer', 'Both'];
		}
		$customers = Party::select('id', 'name')->where('deleted', 'No')->where('status', 'Active')->whereIn('party_type', $customerType)->get();
		return view('admin.inventoryManagement.sale.sale-returnList', compact('saleType', 'customers'));
	}

	public function saveSaleReturn(Request $request)
	{


		//  return $request;
		$request->validate([

			'dateOfSaleReturn' => 'required'
		]);

		//return $request;

		DB::beginTransaction();
		try {
			//return $request->dateOfSaleReturn;
			$tbl_COA_Id = 13;

			$saleReturnNo = SaleReturn::max('sale_return_no');
			$saleReturnNo++;
			$saleReturnNo = str_pad($saleReturnNo, 6, '0', STR_PAD_LEFT);

			$saleId = $request->saleId;
			$sales = Order::find($saleId);
			$saleProductIds = $request->saleProductIds;
			$saleProductIdsArray = explode(",", $saleProductIds);
			$itemCodesArray = explode(",", $request->itemCodes);
			$QuantitiesArray = explode(",", $request->Quantities);
			$returnedQuantitiesArray = explode(",", $request->returnedQuantities);
			$returnQuantitiesArray = explode(",", $request->returnQuantities);
			$remainQuantitiesArray = explode(",", $request->remainQuantities);
			$unitPricesArray = explode(",", $request->unitPrices);
			$productIdsOfSaleArray = explode(",", $request->productIdsOfSale);
			$totalsArray = explode(",", $request->totals);
			$warehouse_id = Session::get('companySettings')[0]['id'];
			// Sale_Return
			$saleReturn = new SaleReturn();
			$saleReturn->sale_return_no = $saleReturnNo;
			$saleReturn->sale_no = $request->saleNo;
			$saleReturn->coa_id = $tbl_COA_Id;
			$saleReturn->sale_return_date = $request->dateOfSaleReturn;
			$saleReturn->sale_date = $request->saleDate;
			$saleReturn->sale_id = $saleId;
			$saleReturn->sister_concern_id = Session::get('companySettings')[0]['id'];
			$saleReturn->customer_id = $request->customerId;
			$saleReturn->grand_total = $request->grandTotal;
			$saleReturn->status = "Active";
			$saleReturn->sales_type = 'walkin_sale';
			$saleReturn->created_by = Auth::user()->id;
			$saleReturn->save();

			$saleReturnId = $saleReturn->id;
			for ($i = 0; $i < count($saleProductIdsArray); $i++) {
				if ($returnQuantitiesArray[$i] != 'NaN') {
					if ($returnQuantitiesArray[$i] <= 0) {
						continue;
					}

					$saleProduct = OrderDetail::where([['id', '=', $saleProductIdsArray[$i]], ['deleted', '=', 'No'], ['status', '=', 'Active']])->first();

					// store in sale_product_returns //
					$saleReturnProduct = new SaleProductReturn();
					$saleReturnProduct->sale_product_id = $saleProductIdsArray[$i];
					$saleReturnProduct->sale_return_id = $saleReturnId;
					$saleReturnProduct->sister_concern_id = Session::get('companySettings')[0]['id'];
					$saleReturnProduct->product_id = $saleProduct->menu_id;
					$saleReturnProduct->return_qty = $returnQuantitiesArray[$i];
					$saleReturnProduct->remaining_qty = $remainQuantitiesArray[$i];
					$saleReturnProduct->unit_price = $unitPricesArray[$i];
					$saleReturnProduct->total_price = $totalsArray[$i];
					$saleReturnProduct->created_by = Auth::user()->id;
					$saleReturnProduct->created_date = Carbon::now();
					$saleReturnProduct->deleted = "No";
					$saleReturnProduct->status = "Active";
					$saleReturnProduct->sales_type = 'walkin_sale';
					$saleReturnProduct->save();

					// update (current_stock)  in products table //
					$productId = intval($itemCodesArray[$i]);
					$quantity = intval($returnQuantitiesArray[$i]);
					$product = Product::find($productId);
					$product->increment('current_stock', $quantity);

					$Currentstock = Currentstock::where("tbl_productsId", $productId)
						->where("sister_concern_id", $warehouse_id)
						->where("deleted", 'No');
					if ($Currentstock->first()) {
						$Currentstock->increment('currentStock', $quantity);
						$Currentstock->increment('salesReturnStock', $quantity);
					} else {
						$Currentstock_insert = new Currentstock();
						$Currentstock_insert->tbl_productsId = $productId;
						$Currentstock_insert->sister_concern_id = $warehouse_id;
						$Currentstock_insert->currentStock = $quantity;
						$Currentstock_insert->salesReturnStock = $quantity;
						$Currentstock_insert->entryBy = auth()->user()->id;
						$Currentstock_insert->entryDate = date('Y-m-d H:i:s');
						$Currentstock_insert->save();
					}
				}
			}

			$party = Party::find($request->customerId);
			$current_due = $party->current_due - $request->grandTotal;
			$party->current_due = $current_due;
			$party->save();

			$dues = new Due();
			$dues->party_id = $request->customerId;
			$dues->amount = $request->grandTotal;
			$dues->current_due = $party->current_due;
			$dues->type = 'sale_return';
			$dues->sale_return_id = $saleReturnId;
			$dues->sale_id = $saleId;
			$dues->created_by = auth()->user()->id;
			$dues->deleted = "No";
			$dues->status = "Active";
			$dues->date = $request->dateOfSaleReturn;
			$dues->save();

			$PaymentVoucherNo = PaymentVoucher::max('voucherNo');
			$PaymentVoucherNo++;
			$PaymentVoucherNo = str_pad($PaymentVoucherNo, 3, '0', STR_PAD_LEFT);

			$partyId = $party->id;
			$paymentVoucher = new PaymentVoucher();
			$paymentVoucher->party_id = $partyId;
			$paymentVoucher->amount = $request->grandTotal;
			$paymentVoucher->entryBy = Auth::user()->id;
			$paymentVoucher->sister_concern_id = Session::get("companySettings")[0]["id"];
			$paymentVoucher->paymentDate = $request->dateOfSaleReturn;
			;
			$paymentVoucher->status = "Active";
			$paymentVoucher->payment_method = "Cash";
			$paymentVoucher->type = "Payable";
			$paymentVoucher->customerType = "Party";
			$paymentVoucher->voucherType = "SalesReturn";
			$paymentVoucher->sales_return_id = $saleReturnId;
			$paymentVoucher->voucherNo = $saleReturnNo;
			$paymentVoucher->remarks = "Sale return entry for return # " . $saleReturnNo;
			$paymentVoucher->remarks = "Voucher Entry for Sale Return";
			$paymentVoucher->save();
			$payment_voucher_id = $paymentVoucher->id;

			/* accounts part start */
			$voucher = new Voucher();
			$voucher->vendor_id = $partyId;
			$voucher->transaction_date = $request->dateOfSaleReturn;
			;
			$voucher->payment_voucher_id = $payment_voucher_id;
			$voucher->amount = floatval($request->grandTotal);
			$voucher->payment_method = "Cash";
			$voucher->type = "Sales Return";
			$voucher->from_tbl_id = $saleReturnId;
			$voucher->voucher_no = $saleReturnNo;
			$voucher->deleted = "No";
			$voucher->status = "Active";
			$voucher->created_by = auth()->user()->id;
			$voucher->created_date = date('Y-m-d h:s');
			$voucher->voucher_title = $sales->sales_type;
			$voucher->particulars = "Sale return entry for Return Code# " . $saleReturnNo;
			$voucher->sister_concern_id = Session::get("companySettings")[0]["id"];
			$voucher->save();
			$voucherId = $voucher->id;

			$voucherDetails = new VoucherDetails();
			$voucherDetails->tbl_acc_voucher_id = $voucherId;
			$voucherDetails->tbl_acc_coa_id = $tbl_COA_Id;
			$voucherDetails->credit = floatval($request->grandTotal);
			$voucherDetails->voucher_title = "Payable";
			$voucherDetails->particulars = "Sale return entry for Return Code# " . $saleReturnNo;
			$voucherDetails->voucher_id = $saleReturnNo;
			$voucherDetails->deleted = "No";
			$voucherDetails->status = "Active";
			$voucherDetails->created_by = auth()->user()->id;
			$voucherDetails->created_date = date('Y-m-d H:i:s');
			$voucherDetails->save();
			/* accounts part end */
			DB::commit();
			return response()->json(['success' => 'Sale returned successfully', 'type' => $sales->sales_type]);

		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => 'Sale delete rollBack ' . $e]);
		}
	}


	public function saleReturnView(Request $request, $filterByTypeDateParty)
	{

		$logged_sister_concern_id = Session::get('companySettings')[0]['id'];
		$tempFilterByTypeDatePartyArray = $filterByTypeDateParty;

		$filterByTypeDatePartyArray = explode("@", $tempFilterByTypeDatePartyArray);
		$type = $filterByTypeDatePartyArray[0]; // Sales Type
		$filterDays = $filterByTypeDatePartyArray[1]; // saleDate

		$filter = Carbon::now()->toDateString(); //=> "2020-03-09"

		if ($filterDays != "Today" && $filterDays != 'FilterByCustomers') {
			$filter = Carbon::now()->subDays($filterDays)->format('Y-m-d');
		}

		if (count($filterByTypeDatePartyArray) == 3) {
			$filterParty = $filterByTypeDatePartyArray[2]; // Party ID
			$request->request->add(['filterByParty' => $filterParty]);
		} else {
			$request->request->add(['filterByDate' => $filter]);
		}

		$output = array('data' => array());
		$i = 1;

		$saleReturns = DB::table('sale_returns')
			->join('tbl_crm_parties', 'sale_returns.customer_id', '=', 'tbl_crm_parties.id')
			->select(
				'sale_returns.sale_return_no',
				'sale_returns.sale_no',
				'sale_returns.sale_return_date',
				'sale_returns.grand_total',
				'sale_returns.discount',
				'sale_returns.id',
				'sale_returns.sale_id',
				'sale_returns.sale_date',
				'sale_returns.grand_total',
				'tbl_crm_parties.name',
				'tbl_crm_parties.code',
				'tbl_crm_parties.address',
				'tbl_crm_parties.contact',
				'tbl_crm_parties.alternate_contact'
			)
			->where('sale_returns.sister_concern_id', $logged_sister_concern_id)
			->where('sale_returns.sales_type', $type)
			->where('sale_returns.deleted', 'No')
			->where('sale_returns.sales_type', $type)
			->when($request->has('filterByDate'), function ($query) use ($request) {
				$query->where('sale_returns.sale_return_date', '>=', $request->filterByDate);
			})
			->when($request->has('filterByParty'), function ($query) use ($request) {
				$query->where('sale_returns.customer_id', $request->filterByParty);
			})
			->orderBy('sale_returns.id', 'DESC')
			->get();

		foreach ($saleReturns as $saleReturn) {
			// $button = '<button type="button" title="print sale" id="delete" class="btn btn-sm btn-success printPurchase" onclick="printPurchase('.$saleReturn->id.')" title="Print sale"><i class="fa fa-print"> </i></button> <button type="button" title="Delete" id="delete" class="btn btn-sm btn-danger btnDelete" onclick="confirmDelete('.$saleReturn->id.')" title="Delete Record"><i class="fa fa-trash"> </i></button>';
			$button = '<td style="width: 12%;">
			   <div class="btn-group">
				   <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					   <i class="fas fa-cog"></i>  <span class="caret"></span></button>
					   <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
					   <li class="action" onclick="printPurchase(' . $saleReturn->id . ')" ><a  class="btn" ><i class="fas fa-print"></i> View Details  </a></li>
					   </li>
				   </li> 
					   <li class="action"><a   class="btn"  onclick="confirmDelete(' . $saleReturn->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
					   </li>
					   </ul>
				   </div>
			   </td>';
			$output['data'][] = array(
				$i++ . '<input type="hidden" name="id" id="id" value="' . $saleReturn->id . '" />',
				'<b>Sale Date:</b>' . $saleReturn->sale_date . ' <br><b>Return Date: </b>' . $saleReturn->sale_return_date . ' <br><b>Sale No: </b>' . $saleReturn->sale_no . ' <br><b>Return No: </b>' . $saleReturn->sale_return_no,
				'<b>Party: </b>' . $saleReturn->name . '<br><b>Contact: </b>' . $saleReturn->contact . '<br><b>Alt. Contact: </b>' . $saleReturn->alternate_contact . '<br><b>Address: </b>' . $saleReturn->address,
				'<b>Grand Total : </b>' . $saleReturn->grand_total,
				$button
			);
		}
		return $output;
	}

	public function deleteSaleReturn(Request $request)
	{
		DB::beginTransaction();
		try {
			$saleReturn = SaleReturn::find($request->id);
			$saleReturn->deleted = 'Yes';
			$saleReturn->status = 'Inactive';
			$saleReturn->deleted_date = date('Y-m-d H:i:s');
			$saleReturn->created_by = Auth::user()->id;
			$saleReturn->sister_concern_id = Session::get("companySettings")[0]["id"];
			$saleReturn->save();

			$party = Party::find($saleReturn->customer_id);
			$party->current_due = ($party->current_due + $saleReturn->grand_total);
			$party->save();


			$findDue = Due::where('sale_return_id', '=', $request->id)->first();
			$dues = new Due();
			$dues->party_id = $saleReturn->customer_id;
			$dues->amount = -($findDue->amount);
			$dues->current_due = $party->current_due;
			$dues->type = 'sale_return_delete';
			$dues->sale_id = $findDue->sale_id;
			$dues->sale_return_id = $request->id;
			$dues->sale_delete_id = $request->id;
			$dues->created_by = auth()->user()->id;
			$dues->deleted = "No";
			$dues->status = "Active";
			$dues->date = date('Y-m-d h:s');
			$dues->save();

			$sale_products = SaleProductReturn::where("sale_return_id", $request->id)->get();
			foreach ($sale_products as $sale_product) {
				$saleProduct = SaleProductReturn::find($sale_product->id);
				$saleProduct->deleted = 'Yes';
				$saleProduct->status = 'Inactive';
				$saleProduct->deleted_date = date('Y-m-d H:i:s');
				$saleProduct->created_by = Auth::user()->id;
				$saleProduct->save();

				$product = Product::find($saleProduct->product_id);
				$quantity = intval($saleProduct->return_qty);
				// $unit_price = floatval($saleProduct->unit_price);
				// $product->decrement('sale_quantity', $quantity);
				// $product->decrement('current_stock', $quantity);
				// $subtotal = floatval($unit_price * $quantity);
				// $product->decrement('total_sale_price', $subtotal);

				$productId = $product->id;
				$warehouse_id = $saleProduct->sister_concern_id;
				$Currentstock = Currentstock::where("tbl_productsId", $productId)
					->where("sister_concern_id", $warehouse_id)
					->where("deleted", 'No');
				if ($Currentstock->first()) {
					$Currentstock->decrement('currentStock', $quantity);
					$Currentstock->increment('salesReturnDelete', $quantity);
				} else {
					$Currentstock_insert = new Currentstock();
					$Currentstock_insert->tbl_productsId = $productId;
					$Currentstock_insert->sister_concern_id = $warehouse_id;
					$Currentstock_insert->currentStock = -$quantity;
					$Currentstock_insert->salesReturnDelete = $quantity;
					$Currentstock_insert->entryBy = auth()->user()->id;
					$Currentstock_insert->entryDate = date('Y-m-d H:i:s');
					$Currentstock_insert->save();
				}
			}

			$payment_voucher_id = PaymentVoucher::where('sales_return_id', $request->id)->value('id');
			PaymentVoucher::where('sales_return_id', $request->id)->update(['deleted' => 'Yes', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);

			/* accounts part start */
			$voucherId = Voucher::where('payment_voucher_id', $payment_voucher_id)->value('id');
			Voucher::where('payment_voucher_id', $payment_voucher_id)->update(['deleted' => 'Yes', 'status' => 'Inactive', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
			VoucherDetails::where('tbl_acc_voucher_id', $voucherId)->update(['deleted' => 'Yes', 'status' => 'Inactive', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
			/* accounts part end */

			DB::commit();
			return response()->json(['Success' => 'Sale Return deleted!']);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => 'Sale Return delete rollBack ' . $e]);
		}
	}


	public function createPDF($id)
	{

		$invoice = DB::table('sale_returns')
			->join('sale_product_returns', 'sale_returns.id', '=', 'sale_product_returns.sale_return_id')
			->join('tbl_inventory_products', 'sale_product_returns.product_id', '=', 'tbl_inventory_products.id')
			->join('tbl_crm_parties', 'sale_returns.customer_id', '=', 'tbl_crm_parties.id')
			->join('users', 'sale_returns.created_by', '=', 'users.id')
			->where([['sale_returns.id', '=', $id], ['sale_returns.deleted', '=', 'No']])
			->selectRaw('sum(sale_product_returns.return_qty) as return_qty,tbl_inventory_products.name,tbl_inventory_products.code as productCode,tbl_crm_parties.name as customer_name,tbl_crm_parties.code,tbl_crm_parties.contact,
					            tbl_crm_parties.address,sale_returns.sale_return_date,sale_returns.sale_return_no,sale_returns.sale_no,sale_returns.sale_date,sale_returns.grand_total,sale_product_returns.unit_price, sum(sale_product_returns.total_price) as total_price,
					            sale_product_returns.sales_type, users.name as entryBy')
			->groupby(
				'tbl_inventory_products.name',
				'tbl_inventory_products.code',
				'tbl_crm_parties.name',
				'tbl_crm_parties.code',
				'tbl_crm_parties.contact',
				'tbl_crm_parties.address',
				'sale_returns.sale_return_date',
				'sale_returns.sale_return_no',
				'sale_returns.sale_date',
				'sale_returns.sale_no',
				'sale_returns.grand_total',
				'sale_product_returns.unit_price',
				'sale_product_returns.sales_type',
				'users.name'
			)
			->get();

		$userId = auth()->user()->id;
		$userName = User::where('id', $userId)->pluck('name')->first();
		session(['userName' => $userName]);

		//return view('admin.inventory.sale.return-report', ['invoice'=> $invoice]);
		$pdf = PDF::loadView('admin.inventoryManagement.sale.return-report', ['invoice' => $invoice]);
		return $pdf->stream('sale-return-report-pdf.pdf', array("Attachment" => false));
	}

	public function temporarySaleAdjustment()
	{
		//$id = 3;
		$customers = Party::where('deleted', 'No')
			->where('status', 'Active')
			->where(function ($query) {
				$query->where('party_type', 'Customer')
					->orWhere('party_type', 'Both');
			})
			->get();
		$warehouses = Warehouse::where('deleted', 'No')->get();
		return view('admin.inventoryManagement.sale.temporarySaleAdjustment', compact('customers', 'warehouses'));
	}

	public function getTemporarySale(Request $request)
	{

		$id = $request->id;
		$temporarySale = TemporarySale::where(['deleted' => 'No', 'tbl_customerId' => $request->id])->get();

		/*$saleProducts222 = DB::table('sale_products')
				  ->join('products', 'products.id', '=', 'sale_products.product_id')
				  ->select('sale_products.*', 'products.name')
				  ->where('sale_products.sale_id', $request->id)
				  ->where('sale_products.deleted', 'No')
				  ->where('sale_products.status', 'Active')
				  ->get();*/

		$temporarySaleProducts = DB::table('tbl_temporary_sale')
			->join('tbl_tsalesproducts', 'tbl_tsalesproducts.tbl_tSalesId', '=', 'tbl_temporary_sale.id')
			->join('products', 'products.id', '=', 'tbl_tsalesproducts.tbl_productsId')
			->select('tbl_tsalesproducts.*', 'products.name', 'products.code', 'products.sale_price', 'products.id as productId')
			->where('tbl_temporary_sale.tbl_customerId', $id)
			->where('tbl_temporary_sale.from_warehouse', Session::get("warehouse")[0]["id"])
			->where('tbl_tsalesproducts.deleted', 'No')
			->where('tbl_tsalesproducts.status', 'Running')
			->get();


		$temporarySaleTable = '';
		$sr = 0;
		foreach ($temporarySaleProducts as $tempSale) {
			$soldQuantity = $tempSale->soldQuantity;
			if ($soldQuantity == "") {
				$soldQuantity = '0';
			}
			$remainingQty = $tempSale->quantity - ($soldQuantity + $tempSale->returnedQuantity);
			$temporarySaleTable .= '<tr>
				<input type="hidden" id="totalQty' . $tempSale->id . '" value="' . $tempSale->quantity . '">
				<input type="hidden" id="soldQty' . $tempSale->id . '" value="' . $soldQuantity . '">
				<input type="hidden" id="returnedQty' . $tempSale->id . '" value="' . $tempSale->returnedQuantity . '">
				<th scope="row" id="">' . (++$sr) . '</th>
				<td>' . $tempSale->name . '-' . $tempSale->code . '</td>
				<td>' . $tempSale->quantity . '</td>
				<td>' . $soldQuantity . '</td>
				<td>' . $tempSale->returnedQuantity . '</td>
				<td>
					<input type="number" id="sale_' . $tempSale->id . '" oninput="sale( ' . $tempSale->id . ' )" min="0" placeholder="0" class="form-control" name="sale[]" aria-describedby="emailHelp">
				</td>
				<td>
				    <input type="text"  id="unitPrice' . $tempSale->id . '"  oninput="sale( ' . $tempSale->id . ' )" class="form-control" name="unitPrice[]" value="' . $tempSale->amount . '" />
			    </td>
				<td>
					<input type="number" id="temRetrun_' . $tempSale->id . '" oninput="temRetrun( ' . $tempSale->id . ' )" min="0" placeholder="0" class="form-control" name="temRetrun[]" aria-describedby="emailHelp">
				</td>
				<td id="remainingQty_' . $tempSale->id . '">' . $remainingQty . '</td>
				<input type="hidden" id="saleProductId' . $tempSale->id . '" value="' . $tempSale->id . '">
				<td id="total_' . $tempSale->id . '">00</td>
			  </tr>';
		}

		return $temporarySaleTable;
	}

	public function saveTSAdjustment(Request $request)
	{
		$date = $request->date;
		$customer = $request->customer;
		$warehouse = $request->warehouse;
		$totalPrice = $request->totalPrice;
		$discount = $request->discount;
		$grandTotal = $request->grandTotal;
		$paidAmount = $request->paidAmount;
		$saleQuantity = $request->saleQuantity;
		$saleQuantityArray = explode(",", $saleQuantity);
		$TSproductsId = $request->TSproductsId;
		$TSproductsIdArray = explode(",", $TSproductsId);

		$unitPrice = $request->unitPrice;
		$unitPriceArray = explode(",", $unitPrice);
		$productTotal = $request->productTotal;
		$productTotalArray = explode(",", $productTotal);
		$TSReturnproductsId = $request->TSReturnproductsId;
		$TSReturnproductsIdArray = explode(",", $TSReturnproductsId);
		$returnQutantity = $request->returnQutantity;
		$returnQutantityArray = explode(",", $returnQutantity);
		DB::beginTransaction();
		try {
			$customerInfo = Party::where('id', $customer)
				->where(function ($query) {
					$query->where('party_type', 'Customer')
						->orWhere('party_type', 'Both');
				})
				->get()->first();
			$previousDue = $customerInfo->current_due;
			$currentBalance = floatval($previousDue) + floatval($grandTotal) - floatval($paidAmount);
			$saleType = 'FS';
			//Sales Data
			if ($TSproductsIdArray[0] != '') {

				//$request['category'] = $request->category ?? 10; // For accounts
				$tbl_COA_Id = 10;


				$saleNo = Sale::where('sales_type', $saleType)->max('sale_no');
				$saleNo++;
				$saleNo = str_pad($saleNo, 6, '0', STR_PAD_LEFT);
				$sale = new Sale();
				$sale->customer_id = $customer;
				$sale->sale_no = $saleNo;
				$sale->coa_id = $tbl_COA_Id;
				$sale->date = $date;
				$sale->total_amount = floatval($totalPrice);
				$sale->discount = floatval($discount);
				$sale->carrying_cost = 0;
				$sale->grand_total = floatval($grandTotal);
				$sale->previous_due = floatval($previousDue);
				$sale->current_balance = $currentBalance;
				$sale->total_price = floatval($grandTotal);
				$sale->total_with_due = floatval($previousDue) + floatval($grandTotal);
				$sale->current_payment = floatval($paidAmount);
				$sale->dues_amount = $currentBalance;
				$sale->created_by = auth()->user()->id;
				$sale->from_warehouse = Session::get("warehouse")[0]["id"];
				$sale->created_date = Carbon::now();
				$sale->sales_type = $saleType;
				$sale->current_dues = $currentBalance;
				if (intval($request->noOfTenure) > 0) {
					$sale->emi_status = 'Yes';
				}
				$sale->save();

				$sale_id = $sale->id;
				for ($i = 0; $i < count($TSproductsIdArray); $i++) {
					$TSproductsIdEntry = $TSproductsIdArray[$i];
					$productQuantityEntry = $saleQuantityArray[$i];
					$productPriceEntry = $unitPriceArray[$i];
					$productDiscountEntry = 0;
					$productTotalEntry = $productTotalArray[$i];
					if ($TSproductsIdEntry != '') {
						$total = $productQuantityEntry * $productPriceEntry;
						if (substr($productDiscountEntry, -1) == '%') {
							$discountAmount = $total * (substr($productDiscountEntry, 0, -1) / 100);
						} else {
							$discountAmount = $productDiscountEntry;
						}

						$TSData = TempSaleProduct::find($TSproductsIdEntry);
						$product_id = $TSData->tbl_productsId;
						$warehouse_id = $warehouse;
						$product = Product::find($product_id);
						$unit_id = $product->unit_id;
						$unit_price = floatval($productPriceEntry);
						$discount_amount = floatval($productDiscountEntry);
						$quantity = $productQuantityEntry;
						$salePrice = floatval($unit_price - $discount_amount);
						$subtotal = floatval($salePrice * $quantity);
						$product->increment('total_sale_price', $subtotal);
						$lot_no = SaleProduct::where("product_id", $product_id)->max('lot_no');
						$lot_no++;
						$sale_products = new SaleProduct();
						$sale_products->sale_id = $sale_id;
						$sale_products->product_id = $product_id;
						$sale_products->warehouse_id = $warehouse_id;
						$sale_products->unit_id = $unit_id;
						$sale_products->unit_price = $unit_price;
						$sale_products->unit_discount = $discount_amount;
						$sale_products->sale_price = $salePrice;
						$sale_products->quantity = $quantity;
						$sale_products->lot_no = $lot_no;
						$sale_products->subtotal = $subtotal;
						$sale_products->tbl_tsalesProductId = $TSproductsIdEntry;
						$sale_products->created_by = auth()->user()->id;
						$sale_products->created_date = Carbon::now();
						$sale_products->save();
						$TSData->increment('soldQuantity', $quantity);
					}
				}
				if (floatval($grandTotal) > 0) {
					$party = Party::find($customer);
					$party->current_due = $currentBalance;
					$party->save();

					$dues = new Due();
					$dues->party_id = $customer;
					$dues->amount = $currentBalance;
					$dues->current_due = $party->current_due;
					$dues->type = 'sale';
					$dues->sale_id = $sale_id;
					$dues->created_by = auth()->user()->id;
					$dues->deleted = "No";
					$dues->status = "Active";
					$dues->date = date('Y-m-d h:s');
					$dues->save();

					$maxCode = PaymentVoucher::max(DB::raw('cast(voucherNo AS decimal(6))'));
					//$maxCode = PaymentVoucher::max('voucherNo');
					$maxCode++;
					$maxCode = str_pad($maxCode, 6, '000000', STR_PAD_LEFT);
					$paymentVoucher = new PaymentVoucher();
					$paymentVoucher->party_id = $customer;
					$paymentVoucher->voucherNo = $saleNo;
					$paymentVoucher->sales_id = $sale_id;
					$paymentVoucher->from_warehouse = Session::get("warehouse")[0]["id"];
					$paymentVoucher->amount = floatval($grandTotal);
					$paymentVoucher->payment_method = 'Cash';
					$paymentVoucher->paymentDate = $date;
					$paymentVoucher->type = 'Party Payable';
					$paymentVoucher->voucherType = $saleType;
					$paymentVoucher->remarks = 'Party Payable for FS code: ' . $saleNo . ' Party Payable: ' . $grandTotal;
					$paymentVoucher->entryBy = auth()->user()->id;
					$payment_voucher_id = $paymentVoucher->id;

					$paymentVoucher->save();
					if (floatval($sale->current_payment) > 0) {
						$maxCode = PaymentVoucher::max(DB::raw('cast(voucherNo AS decimal(6))'));
						$maxCode++;
						$maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);
						;
						$paymentVoucher = new PaymentVoucher();
						$paymentVoucher->party_id = $customer;
						//$paymentVoucher->voucherNo = $maxCode;
						$paymentVoucher->voucherNo = $saleNo;
						$paymentVoucher->sales_id = $sale_id;
						$paymentVoucher->from_warehouse = Session::get("warehouse")[0]["id"];
						$paymentVoucher->amount = floatval($paidAmount);
						$paymentVoucher->payment_method = 'Cash';
						$paymentVoucher->paymentDate = $date;
						$paymentVoucher->type = 'Payment Received';
						$paymentVoucher->voucherType = $saleType;
						$paymentVoucher->remarks = 'Party payment for FS code: ' . $saleNo . ' Payment Received: ' . $paidAmount;
						$paymentVoucher->entryBy = auth()->user()->id;
						$paymentVoucher->save();
					}
				}


				/* accounts part start */
				$voucher = new Voucher();
				$voucher->vendor_id = $customer;
				$voucher->payment_voucher_id = $payment_voucher_id;
				$voucher->transaction_date = $request->date;
				$voucher->sales_id = $sale_id;
				$voucher->voucher_no = $saleNo;
				$voucher->amount = floatval($grandTotal);
				$voucher->payment_method = 'Cash';
				$voucher->type = "FS";
				$voucher->from_tbl_id = $sale_id;
				$voucher->deleted = "No";
				$voucher->status = "Active";
				$voucher->created_by = auth()->user()->id;
				$voucher->created_date = date('Y-m-d h:s');
				$voucher->particulars = ' FS code: ' . $saleNo . ' Party Payable: ' . $grandTotal;
				$voucher->from_warehouse = Session::get("warehouse")[0]["id"];
				$voucher->save();
				$voucherId = $voucher->id;

				$voucherDetails = new VoucherDetails();
				$voucherDetails->tbl_acc_voucher_id = $voucherId;
				$voucherDetails->tbl_acc_coa_id = $tbl_COA_Id;
				$voucherDetails->debit = floatval($grandTotal);
				$voucherDetails->voucher_title = 'Party Payable';
				$voucherDetails->particulars = 'Party Payable for FS code: ' . $saleNo . ' Party Payable: ' . $grandTotal;
				$voucherDetails->voucher_id = $saleNo;
				$voucherDetails->deleted = "No";
				$voucherDetails->status = "Active";
				$voucherDetails->created_by = auth()->user()->id;
				$voucherDetails->created_date = date('Y-m-d H:i:s');
				$voucherDetails->save();

				if (floatval($sale->current_payment) > 0) {
					$voucherDetails = new VoucherDetails();
					$voucherDetails->tbl_acc_voucher_id = $voucherId;
					$voucherDetails->tbl_acc_coa_id = $tbl_COA_Id;
					$voucherDetails->credit = floatval($paidAmount);
					$voucherDetails->voucher_title = 'Payment Received';
					$voucherDetails->particulars = 'Party payment for FS code: ' . $saleNo . ' Payment Received: ' . $paidAmount;
					$voucherDetails->voucher_id = $saleNo;
					$voucherDetails->deleted = "No";
					$voucherDetails->status = "Active";
					$voucherDetails->created_by = auth()->user()->id;
					$voucherDetails->created_date = date('Y-m-d h:s');
					$voucherDetails->save();

					$cashCOA_Id = 11;
					$cash = ChartOfAccounts::find($cashCOA_Id);
					$cash->increment('amount', floatval($sale->current_payment));
				}
				/* accounts part end */
			}

			//Return Data
			if ($TSReturnproductsIdArray[0] != '') {

				$coa_id = 13;

				$saleType = 'TS';
				$saleReturnNo = SaleReturn::where('sales_type', $saleType)->max('sale_return_no');
				$saleReturnNo++;
				$saleReturnNo = str_pad($saleReturnNo, 6, '0', STR_PAD_LEFT);

				// store in sale_returns //
				$saleReturn = new SaleReturn();
				$saleReturn->sale_return_no = $saleReturnNo;
				$saleReturn->sale_no = '';
				$saleReturn->coa_id = $coa_id;
				$saleReturn->sale_return_date = Carbon::now();
				$saleReturn->sale_date = $date;
				//$saleReturn->sale_id = $saleId;
				$saleReturn->customer_id = $customer;
				$saleReturn->from_warehouse = Session::get("warehouse")[0]["id"];
				//$saleReturn->grand_total = $request->grandTotal;
				$saleReturn->status = "Active";
				$saleReturn->sales_type = $saleType;
				$saleReturn->created_by = Auth::user()->id;
				$saleReturn->save();

				$saleReturnId = $saleReturn->id;
				for ($i = 0; $i < count($TSReturnproductsIdArray); $i++) {

					if ($returnQutantityArray[$i] > 0) {
						$TSReturnproductsIdEntry = $TSReturnproductsIdArray[$i];
						$returnQutantityEntry = $returnQutantityArray[$i];
						$TSReturnData = TempSaleProduct::find($TSReturnproductsIdEntry);
						$product_id = $TSReturnData->tbl_productsId;
						// store in sale_product_returns //
						$saleReturnProduct = new SaleProductReturn();
						$saleReturnProduct->sale_product_id = $TSReturnproductsIdEntry;
						$saleReturnProduct->sale_return_id = $saleReturnId;
						$saleReturnProduct->warehouse_id = $warehouse;
						$saleReturnProduct->product_id = $product_id;
						$saleReturnProduct->return_qty = $returnQutantityEntry;
						$saleReturnProduct->created_by = Auth::user()->id;
						$saleReturnProduct->created_date = Carbon::now();
						$saleReturnProduct->deleted = "No";
						$saleReturnProduct->status = "Active";
						$saleReturnProduct->sales_type = $saleType;
						$saleReturnProduct->save();


						// update (current_stock)  in products table //
						$quantity = intval($returnQutantityEntry);
						$product = Product::find($product_id);
						$product->increment('current_stock', $quantity);

						$TSReturnData->increment('returnedQuantity', $quantity);
						$Currentstock = Currentstock::where("tbl_productsId", $product_id)
							->where("tbl_wareHouseId", $warehouse)
							->where("deleted", 'No');
						if ($Currentstock->first()) {
							$Currentstock->increment('currentStock', $quantity);
							$Currentstock->increment('salesReturnStock', $quantity);
						} else {
							$Currentstock_insert = new Currentstock();
							$Currentstock_insert->tbl_productsId = $product_id;
							$Currentstock_insert->tbl_wareHouseId = $warehouse;
							$Currentstock_insert->currentStock = $quantity;
							$Currentstock_insert->salesReturnStock = $quantity;
							$Currentstock_insert->entryBy = auth()->user()->id;
							$Currentstock_insert->entryDate = date('Y-m-d H:i:s');
							$Currentstock_insert->save();
						}
					}
				}
			}

			$TSZeroData = TempSaleProduct::whereRaw('quantity <= soldQuantity+returnedQuantity')->where('status', 'Running')->where('deleted', 'No')->get();
			foreach ($TSZeroData as $TSZero) {
				$tSale = TempSaleProduct::find($TSZero->id);
				$tSale->status = 'Adjusted';
				$tSale->save();
			}


			DB::commit();
			return response()->json(['Success' => 'Successfully Adjusted!']);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => 'TS Adjustment Rolled back ' . $e]);
		}
	}
}
