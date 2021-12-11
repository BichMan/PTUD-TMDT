<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductModels extends Model
{
    public $timestamp = false; //set time false
   //
   protected $fillable = ['category_name','category_desc', 'category_status', 'meta_keywords'];
   protected $primaryKey = 'category_id';
   protected $table = 'tbl_category_product';
   public function category(){
    $this->hasMany('App\Models\ProductModels');
}
}
