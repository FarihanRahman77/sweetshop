<?php

namespace App\Http\Controllers\Admin\VoucherManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Crm\Party;
use App\Models\hotelManagement\Building;
use App\Models\User;
use App\Models\Voucher\PaymentVoucher;
use App\Models\inventory\Project;
use App\Models\inventory\Purchase;
use App\Models\inventory\WorkOrder;
use App\Models\Voucher\AccountsVoucher;
use App\Models\Voucher\AccountsVoucherDetails;
use App\Models\Accounts\AccountConfiguration;
use App\Models\Accounts\ChartOfAccounts;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\inventory\Sale;
use App\Models\inventory\Emi_sale;
use App\Models\Setups\Warehouse;
use App\Models\hotelManagement\Booking;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

use function PHPSTORM_META\type;

class VoucherController extends Controller
{

	public function index($type)
	{

		$data['type']  = ucfirst($type);
		
		$logged_sister_concern_id = Session::get('companySettings')[0]['id'];

        if (Session::get('companySettings')[0]['is_admin'] == 'Yes') {
            $data['buildings'] = Building::where('deleted', 'No')->where('status', '=', 'Active')->get();
        } elseif (Session::get('companySettings')[0]['is_admin'] == 'No') {
            $data['buildings'] = Building::join('tbl_setups_sister_concern_to_warehouses', 'tbl_setups_sister_concern_to_warehouses.building_id', '=', 'tbl_building.id')
                ->select('tbl_building.*', 'tbl_setups_sister_concern_to_warehouses.sister_concern_id', 'tbl_setups_sister_concern_to_warehouses.building_id')
                ->where('tbl_setups_sister_concern_to_warehouses.deleted', 'No')
                ->where('tbl_setups_sister_concern_to_warehouses.status', '=', 'Active')
                ->where('tbl_building.deleted', 'No')
                ->where('tbl_building.status', '=', 'Active')
                ->where('tbl_setups_sister_concern_to_warehouses.sister_concern_id', '=', $logged_sister_concern_id)
                ->get();
        }
		$data['parties'] = Party::where('deleted', '=', 'No')/* ->where('party_type','Customer') */->get();
		$data['suppliers']  = Party::where('deleted', '=', 'No')/* ->where('party_type','Supplier') */->get();

		return view('admin.voucherManagement.voucher.view-voucher', $data);
	}

	public function getVoucher(Request $request, $filterByTypeDateParty)
	{                  
		
		$filterParty=0;
		$filter='';
		 $tempFilterByTypeDatePartyArray = $filterByTypeDateParty;
		$filterByTypeDatePartyArray = explode("@", $tempFilterByTypeDatePartyArray);
		$type = $filterByTypeDatePartyArray[0]; 
		$filterDays = $filterByTypeDatePartyArray[1]; 
    
		 $filter = Carbon::now()->toDateString(); 

		if ($filterDays != "Today" &&  $filterDays != 'FilterByCustomers') {
			$filter = Carbon::now()->subDays($filterDays)->format('Y-m-d');
		}
		
		if (count($filterByTypeDatePartyArray) == 3) {
			 $filterParty = $filterByTypeDatePartyArray[2]; 
			 $filter='';
		}else{
			$filterParty='';
			$filter = Carbon::now()->toDateString(); //=> "2020-03-09"

			if ($filterDays != "Today" &&  $filterDays != 'FilterByCustomers') {
				$filter = Carbon::now()->subDays($filterDays)->format('Y-m-d');
			}
		}
	 	$type = ucfirst($type);
    
		
    // Fetch payment vouchers based on type
    if ($type == "Payment") {
        $PaymentVouchers = DB::table('tbl_voucher_payment_vouchers')
            ->leftJoin('tbl_crm_parties', 'tbl_voucher_payment_vouchers.party_id', '=', 'tbl_crm_parties.id')
            ->leftJoin('tbl_purchases', 'tbl_voucher_payment_vouchers.purchase_id', '=', 'tbl_purchases.id')
            ->whereRaw("(tbl_voucher_payment_vouchers.type=? or tbl_voucher_payment_vouchers.type='Payable') and (tbl_voucher_payment_vouchers.deleted='No')", [$type])
            ->select(
                'tbl_voucher_payment_vouchers.id', 
				'tbl_voucher_payment_vouchers.order_sale_id',
                'tbl_voucher_payment_vouchers.purchase_id', 
				'tbl_voucher_payment_vouchers.sales_id',
                'tbl_voucher_payment_vouchers.type', 
				'tbl_voucher_payment_vouchers.amount',
                'tbl_voucher_payment_vouchers.payment_method', 
				'tbl_voucher_payment_vouchers.paymentDate',
                'tbl_voucher_payment_vouchers.voucherNo', 
				'tbl_crm_parties.name',
                'tbl_crm_parties.code', 
				'tbl_crm_parties.contact', 
				'tbl_crm_parties.alternate_contact',
                'tbl_voucher_payment_vouchers.remarks', 
				'tbl_purchases.purchase_no as invoiceNo', 
                'tbl_purchases.date', 
				'tbl_purchases.grand_total',
				'tbl_voucher_payment_vouchers.party_id'
            )
            ->whereNull('expense_id')
            ->where('tbl_voucher_payment_vouchers.deleted', 'No')
			->when(!empty($filter), function ($query) use ($filter) {
				$query->where('tbl_voucher_payment_vouchers.paymentDate', '>=', $filter);
			})
			// Use $filterParty variable instead of $request->filterByParty
			->when(!empty($filterParty), function ($query) use ($filterParty) {
				$query->where('tbl_voucher_payment_vouchers.party_id', $filterParty);
			})
            ->orderby('tbl_voucher_payment_vouchers.id', 'DESC')
            ->get();
        $voucherType = 'Purchase';
        $amountStatus = 'Payment';
    } 
	else if ($type == "Payment Received") {
        $PaymentVouchers = DB::table('tbl_voucher_payment_vouchers')
            ->join('tbl_crm_parties', 'tbl_voucher_payment_vouchers.party_id', '=', 'tbl_crm_parties.id')
            ->leftJoin('tbl_inventory_sale', 'tbl_voucher_payment_vouchers.sales_id', '=', 'tbl_inventory_sale.id')
            ->whereRaw("(tbl_voucher_payment_vouchers.type=? or tbl_voucher_payment_vouchers.type='Party Payable') and (tbl_voucher_payment_vouchers.deleted='No')", [$type])
            ->select(
                'tbl_voucher_payment_vouchers.id', 'tbl_voucher_payment_vouchers.order_sale_id',
                'tbl_voucher_payment_vouchers.purchase_id', 'tbl_voucher_payment_vouchers.sales_id',
                'tbl_voucher_payment_vouchers.type', 'tbl_voucher_payment_vouchers.amount',
                'tbl_voucher_payment_vouchers.payment_method', 'tbl_voucher_payment_vouchers.paymentDate',
                'tbl_voucher_payment_vouchers.voucherNo', 'tbl_crm_parties.name',
                'tbl_crm_parties.code', 'tbl_crm_parties.contact', 'tbl_crm_parties.alternate_contact',
                'tbl_voucher_payment_vouchers.remarks', 'tbl_inventory_sale.sale_no as invoiceNo',
                'tbl_inventory_sale.date', 'tbl_inventory_sale.grand_total'
            )
			->where('tbl_voucher_payment_vouchers.deleted', 'No')
			->when(!empty($filter), function ($query) use ($filter) {
				$query->where('tbl_voucher_payment_vouchers.paymentDate', '>=', $filter);
			})
			// Use $filterParty variable instead of $request->filterByParty
			->when(!empty($filterParty), function ($query) use ($filterParty) {
				$query->where('tbl_voucher_payment_vouchers.party_id', $filterParty);
			})
            ->orderby('tbl_voucher_payment_vouchers.id', 'DESC')
            ->get();
         $voucherType = $type;
        $amountStatus = 'Received';
    }
	 else if ($type == "Discount") {
        $PaymentVouchers = DB::table('tbl_voucher_payment_vouchers')
            ->join('tbl_crm_parties', 'tbl_voucher_payment_vouchers.party_id', '=', 'tbl_crm_parties.id')
            ->leftJoin('tbl_inventory_sale', 'tbl_voucher_payment_vouchers.sales_id', '=', 'tbl_inventory_sale.id')
            ->whereRaw("(tbl_voucher_payment_vouchers.type='Discount' and tbl_voucher_payment_vouchers.deleted='No')")
            ->select(
                'tbl_voucher_payment_vouchers.id', 'tbl_voucher_payment_vouchers.order_sale_id',
                'tbl_voucher_payment_vouchers.purchase_id', 'tbl_voucher_payment_vouchers.sales_id',
                'tbl_voucher_payment_vouchers.type', 'tbl_voucher_payment_vouchers.amount',
                'tbl_voucher_payment_vouchers.payment_method', 'tbl_voucher_payment_vouchers.paymentDate',
                'tbl_voucher_payment_vouchers.voucherNo', 'tbl_crm_parties.name',
                'tbl_crm_parties.code', 'tbl_crm_parties.contact', 'tbl_crm_parties.alternate_contact',
                'tbl_voucher_payment_vouchers.remarks', 'tbl_inventory_sale.sale_no as invoiceNo',
                'tbl_inventory_sale.date', 'tbl_inventory_sale.grand_total'
            )
            ->orderby('tbl_voucher_payment_vouchers.id', 'DESC')
            ->where('tbl_voucher_payment_vouchers.deleted', 'No')
            ->when(!empty($filter), function ($query) use ($filter) {
				$query->where('tbl_voucher_payment_vouchers.paymentDate', '>=', $filter);
			})
            ->when(!empty($filterParty), function ($query) use ($filterParty) {
                $query->where('tbl_voucher_payment_vouchers.party_id', $filterParty);
            })
            ->get();
        $voucherType = $type;
        $amountStatus = 'Discount';
    }

    $output = array('data' => array());
    $i = 1;
    foreach ($PaymentVouchers as $voucher) {
        // The button handling logic remains the same
        $button = ''; // default button
        if ($voucher->type == 'Discount') {
            // Add specific actions for Discount
            $button = '...';  // Button HTML for Discount
        }
		$button = '<td style="width: 12%;">
			<div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<i class="fas fa-cog"></i>  <span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
						<li class="action" onclick="printPaymentReceivedVoucher(' . $voucher->id . ')"  ><a  class="btn" ><i class="fas fa-print"></i> View Details </a></li>
						</li> 
				</li>
					
				
					</ul>
				</div>
			</td>';
        // Add remaining logic for other buttons here...
        // return $type;
        $output['data'][] = array(
            $i++ . '<input type="hidden" name="id" id="id" value="' . $voucher->id . '" />',
            $voucher->paymentDate,
            $voucher->voucherNo,
            '<b>Party: </b>' . $voucher->name . '<br><b>Contact: </b>' . $voucher->contact . '<br><b>Alt. Contact: </b>' . $voucher->alternate_contact,
            '<b>Invoice: </b>' . $voucherType . '-' . $voucher->invoiceNo . '<br><b>' . $amountStatus . ': </b> ' . $voucher->amount,
            $voucher->payment_method,
            $voucher->remarks,
            $button
        );
    }
    return $output;
}


	public function loadWorkOrder(Request $request)
	{
		$getorders = WorkOrder::where('project_id', '=', $request->project_id)->where('deleted', '=', 'No')->get();
		$data = "<option value='0' selected>Select Work Order</option>";
		foreach ($getorders as $getorder) {
			$data .= "<option value='" . $getorder->id . "'>" . $getorder->order_no . "</option>";
		}
		return $data;
	}



	public function loadParties(Request $request)
	{
		$data ='';
		//return $request->type;
		if ($request->type == "Payment") {
			$getparties = DB::table('tbl_purchases')
				->join('parties', 'tbl_purchases.supplier_id', '=', 'parties.id')
				->select('parties.*', 'tbl_purchases.work_order_id')
				->where('tbl_purchases.work_order_id', '=', $request->work_order_id)
				->where('parties.deleted', '=', 'No')
				->get();
			$data .= "<option value='0' selected>Select Party</option>";
			foreach ($getparties as $getparty) {
				$data .= "<option value='" . $getparty->id . "'>" . $getparty->name . "</option>";
			}
		} else {
			$getparties = DB::table('work_orders')
				->join('parties', 'work_orders.party_id', '=', 'parties.id')
				->select('parties.*', 'work_orders.id', 'work_orders.party_id')
				->where('work_orders.id', '=', $request->work_order_id)
				->where('parties.deleted', '=', 'No')
				->get();
			$data = "<option value='0' selected>Select Party</option>";
			foreach ($getparties as $getparty) {
				$data .= "<option value='" . $getparty->party_id . "'>" . $getparty->name . "</option>";
			}
		}
		return $data;
	}

	public function loadPartyDue(Request $request)
	{
		/*$getDue=WorkOrder::find($request->work_order_id);
		if($getDue->due == null){
			return $getDue->amount;
		}else{
			return $getDue->due;
		}*/
		$paymentVouchers = DB::table('tbl_voucher_payment_vouchers')
			//->join('parties','tbl_voucher_payment_vouchers.party_id','=','parties.id')
			//->leftjoin('','.id','=','tbl_voucher_payment_vouchers.project_id')
			//->leftjoin(',.id','=','tbl_voucher_payment_vouchers.work_order_id')
			//->leftjoin('users', 'tbl_voucher_payment_vouchers.entryBy', '=', 'users.id')
			/*->select('tbl_voucher_payment_vouchers.id','tbl_voucher_payment_vouchers.purchase_id','tbl_voucher_payment_vouchers.sales_id','tbl_voucher_payment_vouchers.type','tbl_voucher_payment_vouchers.amount','tbl_voucher_payment_vouchers.payment_method',
        				            'tbl_voucher_payment_vouchers.paymentDate','tbl_voucher_payment_vouchers.voucherNo','users.name as entryBy','tbl_voucher_payment_vouchers.remarks','parties.name','parties.code','parties.contact',
        				            'parties.alternate_contact','parties.address','tbl_voucher_payment_vouchers.remarks','.project_name',.order_no')
    						->orderby('tbl_voucher_payment_vouchers.id','DESC')*/
			->select('tbl_voucher_payment_vouchers.amount', 'tbl_voucher_payment_vouchers.type')
			->where('tbl_voucher_payment_vouchers.work_order_id', $request->work_order_id)
			->where('tbl_voucher_payment_vouchers.deleted', 'No')
			->get();
		$due = 0;
		foreach ($paymentVouchers as $paymentVoucher) {
			if ($paymentVoucher->type == "Party Payable") {
				$due += floatval($paymentVoucher->amount);
			} else if ($paymentVoucher->type == "Payment Received") {
				$due -= floatval($paymentVoucher->amount);
			} else if ($paymentVoucher->type == "Discount") {
				$due -= floatval($paymentVoucher->amount);
			}
		}
		return $due;
	}


    public function getBuildingWiseRoom(Request $request){
		$rooom = Warehouse::where('tbl_building_Id', '=', $request->building)->where('deleted', '=', 'No')->get();
		return $rooom;
	}

	public function getGetPartyWiseBill(Request $request){
		// return $request;
		$restaurentbill = [];
		$hotelbill = [];
		if (Session::get('companySettings')[0]['is_hotel'] == 'Yes'){
			$hotelbill = PaymentVoucher::join('tbl_booking', 'tbl_voucher_payment_vouchers.tbl_booking_id', '=', 'tbl_booking.id')
			->select('tbl_booking.booking_date','tbl_booking.id as booking_id','tbl_booking.code')
			->where('tbl_voucher_payment_vouchers.party_id', '=', $request->party)
			->where('tbl_voucher_payment_vouchers.type', 'Party Payable')
			->where('tbl_booking.deleted', 'No')
			->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
			->get();
		}

		 if (Session::get('companySettings')[0]['is_restaurent'] == 'Yes'){
			 $restaurentbill = PaymentVoucher::join('tbl_restaurant_order', 'tbl_voucher_payment_vouchers.resturant_order_id', '=', 'tbl_restaurant_order.id')
			->select('tbl_restaurant_order.order_date','tbl_restaurant_order.id as order_id')
			->where('tbl_voucher_payment_vouchers.party_id', '=', $request->party)
			->where('tbl_voucher_payment_vouchers.type', 'Party Payable')
			->where('tbl_restaurant_order.deleted', 'No')
			->where('tbl_voucher_payment_vouchers.deleted', '=', 'No')
			->get();
		}

		$data = array(
			'hotelbill'=>$hotelbill,
			'restaurentbill'=>$restaurentbill
		);

		return $data;
	}

	public function store(Request $request)
	{
		
		$request->validate([
			'amount' => 'required|max:13|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
			'type' => 'required',
			'paymentDate' => 'required',
			'remarks' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
			'party_id' => 'required',
			'payment_method' => 'required'
		]);

		//return $request;
		DB::beginTransaction();
		try {
			$request->type = ucfirst($request->type);
			$maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
			$maxCode++;
			$maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);
			$PaymentVoucher = new PaymentVoucher();
			$PaymentVoucher->party_id = $request->party_id;
			// if($request->type == 'Payment'){
			// 	$PaymentVoucher->tbl_booking_id = 0;
			// }
			// else{
			// 	$PaymentVoucher->tbl_booking_id = $request->booking ;
			// }
			// $PaymentVoucher->tbl_building_id = $request->building;
			// $PaymentVoucher->tbl_room_id = $request->room;
			// if($request->order > 0){
			// 	$orderId=$request->order;
			// }else{
			// 	$orderId= 0;
			// }
			//$PaymentVoucher->resturant_order_id = $orderId;
			$PaymentVoucher->voucherNo = $maxCode;
			$PaymentVoucher->amount = $request->amount;
			$PaymentVoucher->entryBy = auth()->user()->id;
			$PaymentVoucher->payment_method = $request->payment_method;
			$PaymentVoucher->paymentDate = $request->paymentDate;
			$PaymentVoucher->type = $request->type;
			if ($request->remarks == '') {
				$PaymentVoucher->remarks = "Voucher Entry for " . $request->type . ' [' . $maxCode . ']';
			} else {
				$PaymentVoucher->remarks = $request->remarks;
			}
			$PaymentVoucher->save();


			$lastInsertedId = $PaymentVoucher->id;

			$party = Party::find($request->party_id);
			 if ($request->type == 'Payment Received') {
				$party->decrement('current_due', $request->amount);
			} 
			else if ($request->type == 'Payment') {
				$party->increment('current_due', $request->amount);
			}
			else if ($request->type == 'Discount') {
				if ($party->party_type == "Customer") {
					$party->decrement('current_due', $request->amount);
				} 
				else if ($party->party_type == "Supplier" || $party->party_type == "Both") {
					$party->increment('current_due', $request->amount);
				} elseif ($party->party_type == 'Walkin_Customer') {
					$party->decrement('current_due', $request->amount);
				}
			}

			$configId = 8; 
			$amount = floatval($request->amount);
			if ($request->type == 'Payment Received') {
				ChartOfAccounts::find($configId)->increment('amount', $amount);
			}
			if ($request->type == 'Payment') {
				ChartOfAccounts::find($configId)->decrement('amount', $amount);
			}

			/* $party = Party::find($request->party_id);
			if ($request->type == 'Payment Received') {
				$party->decrement('current_due', $request->amount);
				$configId = ChartOfAccounts::where('name', '=', 'Accrued Income')->first();
			} else if ($request->type == 'Payment') {
				$party->increment('current_due', $request->amount);
				$configId = ChartOfAccounts::where('name', '=', 'Accrued Expense')->first();
			} else if ($request->type == 'Discount') {
				if ($party->party_type == "Customer") {
					$party->decrement('current_due', $request->amount);
					$configId = ChartOfAccounts::where('slug', '=', 'discount-received')->first();
				} else if ($party->party_type == "Supplier") {
					$party->increment('current_due', $request->amount);
					$configId = ChartOfAccounts::where('slug', '=', 'discount-allow')->first();
				} elseif ($party->party_type == 'Walkin_Customer') {
					$party->decrement('current_due', $request->amount);
					$configId = ChartOfAccounts::where('slug', '=', 'discount-received')->first();
				}
			} */

			$voucher = new AccountsVoucher();
			$voucher->vendor_id = $request->party_id;
			$voucher->transaction_date = $request->paymentDate;
			$voucher->amount = floatval($request->amount);
			$voucher->payment_method = $request->payment_method;
			$voucher->particulars = $request->remarks;
			$voucher->deleted = "No";
			$voucher->status = "Active";
			$voucher->created_by = Auth::user()->id;
			$voucher->created_date = date('Y-m-d h:s');
			$voucher->save();
			$voucherId = $voucher->id;

			$voucherDetails = new AccountsVoucherDetails();
			$voucherDetails->tbl_acc_voucher_id = $voucherId;
			$voucherDetails->tbl_acc_coa_id = $configId;
			$voucherDetails->transaction_date = $request->paymentDate;
			//$voucherDetails->payment_voucher_id = $PaymentVoucher->id;

			if ($request->type == 'Payment Received') {
				$voucherDetails->debit = floatval($request->amount);
				$voucherDetails->voucher_title = 'Payment received with voucher Code ' . $maxCode;
			} elseif ($request->type == 'Payment') {
				$voucherDetails->credit = floatval($request->amount);
				$voucherDetails->voucher_title = 'Pyment paid with voucher Code ' . $maxCode;
			} elseif ($request->type == 'Discount') {
				if ($party->party_type == "Customer") {
					$voucherDetails->debit = floatval($request->amount);
					$voucherDetails->voucher_title = 'Customer discount with voucher  code ' . $maxCode;
				} else if ($party->party_type == "Walkin_Customer") {
					$voucherDetails->debit = floatval($request->amount);
					$voucherDetails->voucher_title = 'Walkin Customer discount with voucher code ' . $maxCode;
				} else if ($party->party_type == "Supplier" || $party->party_type == "Both") {
					$voucherDetails->credit = floatval($request->amount);
					$voucherDetails->voucher_title = 'Supplier discount with voucher code ' . $maxCode;
				}
			}
			$voucherDetails->particulars = $request->remarks;
			$voucherDetails->deleted = "No";
			$voucherDetails->status = "Active";
			$voucherDetails->created_by = Auth::user()->id;
			$voucherDetails->created_date = date('Y-m-d h:s');
			$voucherDetails->save();
		
			DB::commit();
			return response()->json(['success' => $request->type . ' Voucher saved successfully','lastInsertedId'=>$lastInsertedId]);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['success' => $e->getMessage()]);
		}
	}



	public function voucherDelete(Request $request)
	{

		$PaymentVoucher = PaymentVoucher::find($request->id);
		$PaymentVoucher->deleted = 'Yes';
		$PaymentVoucher->status = 'Inactive';
		$PaymentVoucher->deleted_date = Carbon::now();
		$PaymentVoucher->deleted_by = auth()->user()->id;
		$PaymentVoucher->save();

		$vouchers = AccountsVoucher::where('payment_voucher_id', '=', $request->id)->first();
		$vouchers->deleted = 'Yes';
		$vouchers->status = 'Inactive';
		$vouchers->deleted_date = Carbon::now();
		$vouchers->deleted_by = auth()->user()->id;
		$vouchers->save();

		$voucherDetails = AccountsVoucherDetails::where('payment_voucher_id', '=', $request->id)->first();
		$voucherDetails->deleted = 'Yes';
		$voucherDetails->status = 'Inactive';
		$voucherDetails->deleted_date = Carbon::now();
		$voucherDetails->deleted_by = auth()->user()->id;
		$voucherDetails->save();

		if ($PaymentVoucher->type == 'Payment Received') {
			$party = Party::find($PaymentVoucher->party_id);
			$party->increment('current_due', $PaymentVoucher->amount);
		} else if ($PaymentVoucher->type == 'Payment') {
			$party = Party::find($PaymentVoucher->party_id);
			$party->decrement('current_due', $PaymentVoucher->amount);
		}
	}



	public function createPDF($id)
	{

		$paymentVouchers = DB::table('tbl_voucher_payment_vouchers')
			->join('tbl_crm_parties', 'tbl_voucher_payment_vouchers.party_id', '=', 'tbl_crm_parties.id')
			->leftjoin('users', 'tbl_voucher_payment_vouchers.entryBy', '=', 'users.id')
			->select(
				'tbl_voucher_payment_vouchers.id',
				'tbl_voucher_payment_vouchers.purchase_id',
				'tbl_voucher_payment_vouchers.sales_id',
				'tbl_voucher_payment_vouchers.type',
				'tbl_voucher_payment_vouchers.amount',
				'tbl_voucher_payment_vouchers.payment_method',
				'tbl_voucher_payment_vouchers.paymentDate',
				'tbl_voucher_payment_vouchers.voucherNo',
				'users.name as entryBy',
				'tbl_voucher_payment_vouchers.remarks',
				'tbl_crm_parties.name',
				'tbl_crm_parties.code',
				'tbl_crm_parties.contact',
				'tbl_crm_parties.alternate_contact',
				'tbl_crm_parties.address',
				'tbl_voucher_payment_vouchers.remarks'

			)
			->orderby('tbl_voucher_payment_vouchers.id', 'DESC')
			->where('tbl_voucher_payment_vouchers.id', '=', $id)
			->get();

		//dd($paymentVouchers);
		/* $purchaseId  = $id;
					$tbl_purchases = DB::table('tbl_purchases')
					->where('id', $purchaseId)
					->get();

					$userId  = auth()->user()->id;
					$userName = User::where('id', $userId)->pluck('name')->first();

		session(['userName' => $userName]); */

		//return view('admin.inventory.voucher.paymentReceivedVoucher', ['paymentVouchers'=> $paymentVouchers]);

		$pdf = PDF::loadView('admin.voucherManagement.voucher.paymentReceivedVoucher', ['paymentVouchers' => $paymentVouchers]);
		return $pdf->stream('payment-received-pdf.pdf', array("Attachment" => false));
	}

	public function getSupplierDue(Request $request)
	{
		$due = Party::find($request->partyId);
		return $due;
	}
}
