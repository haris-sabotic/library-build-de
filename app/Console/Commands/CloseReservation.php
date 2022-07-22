<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Book;
use Carbon\Carbon;
class CloseReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:closeReservation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close reservation after it expires.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reservations = Reservation::where('close_date', '<', Carbon::now())->where('closeReservation_id', '=', 5)->get();

        foreach($reservations as $reservation) {
            $reservation->closeReservation_id = 1;
            $reservation->save();

            $book = Book::find($reservation->book_id);
            $book->reservedBooks = $book->reservedBooks - 1;
            $book->save();
        }
    }
}
