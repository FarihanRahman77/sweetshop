<?php

namespace App\Http\Controllers\Admin\Assets;

use App\Http\Controllers\Controller;
use App\Models\Assets\AssetDepreciationDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;

class AssetController extends Controller
{
    public function index(){
		
        $assetSerializeProducts=DB::table('tbl_asset_serialize_products')
								->where('tbl_asset_serialize_products.is_sold','=','OFF')
								->where('tbl_asset_serialize_products.deleted','=','No')
								->where('tbl_asset_serialize_products.status','=','Yes')
								->get();
        return view('admin.assets.asset.view-asset',['assetSerializeProducts'=>$assetSerializeProducts]);
    }



    public function getAssets(Request $request){
        $assetSerializeProducts=DB::table('tbl_asset_serialize_products')
								->leftjoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_serialize_products.tbl_assetProductsId')
								->leftjoin('tbl_asset_purchases','tbl_asset_purchases.id','=','tbl_asset_serialize_products.asset_purchase_id')
								->leftjoin('users','tbl_asset_serialize_products.created_by','=','users.id')
								->leftjoin('tbl_crm_parties','tbl_asset_serialize_products.supplier_id','=','tbl_crm_parties.id')
								->select('tbl_asset_serialize_products.*','tbl_asset_products.productName',
								'tbl_asset_products.productCode','users.name as userName','tbl_crm_parties.name as partyName','tbl_crm_parties.contact as partyContact')
								->where('tbl_asset_serialize_products.is_sold','=','OFF')
								->where('tbl_asset_serialize_products.deleted','=','No')
								->where('tbl_asset_serialize_products.status','=','Yes')
								->get();
        $output = array('data' => array());
        $i = 1;
        $button='';
		$activeDays=0;
		$dep_amount=0;
		$usedDays=0;
		$depreciationDatas='';
        foreach ($assetSerializeProducts as $product) {

			/* active days */
			$purchase_date = new DateTime($product->created_date);
			$current_date = new DateTime(date('Y-m-d'));
			$interval = $current_date->diff($purchase_date);
			$activeDays= ($interval->y * 365) + ($interval->m * 30) + $interval->d;
			
			 if($product->depreciation == 'No Depricition' || $product->depreciation == 'One Time Pay'){
				$dep_amount=$product->price;
			}else{ 
				$depreciationDatas=AssetDepreciationDetails::where('tbl_serializeId','=',$product->id)->orderby('id','DESC')->first();
				/* Total depriciative days */
				$purchase_date = new DateTime($product->created_date);
				$last_depreciation_date = new DateTime($depreciationDatas->deducted_date);
				$interval2 = $last_depreciation_date->diff($purchase_date);
				$last_depreciation_days= ($interval2->y * 365) + ($interval2->m * 30) + $interval2->d;

				/* calculate depreciation  */
				$dep_amount= $product->price - (($product->price/$last_depreciation_days) * $activeDays);
			 }
			

			$button = '<td style="width: 12%;">
			<div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<i class="fas fa-cog"></i>  <span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
						<li class="action" onclick="assignTo(' . $product->id . ')"  ><a  class="btn" ><i class="fa fa-user-plus"></i> Assign To</a></li>
					</ul>
				</div>
			</td>'; 
			 $badgeColor = '';
			 $status='';
			if ($product->status == 'Yes') {
				$badgeColor = 'success';
				$status="Available";
			} else {
				$badgeColor = 'danger';
				$status="Not Available";
			} 
			
			$output['data'][] = array(
				$i++,
				date("d-m-Y h:i a",strtotime($product->created_date)),
				$product->productName,
                $product->serial_no,
				'<b>Name : </b>'.$product->partyName.'<br> <b>Mobile : </b>'.$product->partyContact,
                $product->userName,
				
				$product->price,
				number_format($dep_amount, 2, '.', '').' value after using this product for '. $activeDays .' days',
				'<span class="badge badge-pill badge-'.$badgeColor.'  text-center"> '.$status.'  </span>',
				$button
			);
			
		}
		
		return $output;
    }



	public function generateAssetPdf(){
		 $assetSerializeProducts=DB::table('tbl_asset_serialize_products')
								->leftjoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_serialize_products.tbl_assetProductsId')
								->leftjoin('tbl_asset_purchases','tbl_asset_purchases.id','=','tbl_asset_serialize_products.asset_purchase_id')
								->leftjoin('users','tbl_asset_serialize_products.created_by','=','users.id')
								->leftjoin('tbl_crm_parties','tbl_asset_serialize_products.supplier_id','=','tbl_crm_parties.id')
								->select('tbl_asset_serialize_products.*','tbl_asset_products.productName',
								'tbl_asset_products.productCode','users.name as userName','tbl_crm_parties.name as partyName','tbl_crm_parties.contact as partyContact')
								->where('tbl_asset_serialize_products.is_sold','=','OFF')
								->where('tbl_asset_serialize_products.deleted','=','No')
								->where('tbl_asset_serialize_products.status','=','Yes')
								->get();
		$pdf = PDF::loadView('admin.assets.asset.assetReport',['assetSerializeProducts'=>$assetSerializeProducts]);
		return $pdf->stream('asset-report-pdf.pdf', array("Attachment" => false));
	}


	








}
