<?php

namespace App\Http\Controllers;
use App\Models\Format;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\FormatService;

class FormatController extends Controller
{
    
    private $viewFolder = 'pages/settings/formats';

     /**
     * Prikazi stranicu za editovanje formata
     *
     * @param  Format $format
     */
    public function showEdit(Format $format) {

        $viewName = $this->viewFolder . '.editFormat';

        $viewModel = [
            'format'=>$format
        ];

        return view($viewName,$viewModel);
    }

    /**
     * Prikazi stranicu za unos novog formata
     *
     */
    public function showAdd() {

        $viewName = $this->viewFolder . '.addFormat';

        return view($viewName);
    }

    /**
     * Prikazi sve formate
     *
     * @param  FormatService $formatService
     */
    public function index(FormatService $formatService) {

        $viewName = $this->viewFolder . '.formats';

        $viewModel = [
            'formats' => $formatService->getFormats()->paginate(7)
        ];

        return view($viewName,$viewModel);
    }

    /**
     * Kreiraj i sacuvaj novi format
     *
     * @param  Format $format
     * @param  FormatService $formatService
     */
    public function save(Format $format, FormatService $formatService) {

        $viewModel = [
            'format' => $format
        ];

        $formatService->saveFormat($format);

        return redirect('formats')->with('success', 'Format je uspješno unesen!');
    }

    /**
     * Izmijeni podatke o formatu
     *
     * @param  Format $format
     * @param  FormatService $formatService
     */
    public function update(Format $format, FormatService $formatService) {

        $viewModel = [
            'format' => $format
        ];

        $formatService->editFormat($format);

        //return back to all genres
        return redirect('formats')->with('success', 'Format je uspješno izmijenjen!');
    }

    /**
     * Izbrisi format
     *
     * @param  Format $format
     */
    public function delete(Format $format) {
    
        Format::destroy($format->id);
        
        return back()->with('success', 'Format je uspješno izbrisan!');
    }
}
