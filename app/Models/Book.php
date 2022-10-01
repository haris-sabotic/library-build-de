<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getDetails() {
        $authors = [];
        foreach(BookAuthor::All()->where('book_id', $this->id) as $va) {
            array_push($authors, Author::find($va->author_id));
        }

        $categories = [];
        foreach(BookCategory::All()->where('book_id', $this->id) as $vc) {
            array_push($categories, Category::find($vc->category_id));
        }

        $genres = [];
        foreach(BookGenre::All()->where('book_id', $this->id) as $vg) {
            array_push($genres, Genre::find($vg->genre_id));
        }

        $photo = '';
        $book_gallery = DB::table('galeries')
                    ->where('book_id', $this->id);
        if ($book_gallery != null) {
            $cover = $book_gallery->where('cover', 0);

            if ($cover->first() != null) {
                $photo = $cover->first()->photo;
            }
        }


        $quantity = $this->quantity - $this->reservedBooks - $this->rentedBooks;

        $result = [
            'id' => $this->id,
            'title' => $this->title,
            'authors' => $authors,
            'summary' => $this->summary,
            'available' => $quantity > 0,
            'quantity' => $quantity,
            'categories' => $categories,
            'genres' => $genres,
            'publisher' => Publisher::find($this->publisher_id)->name,
            'publishYear' => $this->publishYear,
            'photo' => $photo
        ];

        return $result;
    }
}
