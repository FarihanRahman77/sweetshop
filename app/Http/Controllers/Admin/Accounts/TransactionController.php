<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\Accounts\Transactions;
use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherDetails;
use App\Models\inventory\PaymentVoucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{



    public function index(){
        $loggedWarehouseId=Session::get('warehouse')[0]['id'];
        $config=DB::table('tbl_acc_coas')
            ->where('tbl_acc_coas.slug','=','cash-bank')
            ->where('tbl_acc_coas.deleted','=','No')
            ->where('tbl_acc_coas.status','=','Active')
            ->where('tbl_acc_coas.warehouse_id','like',"%$loggedWarehouseId%")
            ->first();
        $configId=$config->id;
        
        $banks=ChartOfAccounts::where('parent_id','=',$configId)->where('warehouse_id','like',"%$loggedWarehouseId%")->where('deleted','=','No')->where('status','=','Active')->get();
        return view('admin.banks.transactions.transactionView',['banks'=>$banks]);
    }





    public function geData(){
        $loggedWarehouseId=Session::get('warehouse')[0]['id'];
        $transactions=DB::table('tbl_acc_transactions')  
            ->leftjoin('tbl_acc_coas as fromCoa','fromCoa.id','=','tbl_acc_transactions.tbl_coa_from_id')
            ->leftjoin('tbl_acc_coas as toCoa','toCoa.id','=','tbl_acc_transactions.tbl_coa_to_id')
            ->select('tbl_acc_transactions.*','fromCoa.name as fromName','toCoa.name as toName','fromCoa.parent_id as fromParentId','toCoa.parent_id as toParentId')
            ->where('tbl_acc_transactions.warehouse_id','like',"%$loggedWarehouseId%")
            ->where('tbl_acc_transactions.deleted','=','No')
            ->where('tbl_acc_transactions.status','=','Active')
            ->orderBy('tbl_acc_transactions.id','DESC')
            ->get();

        $output = array('data' => array());
        $i=1;

        foreach ($transactions as $transaction) {
            $coasFrom=ChartOfAccounts::find($transaction->fromParentId);
            $coasTo=ChartOfAccounts::find($transaction->toParentId);

            $status = "";
            if($transaction->status == 'Active'){
                $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;" title="'.$transaction->status.'"></i></center>';
            }else{
                $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;" title="'.$transaction->status.'"></i></center>';
            }

            $button =   '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                                <li class="action"><a href="#/" onclick="confirmDelete('.$transaction->id.')" class="btn"><i class="fas fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>';   
            $output['data'][] = array(
                $i++. '<input type="hidden" name="id" id="id" value="'.$transaction->id.'" />',
                $transaction->transaction_id,
                '<b>'.$coasFrom->name.'</b><br> - '.$transaction->fromName,
                '<b>'.$coasTo->name.'</b><br> - '.$transaction->toName,
                $transaction->amount,
                $transaction->remarks,
                date("d-m-Y", strtotime($transaction->transaction_date)),
                $status,
                $button
            );    
        }
            return $output;
        }
    






        public function getTransferFromSource(Request $request){
            $loggedWarehouseId=Session::get('warehouse')[0]['id'];
            $method=ChartOfAccounts::find($request->payment_method);
            $sources=ChartOfAccounts::where('parent_id','=',$request->payment_method)->where('warehouse_id','like',"%$loggedWarehouseId%")->get();
            $data='';
            $data .='<option value=""selected >Select Source</option>';
            foreach($sources as $source){
                $data.='<option value="'.$source->id.'">'.$source->name.'</option>';
            }
            
            $acHtmlFrom ='<option value=""selected >Select Account</option>';
            $acHtmlFrom.='<option value="'.$method->id.'">'.$method->name.' </option>';
           
            $output=array(
                'method_slug'=>$method->slug,
                'method_id'=>$method->id,
                'data'=>$data,
                'acHtmlFrom'=>$acHtmlFrom
            );
            return $output;
        }


        public function getTransferToSource(Request $request){
            $loggedWarehouseId=Session::get('warehouse')[0]['id'];
            $method=ChartOfAccounts::find($request->payment_method);
            $sources=ChartOfAccounts::where('parent_id','=',$request->payment_method)->where('warehouse_id','like',"%$loggedWarehouseId%")->get();
            $data1='';
            $data1 .='<option value=""selected >Select Source</option>';
            foreach($sources as $source){
                $data1.='<option value="'.$source->id.'">'.$source->name.'</option>';
            }

            if($method->id == $request->transfer_from_ac_no){
                $methodCheckId='';
                $methodCheckName='';
            }else{
                $methodCheckId=$method->id;
                $methodCheckName=$method->name;
            }
            
            $acHtmlTo ='<option value=""selected >Select Account</option>';
            $acHtmlTo.='<option value="'.$methodCheckId.'">'.$methodCheckName.' </option>';
        
            $output=array(
                'method_slug'=>$method->slug,
                'method_id'=>$method->id,
                'data1'=>$data1,
                'acHtmlTo'=>$acHtmlTo
            );
            return $output;
        }



        public function getTransferFromAcNo(Request $request){
            $loggedWarehouseId=Session::get('warehouse')[0]['id'];
            $acNos=ChartOfAccounts::where('parent_id','=',$request->source)->where('warehouse_id','like',"%$loggedWarehouseId%")->get();
         
            $data='';
            $data .='<option value=""selected >Select Source</option>';
            foreach($acNos as $ac){
                $data.='<option value="'.$ac->id.'">'.$ac->name.' </option>';
            }
           
        return $data;
        }




        public function getTransferToAcNo(Request $request){
            $loggedWarehouseId=Session::get('warehouse')[0]['id'];
           $acNos=ChartOfAccounts::where('parent_id','=',$request->source2)->where('parent_id','!=',$request->source1)->where('warehouse_id','like',"%$loggedWarehouseId%")->get();
         
            $data='';
            $data .='<option value=""selected >Select Source</option>';
            foreach($acNos as $ac){
                $data.='<option value="'.$ac->id.'">'.$ac->name.'</option>';
            }
           
        return $data;
        }







       
    public function getFromAmount(Request $request){
        $loggedWarehouseId=Session::get('warehouse')[0]['id'];
        $amount=ChartOfAccounts::where('id','=',$request->transfer_from)->first();
        $fromAmount=$amount->amount;

        $config=DB::table('tbl_acc_coas')
                ->where('tbl_acc_coas.slug','=','cash-bank')
                ->where('tbl_acc_coas.deleted','=','No')
                ->where('tbl_acc_coas.warehouse_id','like',"%$loggedWarehouseId%")
                ->where('tbl_acc_coas.status','=','Active')
                ->first();
        $configId=$config->id;
        
        $banks=ChartOfAccounts::where('parent_id','=',$configId)
                                ->where('deleted','=','No')
                                ->where('status','=','Active')
                                ->where('warehouse_id','like',"%$loggedWarehouseId%")
                                ->get();

        $data='<option value=""selected >Select transfer to</option>';

        foreach($banks as $bank){
            $data.='<option value="'.$bank->id.'">'.$bank->name.'</option>';
        }
        
        $output=array(
            'fromAmount'=>$fromAmount,
            'data'=>$data
        );

        return $output;
    }






    public function getToAmount(Request $request){
        $loggedWarehouseId=Session::get('warehouse')[0]['id'];
        $amount=ChartOfAccounts::where('id','=',$request->transfer_to)->first();
        $toAmount=$amount->amount;
        
        $config=DB::table('tbl_acc_configurations')
                ->where('tbl_acc_configurations.name','=','Bank')
                ->first();

        $configId=$config->tbl_acc_coa_id;

        $banks=ChartOfAccounts::where('our_code','>','500000000')
                                ->where('parent_id','!=',$configId)
                                ->where('id','!=',$request->transfer_from)
                                ->where('our_code','<','600000000')
                                ->where('deleted','=','No')
                                ->where('status','=','Active')
                                ->where('warehouse_id','like',"%$loggedWarehouseId%")
                                ->get();
            $data='<option value=""selected disabled>Select transfer to</option>';
            foreach($banks as $bank){
                $data.='<option value="'.$bank->id.'">'.$bank->name.'</option>';
            }
            
            $output=array(
                'toAmount'=>$toAmount,
                'data'=>$data
            );
        return $output;
    }







    public function checkTransferLimit(Request $request){
        $button='';
        $text='';
        $data='';
        if($request->amount != 0 && $request->amount > 0){

            if($request->transfer_from || $request->amount = null){  
                $transferFrom=ChartOfAccounts::find($request->transfer_from);
                $amount=$transferFrom->amount;
                
                if($amount > $request->amount && $amount != 0 ){
                    $button.='<button type="submit" class="btn btn-primary btnSave" onclick="saveTransactions()"><i class="fas fa-save"></i> Save</button>';
                    $text.='<span class="text-success">Now you can transfer this amount</span>';
                }else{
                    $button.='<button type="submit" class="btn btn-secondary"  disabled><i class="fas fa-save"></i> Save</button>';
                    $text.='<span class="text-danger">You do not have enough balance..</span>';
                } 
            }else{
                $button.='<button type="submit" class="btn btn-secondary"  disabled><i class="fas fa-save"></i> Save</button>';
                $text.='<span class="text-danger">You did not select any COA</span>';
            }
        }else{
            $button.='<button type="submit" class="btn btn-secondary"  disabled><i class="fas fa-save"></i> Save</button>';
            $text.='<span class="text-danger">Minimum transaction 01.00 Tk</span>';
    }
        
        $data=array(
            'button'=>$button,
            'text'=>$text
            );
            
        return $data;
        
    }




        public function store(Request $request){
                $loggedWarehouseId=Session::get('warehouse')[0]['id'];
                
                    $cash=ChartOfAccounts::where('slug','=','cash')
                                ->where('warehouse_id','=',$loggedWarehouseId)
                                ->where('deleted','=','No')
                                ->where('status','=','Active')
                                ->first();
                    if($request->transfer_to_method != $cash->id){
                        $paymentMethodTo=ChartOfAccounts::find($request->transfer_to_method);
                        $paymentMethodFrom=ChartOfAccounts::find($request->transfer_from_method);
                        $sourceTo=ChartOfAccounts::find($request->transfer_to_source);
                        $accountTo=ChartOfAccounts::find($request->transfer_to);
                        $paymentCOA=$accountTo->id;
                    }else{
                        $paymentMethodTo=ChartOfAccounts::find($request->transfer_to_method);
                        $paymentMethodFrom=ChartOfAccounts::find($request->transfer_from_method);
                        $source='';
                        $account='';
                        $paymentCOA=$paymentMethodTo->id;
                    }
                    
                $request->validate([ 
                    'remarks'             => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
                    'transfer_from'       => 'required',
                    'transfer_to'         => 'required',
                    'amount'              => 'required|numeric',
                    'transaction_date'    => 'required'
                ]); 
                $coasMethodFrom=ChartOfAccounts::find($request->transfer_from_method);
                $coasMethodTo=ChartOfAccounts::find($request->transfer_to_method);
                $typeString=$coasMethodFrom->slug.'To'.$coasMethodTo->slug;
               //return $coasMethodFrom->slug;
                
                if($request->from_amount_bofore_transaction > $request->amount ){
                    DB::beginTransaction();
                    try {
                        $code = Transactions::where('deleted', 'No')->max('code');
                        $code++;
                        $code = str_pad($code, 6, '000000', STR_PAD_LEFT);
                        $transactions=new Transactions();
                        $transactions->tbl_coa_from_id=$request->transfer_from;
                        $transactions->tbl_coa_to_id=$request->transfer_to;
                        $transactions->code=$code;
                        $transactions->amount=$request->amount;
                        $transactions->transaction_date=$request->transaction_date;
                        $transactions->remarks=$request->remarks;
                        $transactions->to_amount_bofore_transaction=$request->to_amount_bofore_transaction;
                        $transactions->from_amount_bofore_transaction=$request->from_amount_bofore_transaction;
                        $transactions->transaction_id=rand(1, 1000000000000000);
                        $transactions->warehouse_id=$loggedWarehouseId;
                        $transactions->type=$typeString;
                        $transactions->deleted="No";
                        $transactions->status="Active";
                        $transactions->created_by=Auth::user()->id;
                        $transactions->created_date=date('Y-m-d h:s');
                        $transactions->save();
                        $transactionId=$transactions->id;

                        $coasFrom=ChartOfAccounts::find($request->transfer_from);
                        $coasFrom->decrement('amount',$request->amount);
                
                        $coasTo=ChartOfAccounts::find($request->transfer_to);
                        $coasTo->increment('amount',$request->amount);
                       
                        $voucher=new Voucher();
                        $voucher->amount=$request->amount;
                        $voucher->transaction_date=$request->transaction_date;
                        $voucher->payment_method=$request->transfer_from;
                        $voucher->type_no=$transactionId;
                        $voucher->type=$typeString;
                        $voucher->warehouse_id=$loggedWarehouseId;
                        $voucher->deleted="No";
                        $voucher->status="Active";
                        $voucher->created_by=Auth::user()->id;
                        $voucher->created_date=date('Y-m-d h:s');
                        $voucher->save();
                        $voucherId=$voucher->id;

                        $item_array_debit = [
                            'tbl_acc_voucher_id'    => $voucherId,
                            'tbl_acc_coa_id'        => $request->transfer_to,
                            'debit'                 => $request->amount,
                            'particulars'           => $request->remarks,
                            'warehouse_id'          => $loggedWarehouseId,
                            'voucher_title'         => 'Amount came from COA '.$request->transfer_to.' with voucher '.$voucherId,
                            'deleted'               => 'No',
                            'status'                => 'Active',
                            'created_by'            => Auth::user()->id,
                            'created_date'          => date('Y-m-d h:s')
                            ];
                        DB::table('tbl_acc_voucher_details')->insert($item_array_debit);

                        $item_array_credit = [
                            'tbl_acc_voucher_id'    => $voucherId,
                            'tbl_acc_coa_id'        => $request->transfer_from,
                            'credit'                => $request->amount,
                            'warehouse_id'          => $loggedWarehouseId,
                            'voucher_title'         => 'Amount transferred to COA '.$request->transfer_from.' with voucher '.$voucherId,
                            'deleted'               => 'No',
                            'status'                => 'Active',
                            'created_by'            => Auth::user()->id,
                            'created_date'          => date('Y-m-d h:s')
                            ];
                        DB::table('tbl_acc_voucher_details')->insert($item_array_credit);  
                        
                    
                        
                        $maxCode = PaymentVoucher::max(DB::raw('cast(voucherNo AS decimal(6))'));
                        $maxCode++;
                        $maxCode = str_pad($maxCode, 6, '000000', STR_PAD_LEFT);
                        $paymentVoucher = new PaymentVoucher();
                        $paymentVoucher->party_id = 0;
                        $paymentVoucher->voucherNo = $maxCode;
                        $paymentVoucher->transaction_id = $transactionId;
                        $paymentVoucher->amount = floatval($request->amount);
                        $paymentVoucher->paymentDate  = Carbon::now()->format('Y-m-d');
                        $paymentVoucher->type = 'Payment Received';
                        $paymentVoucher->voucherType = 'Transaction';
                        $paymentVoucher->warehouse_id=$loggedWarehouseId;
                        
                        $paymentVoucher->payment_method = $paymentMethodTo->name ?? '';
                        $paymentVoucher->payment_method_coa_id=$request->transfer_to_method;
                        $paymentVoucher->source_coa_id=$request->transfer_to_source ?? '';
                        $paymentVoucher->account_coa_id=$request->transfer_to;
                        
                        $paymentVoucher->remarks = 'Transaction received from '.$coasFrom->name.' to '.$coasTo->name.' with Transaction code: ' . $transactions->code . ' payment: ' . $transactions->amount;
                        $paymentVoucher->created_by = auth()->user()->id;
                        $paymentVoucher->save();
                        
                        $maxCode = PaymentVoucher::max(DB::raw('cast(voucherNo AS decimal(6))'));
                        $maxCode++;
                        $maxCode = str_pad($maxCode, 6, '000000', STR_PAD_LEFT);
                        $paymentVoucher = new PaymentVoucher();
                        $paymentVoucher->party_id = 0;
                        $paymentVoucher->voucherNo = $maxCode;
                        $paymentVoucher->transaction_id = $transactionId;
                        $paymentVoucher->amount = floatval($request->amount);
                        $paymentVoucher->paymentDate  = Carbon::now()->format('Y-m-d');
                        $paymentVoucher->type = 'Payment';
                        $paymentVoucher->voucherType = 'Transaction';
                        $paymentVoucher->warehouse_id=$loggedWarehouseId;
                        
                        $paymentVoucher->payment_method = $paymentMethodFrom->name ?? '';
                        $paymentVoucher->payment_method_coa_id=$request->transfer_from_method;
                        $paymentVoucher->source_coa_id=$request->transfer_from_source ?? '0';
                        $paymentVoucher->account_coa_id=$request->transfer_from ?? '0';
                        
                        $paymentVoucher->remarks = 'Transaction Paid to '.$coasTo->name.' from '.$coasFrom->name.' with Transaction code: ' . $transactions->code . ' payment: ' . $transactions->amount;
                        $paymentVoucher->created_by = auth()->user()->id;
                        $paymentVoucher->save();
                        
                    
                        DB::commit();
                        return response()->json(['success'=>'Transaction successfull']);
                    } catch (Exception $e) {
                        DB::rollBack();
                        return response()->json(['error' =>  'Transaction  rollback!']);
                    }
                }else{
                    $request->validate([
                        'amount'  => 'required'
                        ]);  
                }  
            
        }





        

        public function delete(Request $request){
            DB::beginTransaction();
                try {

                    $transactions=Transactions::find($request->id);
                    $transactions->status="Inactive";
                    $transactions->deleted="Yes";
                    $transactions->deleted_by=Auth::user()->id;
                    $transactions->deleted_date=date('Y-m-d h:s');
                    $transactions->save();

                    $fromId=$transactions->tbl_coa_from_id;
                    $toId=$transactions->tbl_coa_to_id;
                    $amount=$transactions->amount;
                    
                    $coasFrom=ChartOfAccounts::find($fromId);
                    $coasFrom->increment('amount',$amount);
            
                    $coasTo=ChartOfAccounts::find($toId);
                    $coasTo->decrement('amount',$amount);

                    $voucher=Voucher::where('type_no','=',$request->id)->where('type','=',$transactions->type)->first();
                    $voucher->deleted="Yes";
                    $voucher->status="Inactive";
                    $voucher->deleted_by=Auth::user()->id;
                    $voucher->deleted_date=date('Y-m-d h:s');
                    $voucher->save();
                    $voucherId=$voucher->id;
                    VoucherDetails::where('tbl_acc_voucher_id', $voucherId)->update(['deleted' => 'Yes', 'status' => 'Inactive', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
                
                    PaymentVoucher::where('transaction_id','=',$request->id)->where('voucherType','=','Transaction')->update(['deleted' => 'Yes', 'status' => 'Inactive', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
                
                    DB::commit();
                return response()->json(['success'=>'Transaction deleted successfully']);
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['error' =>  'Transaction  rollback!']);
            }
        }













    
    


















}
