<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $dates = ['created_at', 'updated_at', 'rent_date'];
    protected $with = ['book', 'student', 'librarian', 'rentStatus', 'receivedLibrarian'];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    public function librarian(){
        return $this->belongsTo(User::class, 'librarian_id');
    }

    public function rentStatus(){
        return $this->hasMany(RentStatus::class)->orderBy('date', 'DESC');
    }

    public function receivedLibrarian(){
        return $this->belongsTo(User::class, 'librarian_received_id');
    }

}
