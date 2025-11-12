<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class LoanType extends Model
{
    use HasSlug;

    protected $fillable = ['slug', 'icon', 'poster','order', 'status'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function translations()
    {
        return $this->hasMany(LoanTypeTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations()
            ->whereHas('language', fn($q) => $q->where('code', $locale))
            ->first();
    }

    public function conditions()
    {
        return $this->hasOne(LoanCondition::class);
    }

    public function collateralTypes()
    {
        return $this->hasMany(CollateralType::class);
    }
}
