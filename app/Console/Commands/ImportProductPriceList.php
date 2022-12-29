<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InboundSyncProducts extends Command
{
    protected $signature = 'product:import-price-list';

    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        
    }
}
