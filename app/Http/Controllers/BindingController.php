<?php

namespace App\Http\Controllers;

use App\Models\Binding;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\BindingService;

class BindingController extends Controller
{

    private $viewFolder = 'pages/settings/bindings';

    /**
     * Prikazi stranicu za editovanje poveza
     *
     * @param  Binding $binding
     */
    public function showEdit(Binding $binding) {

        $viewName = $this->viewFolder . '.editBinding';

        $viewModel = [
            'binding'=>$binding
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu za unos novog poveza
     *
     */
    public function showAdd() {

        $viewName = $this->viewFolder . '.addBinding';

        return view($viewName);
    }

     /**
     * Prikazi sve poveze
     *
     * @param  BindingService $bindingService
     */
    public function index(BindingService $bindingService) {

        $viewName = $this->viewFolder . '.bindings';

        $viewModel = [
            'bindings'=>$bindingService->getBindings()->paginate(7)
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Kreiraj i sacuvaj novi povez
     *
     * @param  Binding $binding
     * @param  BindingService $bindingService
     */
    public function save(Binding $binding, BindingService $bindingService) {

        $viewModel = [
            'binding' => $binding
        ];

        $bindingService->saveBinding($binding);

        //return back
        return redirect('bindings')->with('success', 'Povez je uspješno unesen!');
    }

    /**
     * Izmijeni podatke o povezu
     *
     * @param  Binding $binding
     * @param  BindingService $bindingService
     */
    public function update(Binding $binding, BindingService $bindingService) {

        $viewModel = [
            'binding' => $binding
        ];

        $bindingService->editBinding($binding);

        //return back to the binding
        return redirect('bindings')->with('success', 'Povez je uspješno izmijenjen!');
    }

    /**
     * Izbrisi povez
     *
     * @param  Binding $binding
     */
    public function delete(Binding $binding) {

        Binding::destroy($binding->id);
        
        return back()->with('success', 'Povez je uspješno izbrisan!');
    }
}
