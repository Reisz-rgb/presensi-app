<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class LaporanPresensi extends Widget
{
    protected static string $view = 'filament.widgets.laporan-presensi';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 1;
}