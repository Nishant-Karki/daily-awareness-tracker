<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwarenessEntry extends Model
{
    use HasFactory;
    protected $table = 'awareness_entry';
    protected $fillable = ['user_id','creative_hours','note'];
    protected $attributes = ['creative_hours' => 0];

    //one-to-one
    public function user(){
        return $this->belongsTo(User::class);
    }

    //one-to-one
    public function qualityScore()
    {
        return $this->hasOne(QualityScore::class);
    }

}
