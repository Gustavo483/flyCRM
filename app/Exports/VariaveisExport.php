<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VariaveisExport implements FromView
{

    private $dados;

    /**
     * @param $dados
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('export.variaveisExport', [
            'dados' => $this->dados
        ]);
    }
}
