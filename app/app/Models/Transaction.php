<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    public $incrementing = false;
    protected $fillable = ['id','account_id','amount'];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'integer',
    ];
    
    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }
}
