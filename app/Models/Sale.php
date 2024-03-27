<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['event_id', 'qty_tickets', 'voucher', 'buyer','date'];
    
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    
}
