<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

abstract class Controller
{
    public function generateReport() {
   

    return view('reports.tickets', compact('stats'));
}
}
