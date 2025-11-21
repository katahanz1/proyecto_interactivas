<?php

namespace App\Models;

use App\Models\Book; // Added for the relationship
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
    //
}
