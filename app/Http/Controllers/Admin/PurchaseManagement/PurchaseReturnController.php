<?php

namespace App\Http\Controllers\Admin\PurchaseManagement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\setups\Category;
use App\Models\inventory\Product;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\PurchaseProduct;
use App\Models\Setups\Brand;
use App\Models\Crm\Party;
use App\Models\Setups\Unit;
use App\Models\inventory\Due;
use App\Models\Purchase\Purchase_Return;
use App\Models\Voucher\PaymentVoucher;
use App\Models\Purchase\Purchase_Product_Return;
use App\Models\Setups\Currentstock;
use App\Models\setups\Warehouse;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\Voucher\AccountsVoucher;
use App\Models\Voucher\AccountsVoucherDetails;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Exception;

class PurchaseReturnController extends Controller
{

	public function purchaseReturn($id)
	{
		$purchase = Purchase::find($id);

		$supplierName = Party::select('name')->where('deleted', 'No')->where('status', 'Active')->where('id', $purchase->supplier_id)->first();
		$purchase['supplier_name'] = $supplierName->name;


		$purchaseProducts22 = PurchaseProduct::where("purchase_id", $id)
			->where("deleted", 'No')
			->where("status", 'Active')
			->get();

		 $purchaseProducts = DB::table('tbl_purchase_products')
			->join('tbl_inventory_products', 'tbl_inventory_products.id', '=', 'tbl_purchase_products.product_id')
			->leftjoin('tbl_setups_warehouses', 'tbl_purchase_products.warehouse_id', 'tbl_setups_warehouses.id')
			->leftjoin('tbl_settings_company_settings',  'tbl_settings_company_settings.id','=','tbl_purchase_products.sister_concern_id')
			->select('tbl_purchase_products.*', 'tbl_inventory_products.name', 'tbl_setups_warehouses.name as warehousename','tbl_settings_company_settings.name as companysettingname')
			->where('tbl_purchase_products.purchase_id', $id)
			->where('tbl_purchase_products.deleted', 'No')
			->where('tbl_purchase_products.status', 'Active')
			->get();

		$returnedQtyArray = array();
		$i = 0;
		foreach ($purchaseProducts as $purchaseProduct) {
			/*$returnedQtyArray[$i] = Purchase_Product_Return::select('return_qty')
				->where('purchase_product_id', $purchaseProduct->id)
				->get()
				->first();*/

			$returnedQtyArray[$i] = DB::table('purchase_product_returns')
				->where('purchase_product_id',  $purchaseProduct->id)
				->where('deleted', 'No')
				->sum('return_qty');

			$i++;
		}
		$warehouses = Warehouse::where('deleted', 'No')->where('status', 'Active')->get();
		return view('admin.PurchaseManagement.purchase.purchase-return', ['purchase' => $purchase, 'purchaseProducts' => $purchaseProducts, 'returnedQtyArray' => $returnedQtyArray, 'warehouses' => $warehouses]);
	}





	public function storePurchaseReturn(Request $request)
		{
			// DB::beginTransaction();
			// try {
				$COA_Id = 12;
				$purchaseReturnNo = Purchase_Return::max('purchase_return_no');
				$purchaseReturnNo++;
				$purchaseReturnNo = str_pad($purchaseReturnNo, 6, '0', STR_PAD_LEFT);

				$purchaseReturn_id = 0;
				$purchaseId = $request->purchaseId;
				$purchaseProductIds = $request->purchaseProductIds;
				$purchaseProductIdsArray = explode(",", $purchaseProductIds);
				$itemCodesArray = explode(",", $request->itemCodes); 
				$QuantitiesArray = explode(",", $request->Quantities);
				$returnedQuantitiesArray = explode(",", $request->returnedQuantities);
				$returnQuantitiesArray = explode(",", $request->returnQuantities);
				$remainQuantitiesArray = explode(",", $request->remainQuantities);
				$unitPricesArray = explode(",", $request->unitPrices);
				$totalsArray = explode(",", $request->totals);
				$warehouse = $request->warehouse;
				$purchase_no = Purchase::where('id', $purchaseId)->pluck('purchase_no');
				// store  in purchase_returns //
				$purchaseReturn = new Purchase_Return();
				$purchaseReturn->purchase_return_no = $purchaseReturnNo;
				$purchaseReturn->purchase_no = $purchase_no[0];
				$purchaseReturn->coa_id = $COA_Id;
				$purchaseReturn->purchase_return_date = Carbon::now();
				$purchaseReturn->purchase_date = $request->purchaseDate;
				$purchaseReturn->purchase_id = $purchaseId;
				$purchaseReturn->supplier_id = $request->supplierId;
				$purchaseReturn->grand_total = $request->grandTotal;
				$purchaseReturn->from_warehouse = $request->warehouse;
				$purchaseReturn->sisterConcern_id  =Session::get("companySettings")[0]['id'];
				$purchaseReturn->created_by =  Auth::user()->id;
				$purchaseReturn->save();
				$purchaseReturnId = $purchaseReturn->id;

				for ($i = 0; $i < count($purchaseProductIdsArray); $i++) {

					if ($returnQuantitiesArray[$i] <= 0) {
						continue;
					}

					$purchaseProduct = PurchaseProduct::find($purchaseProductIdsArray[$i]);
					$purchaseReturnProduct = new Purchase_Product_Return();
					$purchaseReturnProduct->product_id = intval($itemCodesArray[$i]);
					$purchaseReturnProduct->purchase_product_id = intval($purchaseProductIdsArray[$i]);
					$purchaseReturnProduct->purchase_id = $purchaseId;
					$purchaseReturnProduct->warehouse_id = $warehouse;
					$purchaseReturnProduct->purchase_return_id = $purchaseReturnId;
					$purchaseReturnProduct->return_qty = $returnQuantitiesArray[$i];
					$purchaseReturnProduct->remaining_qty = $remainQuantitiesArray[$i];
					$purchaseReturnProduct->unit_price =  $unitPricesArray[$i];
					$purchaseReturnProduct->total_price = $totalsArray[$i];
					$purchaseReturnProduct->created_by = Auth::user()->id;
					$purchaseReturnProduct->created_date = Carbon::now();
					$purchaseReturnProduct->deleted = "No";
					$purchaseReturnProduct->save();


					$productId = intval($itemCodesArray[$i]);
					$quantity = intval($returnQuantitiesArray[$i]);
					$product = product::find($productId);
					$product->decrement('current_stock', $quantity);

					$Currentstock = Currentstock::where("tbl_productsId", $productId)
						->where("tbl_wareHouseId", $warehouse)
						->where("deleted", 'No');
					if ($Currentstock->get()) {
						$Currentstock->decrement('currentStock', $quantity);
						$Currentstock->increment('purchaseReturnStock', $quantity);
					} else {
						$Currentstock_insert = new Currentstock();
						$Currentstock_insert->tbl_productsId = $productId;
						$Currentstock_insert->tbl_wareHouseId = $warehouse;
						$Currentstock_insert->currentStock = -$quantity;
						$Currentstock_insert->purchaseReturnStock = $quantity;
						$Currentstock_insert->entryBy = auth()->user()->id;
						$Currentstock_insert->entryDate = date('Y-m-d H:i:s');
						$Currentstock_insert->save();
					}
				}

				

				$party = Party::find($request->supplierId);
				$current_due = $party->current_due + $purchaseReturn->grand_total;
				$party->current_due = $current_due;
				$party->save();

				$dues=new Due();
				$dues->party_id=$request->supplierId;
				$dues->amount=$current_due;
				$dues->current_due=$party->current_due;
				$dues->type='purchase_return';
				$dues->purchase_return_id=$purchaseReturnId;
				$dues->purchase_id=$purchaseId;
				$dues->created_by=auth()->user()->id;
				$dues->deleted = "No";
				$dues->status = "Active";
				$dues->date = date('Y-m-d h:s');
				$dues->save();

				$PaymentVoucherNo = PaymentVoucher::max('voucherNo');
				$PaymentVoucherNo++;
				$PaymentVoucherNo = str_pad($PaymentVoucherNo, 6, '0', STR_PAD_LEFT);

				$partyId = $party->id;
				$paymentVoucher = new PaymentVoucher();
				$paymentVoucher->party_id  = $partyId;
				$paymentVoucher->amount = $purchaseReturn->grand_total;
				$paymentVoucher->entryBy = Auth::user()->id;
				$paymentVoucher->from_warehouse  = $request->warehouse;
				$paymentVoucher->paymentDate = Carbon::now();
				$paymentVoucher->status = "Active";
				$paymentVoucher->payment_method = "Cash";
				$paymentVoucher->type = "Party Payable";
				$paymentVoucher->customerType = "Party";
				$paymentVoucher->voucherType = "PurchaseReturn";
				$paymentVoucher->remarks = "Parchase return entry for return # " . $purchaseReturnNo;
				$paymentVoucher->purchase_return_id = $purchaseReturnId;
				$paymentVoucher->voucherNo  = $purchaseReturnNo;
				$paymentVoucher->save();
				$payment_voucher_id = $paymentVoucher->id;



				/* accounts part start */
				$voucher = new AccountsVoucher();
				$voucher->vendor_id = $request->supplierId;
				$voucher->payment_voucher_id = $payment_voucher_id;
				$voucher->transaction_date =  Carbon::now()->toDateString();
				$voucher->voucher_no = $purchaseReturnNo;
				$voucher->particulars = 'Purchase Rerurn code ' . $purchaseReturnNo . ", PaymentVoucherNo " . $PaymentVoucherNo;
				$voucher->amount = floatval($request->grandTotal);
				$voucher->payment_method = "Cash";
				$voucher->type = 'Purchase Return';
				$voucher->from_tbl_id =   $purchaseReturnId;
				$voucher->deleted = "No";
				$voucher->status = "Active";
				$voucher->created_by = Auth::user()->id;
				$voucher->created_date = date('Y-m-d h:s');
				$voucher->from_warehouse = $request->warehouse;
				$voucher->sister_concern_id = Session::get("companySettings")[0]['id'];
				$voucher->save();
				$voucherId = $voucher->id;

				$voucherDetails = new AccountsVoucherDetails();
				$voucherDetails->tbl_acc_voucher_id = $voucherId;
				$voucherDetails->tbl_acc_coa_id = $COA_Id;
				$voucherDetails->debit = floatval($request->grandTotal);
				$voucherDetails->voucher_title =  "Party Payable";
				$voucherDetails->particulars = 'Purchase Return created with PurchaseReturn Code ' . $purchaseReturnNo;
				$voucherDetails->voucher_id = $purchaseReturnNo;
				$voucherDetails->deleted = "No";
				$voucherDetails->status = "Active";
				$voucherDetails->created_by = Auth::user()->id;
				$voucherDetails->created_date = date('Y-m-d H:i:s');
				$voucherDetails->save();
				/* accounts part end */

			//	DB::commit();
				return response()->json(['success' => 'Purchase returned successfully']);
			// } catch (Exception $e) {
			// 	DB::rollBack();
			// 	return response()->json(['error' => 'Purchase delete rollBack! try again'.$e]);
			// }
		}


	public function purchaseReturnList()
	{
	    $customers = Party::select('id', 'name')->where('deleted', 'No')->where('status', 'Active')->whereIn('party_type', ['Supplier', 'Both'])->get();
		return view('admin.PurchaseManagement.purchase.purchase-returnList', compact('customers'));
	}

	public function purchaseReturnView(Request $request, $filterByTypeDateParty)
	{
 
		$tempFilterByTypeDatePartyArray = $filterByTypeDateParty;

		$filterByTypeDatePartyArray = explode("@", $tempFilterByTypeDatePartyArray);
		$type = $filterByTypeDatePartyArray[0]; // Sales Type
		$filterDays = $filterByTypeDatePartyArray[1]; // saleDate

		$filter = Carbon::now()->toDateString(); //=> "2020-03-09"

		if ($filterDays != "Today" &&  $filterDays != 'FilterByCustomers') {
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

		$purchaseReturns = DB::table('purchase_returns')
			->leftjoin('parties', 'purchase_returns.supplier_id', '=', 'parties.id')
			->select(
				'purchase_returns.purchase_return_no',
				'purchase_returns.purchase_no',
				'purchase_returns.purchase_return_date',
				'purchase_returns.grand_total',
				'purchase_returns.discount',
				'purchase_returns.id',
				'purchase_returns.purchase_date',
				'purchase_returns.grand_total',
				'parties.name',
				'parties.code',
				'parties.address',
				'parties.contact',
				'parties.alternate_contact'
			)
			// ->where('purchase_returns.from_warehouse', )
			->where('purchase_returns.sisterConcern_id', Session::get("companySettings")[0]['id'])
			->where('purchase_returns.deleted', 'No')
			->when($request->has('filterByDate'), function ($query) use ($request) {
				$query->where('purchase_returns.purchase_return_date', '>=', $request->filterByDate);
			})
			->when($request->has('filterByParty'), function ($query) use ($request) {
				$query->where('purchase_returns.supplier_id', $request->filterByParty);
			})
			->orderBy('purchase_returns.id', 'DESC')
			->get();
		foreach ($purchaseReturns as $purchaseReturn) {
			// $button = '<button type="button" title="print Purchase" id="delete" class="btn btn-xs btn-success printPurchase" onclick="printPurchase('.$purchaseReturn->id.')" title="Print Purchase"><i class="fa fa-print"> </i></button> <button type="button" title="Delete" id="delete" class="btn btn-xs btn-danger btnDelete" onclick="confirmDelete('.$purchaseReturn->id.')" title="Delete Record"><i class="fa fa-trash"> </i></button>';
			$button = '<td style="width: 12%;">
			<div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<i class="fas fa-cog"></i>  <span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
					<li class="action" onclick="printPurchase(' . $purchaseReturn->id . ')"  ><a  class="btn" ><i class="fas fa-print"></i> View Details  </a></li>
					</li>
				</li> 
					<li class="action"><a   class="btn"  onclick="confirmDelete(' . $purchaseReturn->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
					</li>
					</ul>
				</div>
			</td>';
			$output['data'][] = array(
				$i++ . '<input type="hidden" name="id" id="id" value="' . $purchaseReturn->id . '" />',
				'<b>Return Date:</b>' . $purchaseReturn->purchase_return_date . ' <br><b>Purchase Date: </b>' . $purchaseReturn->purchase_date . ' <br><b>Return No:</b>#' . $purchaseReturn->purchase_return_no . ' <br><b>Purchase No:</b>#' . $purchaseReturn->purchase_no,
				'<b>Party: </b>' . $purchaseReturn->name . '<br><b>Contact: </b>' . $purchaseReturn->contact . '<br><b>Alt. Contact: </b>' . $purchaseReturn->alternate_contact . '<br><b>Address: </b>' . $purchaseReturn->address,
				'<br><b>Total : </b>' . $purchaseReturn->grand_total,
				$button
			);
		}
		return $output;
	}

public function deletePurchaseReturn(Request $request)
	{
		DB::beginTransaction();
		try {
			$purchase = Purchase_Return::find($request->id);
			$purchase->deleted = 'Yes';
			$purchase->deleted_date = Carbon::now();
			$purchase->deleted_by = Auth::user()->id;
			$purchase->save();

			$party = Party::find($purchase->supplier_id);
			$party->current_due = ($party->current_due + $purchase->current_payment - $purchase->grand_total);
			$party->save();

			$findDue=Due::where('purchase_return_id','=',$request->id)->first();
			$dues=new Due();
			$dues->party_id=$purchase->supplier_id;
			$dues->amount=-($findDue->amount);
			$dues->current_due=$party->current_due;
			$dues->type='purchase_return_delete';
			$dues->purchase_id=$findDue->purchase_id;
			$dues->purchase_return_id=$request->id;
			$dues->purchase_delete_id=$request->id;
			$dues->created_by=auth()->user()->id;
			$dues->deleted = "No";
			$dues->status = "Active";
			$dues->date = date('Y-m-d h:s');
			$dues->save();

			$purchase_products = Purchase_Product_Return::where("purchase_return_id", $request->id)->get();
			foreach ($purchase_products as $purchase_product) {
				$purchaseProduct = Purchase_Product_Return::find($purchase_product->id);
				$purchaseProduct->deleted = 'Yes';
				$purchaseProduct->deleted_date = Carbon::now();
				$purchaseProduct->deleted_by = Auth::user()->id;
				$purchaseProduct->save();

				$product = product::find($purchase_product->product_id);
				$quantity = intval($purchaseProduct->return_qty);
				$unit_price = floatval($purchaseProduct->unit_price);
				$product->increment('purchase_quantity', $quantity);
				$product->increment('current_stock', $quantity);
				$subtotal = floatval($unit_price * $quantity);
				$product->increment('total_purchase_price', $subtotal);

				$Currentstock = Currentstock::where("tbl_productsId", $product->id)
					->where("tbl_wareHouseId", $purchaseProduct->warehouse_id)
					->where("deleted", 'No');
				if ($Currentstock->get()) {
					$Currentstock->increment('currentStock', $quantity);
					$Currentstock->increment('purchaseReturnDelete', $quantity);
				} else {
					$Currentstock_insert = new Currentstock();
					$Currentstock_insert->tbl_productsId = $product->id;
					$Currentstock_insert->tbl_wareHouseId = $purchaseProduct->warehouse_id;
					$Currentstock_insert->currentStock = $quantity;
					$Currentstock_insert->purchaseReturnDelete = $quantity;
					$Currentstock_insert->entryBy = auth()->user()->id;
					$Currentstock_insert->entryDate = date('Y-m-d H:i:s');
					$Currentstock_insert->save();
				}
			}

			$payment_voucher_id = PaymentVoucher::where('purchase_return_id', $request->id)->value('id');
			PaymentVoucher::where('purchase_return_id', $request->id)->update(['deleted' => 'Yes', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);

			/* accounts part start */
			$voucherId = AccountsVoucher::where('payment_voucher_id', $payment_voucher_id)->value('id');
			AccountsVoucher::where('payment_voucher_id',  $payment_voucher_id)->update(['deleted' => 'Yes', 'status' => 'Inactive', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
			AccountsVoucherDetails::where('tbl_acc_voucher_id', $voucherId)->update(['deleted' => 'Yes', 'status' => 'Inactive', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
			/* accounts part end */

			DB::commit();
			return response()->json(['Success' => 'Purchase Return deleted!' . $product]);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => 'Purchase Return delete rollBack ' . $e]);
		}
	}



	public function createPDF($id)
	{

		$invoice = DB::table('purchase_returns')
			->join('purchase_product_returns', 'purchase_returns.id', '=', 'purchase_product_returns.purchase_return_id')
			->join('products', 'purchase_product_returns.product_id', '=', 'products.id')
			->join('parties', 'purchase_returns.supplier_id', '=', 'parties.id')
			->join('users', 'purchase_returns.created_by', '=', 'users.id')
			->where([['purchase_returns.id', '=', $id], ['purchase_returns.deleted', '=', 'No']])
			->select(
				'purchase_returns.*',
				'purchase_product_returns.return_qty',
				'products.name',
				'products.code as productCode',
				'parties.name as supplier_name',
				'parties.code',
				'parties.contact',
				'parties.address',
				'purchase_product_returns.remaining_qty',
				'purchase_returns.purchase_return_date',
				'purchase_returns.purchase_return_no',
				'purchase_product_returns.unit_price',
				'purchase_product_returns.total_price',
				'users.name as entryBy'
			)
			->get();

		$userId  = auth()->user()->id;
		$userName = User::where('id', $userId)->pluck('name')->first();
		session(['userName' => $userName]);
		$pdf = PDF::loadView('admin.inventory.purchase.purchase-return-report', compact('invoice'));
		return $pdf->stream('purchase-return-report-pdf_file.pdf', array("Attachment" => false));
	}
}
