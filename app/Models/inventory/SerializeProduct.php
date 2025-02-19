<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerializeProduct extends Model
{
    use HasFactory;
    protected $table = 'tbl_inventory_serialize_products';
}
