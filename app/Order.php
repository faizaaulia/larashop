<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function books() {
        return $this->belongsToMany('App\Book')->withPivot('quantity');
    }
    
    public function getTotalQuantityAttribute() { // dynamic property // accessed with $totalQuantity
        $totalQuantity = 0;

        foreach($this->books as $book){
            $totalQuantity += $book->pivot->quantity;
        }

        return $totalQuantity;
    }
}
