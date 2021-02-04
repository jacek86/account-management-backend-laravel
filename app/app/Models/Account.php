<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    
    public $incrementing = false;
    protected $fillable = ['id'];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'balance' => 'integer',
    ];
    
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
}
