<?php

namespace App\Console\Commands;

use App\Cart;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CartDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cartdelete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes carts with lifetimes greater than 10 minutes.';

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
     * @return mixed
     */
    public function handle()
    {
        Cart::where('created_at', '<', Carbon::now()->subMinutes(10))->delete();
    }
}
