<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       $stock_hold = \DB::table('stock_holds')->where('updated_at','<',date('Y-m-d H:i:s', strtotime('-15 minutes')))->first();
       if($stock_hold){
        $stock = \App\Stock::where('Office_Code','=',$stock_hold->Office_Code)->where('Product_Code','=',$stock_hold->Product_Code)->first();
        if($stock){
        $stock->Hold_Qty =$stock->Hold_Qty - $stock_hold->Hold_Qty;
        $stock->save();
        }
       }
       $stock_hold = \DB::table('stock_holds')->where('updated_at','<',date('Y-m-d H:i:s', strtotime('-15 minutes')))->delete();
      echo "cron Work Successfully";
    }
}
