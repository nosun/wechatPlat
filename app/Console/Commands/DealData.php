<?php

namespace Share\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DealData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:dealData';

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
     * @return mixed
     */
    public function handle()
    {
        // set ad article status = -1
        $adWords = ['团','招募','报名','推广','预告','特种兵','开奖','微课','最后一天'];

        foreach($adWords as $word){
            DB::table('wx_article')->where('title','like','%'.$word.'%')->update(['status' => -1]);
        }

    }
}
