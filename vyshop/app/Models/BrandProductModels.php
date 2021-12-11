<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandProductModels extends Model
{
   public $timestamp = false; //set time false
   //
   protected $fillable = ['brand_name','brand_desc', 'brand_status', 'meta_keywords'];
   protected $primaryKey = 'brand_id';
   protected $table = 'tbl_brand';
   public function brand(){
      $this->hasMany('App\Models\ProductModels');
  }
}
