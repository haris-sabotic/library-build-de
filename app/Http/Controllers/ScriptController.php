<?php

namespace App\Http\Controllers;
use App\Models\Script;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\ScriptService;

class ScriptController extends Controller
{

    private $viewFolder = 'pages/settings/scripts';

    /**
     * Prikazi stranicu za editovanje pisma
     *
     * @param  Script $script
     */
    public function showEdit(Script $script) {

        $viewName = $this->viewFolder . '.editScript';

        $viewModel = [
            'script'=>$script
        ];

        return view($viewName ,$viewModel);
    }

    /**
     * Prikazi sva pisma
     *
     * @param  ScriptService $scriptService
     */
    public function index(ScriptService $scriptService) {

        $viewName = $this->viewFolder . '.scripts';

        $viewModel = [
            'scripts' => $scriptService->getScripts()->paginate(7)
        ];

        return view($viewName ,$viewModel);
    }

    /**
     * Prikazi stranicu za unos novog pisma
     *
     */
    public function showAdd() {

        $viewName = $this->viewFolder . '.addScript';

        return view($viewName);
    }

    /**
     * Kreiraj i sacuvaj novo pismo
     *
     * @param  Script $script
     * @param  ScriptService $scriptService
     */
    public function save(Script $script, ScriptService $scriptService) {

        $viewModel = [
            'script' => $script
        ];

        $scriptService->saveScript($script);

        //return back to all scripts
        return redirect('scripts')->with('success', 'Pismo je uspješno uneseno!');
    }

    /**
     * Izmijeni podatke o pismu
     *
     * @param  Script $script
     * @param  ScriptService $scriptService
     */
    public function update(Script $script, ScriptService $scriptService) {

        $viewModel = [
            'script' => $script
        ];

        $scriptService->editScript($script);

        //return back to all scripts
        return redirect('scripts')->with('success', 'Pismo je uspješno izmijenjeno!');
    }

    /**
     * Izbrisi pismo
     *
     * @param  Script $script
     */
    public function delete(Script $script) {

        Script::destroy($script->id);
        
        return back()->with('success', 'Pismo je uspješno izbrisano!');
    }
}
