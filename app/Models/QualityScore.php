<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityScore extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'score', 'awareness_entry_id'];
    protected $attributes = ['score' => 0];

    //one-to-one
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //one-to-one
    public function awarenessEntry()
    {
        return $this->belongsTo(AwarenessEntry::class);
    }
}
