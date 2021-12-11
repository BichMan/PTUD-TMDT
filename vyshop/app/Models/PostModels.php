<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModels extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'post_title', 'post_desc', 'post_content', 'post_status','post_image', 'post_meta_desc', 'post_meta_keywords','cate_post_id'
    ];
    protected $primaryKey = 'post_id';
    protected $table = 'tbl_posts';
    public function cate_post(){
        return $this->belongsTo('App\Models\PostCategoryModels','cate_post_id');
    }
}

