<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function dashboardAdminUser()
    {
        return view('AdminUser.dashboard',['tela'=>'dashboard']);
    }

    public function vizualizarTodasleadsEmpresa()
    {
        return view('AdminUser.leads.vizualizarTodasleadsEmpresa',['tela'=>'leads']);
    }

    public function vizualizarAgenda()
    {
        return view('AdminUser.agenda.vizualizarAgenda',['tela'=>'agenda']);
    }

    public function configuracaoEmpresa()
    {
        return view('AdminUser.configuracao.configuracaoEmpresa',['tela'=>'configuracao']);
    }

}
