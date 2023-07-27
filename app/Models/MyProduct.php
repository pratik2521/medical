<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MyProduct extends Model
{
    use HasFactory;
    public function specification()
    {
        return $this->hasMany(MyProductSpecifications::class, 'my_product_id');
    }

   public function faq()
   {
    return $this->hasMany(MyProductFAQs::class, 'my_product_id');
   }

   public function features()
   {
    return $this->hasMany(MyProductFeatures::class, 'my_product_id');
   }
   
   public function productImage()
   {
    return $this->hasMany(MyProductGalleries::class, 'my_product_id')->where('type', 'main_section')->limit(1);;
   }

   public function featurescompare()
   {
    return $this->hasMany(MyProductFeaturesCompareWith::class, 'my_product_id');
   }

   public function mainGallery()
   {
    return $this->hasMany(MyProductGalleries::class, 'my_product_id')->where('type', 'main_section');
   }
   
   public function sliderGallery()
   {
    return $this->hasMany(MyProductGalleries::class, 'my_product_id')->where('type', 'slider');
   }

   public function singleGallery()
   {
    return $this->hasMany(MyProductGalleries::class, 'my_product_id')->where('type', 'single');
   }

   public function review()
   {
    return $this->hasMany(MyProductReviews::class, 'my_product_id');
   }

   public function sidebar()
   {
    return $this->hasMany(MyProductSideBar::class, 'my_product_id');
   }

   public function sqnc()
   {
    return $this->hasMany(MyProductSqnc::class, 'my_product_id');
   }

   public function table()
   {
    return $this->hasMany(MyProductTables::class, 'my_product_id');
   } 

   public function youtubelink()
   {
    return $this->hasMany(MyProductYouTubeLink::class, 'product_id');
   } 

   public function assign_feature()
    {
        return $this->belongsToMany(MyProductMultiFeatures::class, 'my_product_assing_features', 'my_product_id', 'my_feature_id');
    }
}
