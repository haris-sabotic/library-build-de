<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function studentRent(){
        return $this->hasMany(Rent::class, 'student_id');
    }

    public function librarianRent(){
        return $this->hasMany(Rent::class, 'librarian_id');
    }

    public function reservation() {
        return $this->hasMany(Reservation::class);
    }

    public function author() {
        return $this->hasMany(BookAuthor::class,'book_id')->whereNotNull('book_id');
    }

    public function genre() {
        return $this->hasMany(BookGenre::class,'book_id')->whereNotNull('book_id');
    }

    public function publisher() {
        return $this->belongsTo(Publisher::class);
    }

    public function category() {
        return $this->hasMany(BookCategory::class,'book_id')->whereNotNull('book_id');
    }

    public function binding() {
        return $this->belongsTo(Binding::class);
    }

    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function script() {
        return $this->belongsTo(Script::class);
    }

    public function format() {
        return $this->belongsTo(Format::class);
    }

    public function coverImage() {
        return $this->hasMany(Galery::class)->where('cover', '=', 1);
    }

    public function galery() {
        return $this->hasMany(Galery::class);
    }
}
