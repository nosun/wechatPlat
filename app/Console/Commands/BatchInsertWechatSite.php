<?php

namespace Share\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Share\Models\WechatSite;

class BatchInsertWechatSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:tsfSite';

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
        $sites = DB::table('wx_article')
            ->select('author','biz', DB::raw('count(id)'))
            ->groupBy('biz')
            ->groupBy('author')
            ->havingRaw('count(id) > 100')
            ->get();

        foreach($sites as $site){
            $res = WechatSite::where('biz',$site->biz)->first();
            if(empty($res)){
                $wechat = new WechatSite();
                $wechat->fill(['name' => $site->author,'biz' => $site->biz]);
                $wechat->save();
            }
        }
    }
}
