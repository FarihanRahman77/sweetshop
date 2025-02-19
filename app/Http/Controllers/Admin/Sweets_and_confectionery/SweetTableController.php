<?php

namespace App\Http\Controllers\Admin\Sweets_and_confectionery;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\hotelManagement\Building;
use App\Models\Setups\Warehouse;
use App\Models\RestaurentManagement\Table;
use App\Models\Assets\AssetProduct;
use App\Models\Assets\AssetSerializeProduct;
use Illuminate\Support\Facades\DB;
use Image;
class SweetTableController extends Controller
{
    public function index(){
      
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $data['buildings'] = Building::where('deleted', 'No')->where('status', '=', 'Active')->get();
        $data['rooms'] = Warehouse::where('tbl_sister_concern_id','=',$logged_sister_concern_id)->where('deleted', 'No')->where('status', '=', 'Active')->get();
        $data['assetProducts'] = AssetProduct::where('deleted', 'No')->where('status', '=', 'Active')->get();
        $data['assetSerializeProducts'] = AssetSerializeProduct::where('sister_concern_id','=',$logged_sister_concern_id)->where('deleted', 'No')->get();
        
        return view('admin.Sweets_and_confectionery.table.tableView',$data);
    }


    public function getTable(){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $tables =Table::leftjoin('tbl_setups_warehouses','tbl_setups_warehouses.id','=','tables.warehouse_id')
                        ->leftjoin('tbl_asset_serialize_products','tbl_asset_serialize_products.id','=','tables.asset_product_id')
                        ->select('tables.*','tbl_setups_warehouses.name as roomName','tbl_asset_serialize_products.serial_no')
                        ->where('tables.sister_concern_id','=',$logged_sister_concern_id)
                        ->where('tables.deleted', 'No')
                        ->where('tables.status', '=', 'Active')
                        ->orderBy('tables.id', 'DESC')
                        ->get();
        $output = array('data' => array());
        $i = 1;
        foreach ($tables as $table) {
            $status = "";
            if ($table->status == 'Active') {
                $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;" title="' . $table->status . '"></i></center>';
            } else {
                $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;" title="' . $table->status . '"></i></center>';
            }
            // $imageUrl = url('upload/table_images/' . $table->image);
            $imagePath = 'upload/table_images/' . $table->image;
            $defaultImage = 'upload/table_images/no_image.png'; // Set your default image path

            $imageUrl = url(file_exists(public_path($imagePath)) ? $imagePath : $defaultImage);
            $button = '<td style="width: 12%;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                                <li class="action" onclick="editFloor(' . $table->id . ')"  ><a  class="btn" ><i class="fas fa-edit"></i> Edit </a></li>
                                </li>
                            </li> 
                                <li class="action"><a   class="btn"  onclick="confirmDelete(' . $table->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
                                </li>
                                </ul>
                            </div>
                        </td>';

            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $table->id . '" />',
                '<img style="max-width:50px; max-height:80px;" src="' . $imageUrl . '" alt="no image" />',
                '<b>Table Name : </b>'.$table->name.'<br> <b>Room : </b>'.$table->roomName,
                '<b>Table Code : </b>'.$table->code,
                '<b>Asset Serial No : </b>'.$table->serial_no,
                $table->capacity .' person',
                $status,
                $button
            );
        }
        return $output;
    }



    public function assetSerializeProduct(Request $request){
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $serializeAssetProducts=AssetSerializeProduct::where('tbl_assetProductsId','=',$request->asset_product_id)
                                ->where('sister_concern_id','=',$logged_sister_concern_id)
                                ->where('deleted', 'No')
                                ->get();
        $html='<option value="" selected> Select Asset Serialize Product </option>';
        foreach($serializeAssetProducts as $serializeAssetProduct){
            $html.='<option value="'.$serializeAssetProduct->id.'">'.$serializeAssetProduct->serial_no.'</option>';
        }
        return $html;
    }



    public function store(Request $request){
        //return $request;
        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'capacity' => 'numeric|required',
            'building' => 'required|numeric',
            'room' => 'required|numeric',
            'asset_product_id' => 'required|numeric',
            'asset_serialize_product_id' => 'required|numeric',
        ]);

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '_', $request->name);
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $maxCode = Table::where('deleted', 'No')->max('code');
        $maxCode++;
        $maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);
        DB::beginTransaction();
        try {

            if ($request->hasFile('image')) {
                $request->validate([
                    'image'   =>  'image|max:2048'
                ]);
                $tableImage = $request->file('image');
                $name = $tableImage->getClientOriginalName();
                $uploadPath = 'upload/table_images/';
                $imageName = time() . $name;
                $imageUrl = $uploadPath . $imageName;
               
               
                Image::make($tableImage)->resize(100, 100)->save($imageUrl);
                $request->image->move(public_path($uploadPath), $imageName);
                // End Image Resize
            }else{
                $imageName = "upload/table_images/no_image.png";
            }

            $table=new Table();
            $table->name=$request->name;
            $table->slug=$slug;
            $table->code=$maxCode;
            $table->building_id=$request->building;
            $table->warehouse_id=$request->room;
            $table->sister_concern_id=$logged_sister_concern_id;
            $table->asset_product_category_id=$request->asset_product_id;
            $table->asset_product_id=$request->asset_serialize_product_id;
            $table->capacity=$request->capacity;
            $table->image=$imageName;
            $table->status = 'Active';
            $table->created_by = auth()->user()->id;
            $table->created_date = date('Y-m-d H:i:s');
            $table->deleted = 'No';
            $table->save();


            DB::commit();
            return response()->json(['success' => 'Table saved successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => "rollBack! Please try again" . $e]);
        }
    }



    public function edit(Request $request){
        $table=Table::find($request->id);
        return $table;
    }



    public function update(Request $request){
        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'capacity' => 'numeric|required',
            'building' => 'required|numeric',
            'room' => 'required|numeric',
            'asset_product_id' => 'required|numeric',
            'asset_serialize_product_id' => 'required|numeric',
        ]);
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '_', $request->name);
        DB::beginTransaction();
        try {

            $table=Table::find($request->id);

               if ($request->hasFile('image')) {
                $request->validate([
                    'image'   =>  'image|max:2048'
                ]);
                $tableImage = $request->file('image');
                $name = $tableImage->getClientOriginalName();
                $uploadPath = 'upload/table_images/';
                $imageName = time() . $name;
                $imageUrl = $uploadPath . $imageName;
               
               
                Image::make($tableImage)->resize(100, 100)->save($imageUrl);
                $request->image->move(public_path($uploadPath), $imageName);
                // End Image Resize
            }else{
                $imageName=$table->image;
            }
            $table->name=$request->name;
            $table->slug=$slug;
            $table->building_id=$request->building;
            $table->warehouse_id=$request->room;
            $table->sister_concern_id=$logged_sister_concern_id;
            $table->asset_product_category_id=$request->asset_product_id;
            $table->asset_product_id=$request->asset_serialize_product_id;
            $table->capacity=$request->capacity;
            $table->image=$imageName;
            $table->status = $request->status;
            $table->updated_by = auth()->user()->id;
            $table->updated_date = date('Y-m-d H:i:s');
            $table->save();


            DB::commit();
            return response()->json(['success' => 'Table updated successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => "rollBack! Please try again" . $e]);
        }
    }





    public function delete(Request $request){
        $table=Table::find($request->id);
        $table->status = "Inactive";
        $table->deleted = "Yes";
        $table->deleted_by = auth()->user()->id;
        $table->deleted_date = date('Y-m-d H:i:s');
        $table->save();
        return response()->json(['success' => 'Table deleted successfully']);
    }




}
