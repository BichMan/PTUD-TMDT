<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModels extends Model
{
    public $timestamp = false; //set time false
    //
    protected $fillable = ['product_name', 'product_desc',
    'product_status', 'meta_keywords', 'product_content',
    'product_price', 'product_image', 'brand_id', 'category_id'];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';

    public function brand_product(){
        return $this->belongsTo('App\Models\BrandProductModels','brand_id');
    }

    public function category_product(){
        return $this->belongsTo('App\Models\CategoryProductModels','category_id');
    }
}
