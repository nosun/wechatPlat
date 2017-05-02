<?php

namespace Share\Console\Commands;

use Illuminate\Console\Command;
use EasyWeChat\Foundation\Application;
use Share\ModelHelpers\WechatContentModelHelper;
use Log;

class DownloadWechatNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:downloadNews {--type=news} {--max=10} {--days=7} {--page=1} {--pageNum=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'download wechat news media';

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
    public function handle(Application $wechat)
    {
        $type  = $this->option('type');
        $max   = $this->option('max');
        $days  = (int)$this->option('days');
        $page  = (int)$this->option('page');
        $pageNum  = (int)$this->option('pageNum');

        $material = $wechat->material;
        $stats = json_decode($material->stats());
        $count = $stats->{$type.'_count'};

        if($max !== 'all'){
            $count = $max > $count ? $count : $max;
        }

        $pageTotal = (int) floor($count / $pageNum) + 1;

        while($page <= $pageTotal ){
            $offset  = $pageNum * ( $page -1 );
            $lists = $material->lists($type,$offset,$pageNum);
            foreach($lists['item'] as $item){
                switch($type){
                    case 'news': // only download news
                        $itemTime  = $item['content']['create_time'];
                        $beginTime =  time() - 86400 * $days;

                        if( $itemTime < $beginTime) {
                            $this->info('time to finished');
                            return;
                        }

                        WechatContentModelHelper::saveNews($item);
                        break;
                    case 'image': // only download news
                        $itemTime  = $item['update_time'];
                        $beginTime =  time() - 86400 * $days;

                        if( $itemTime < $beginTime) {
                            $this->info('time to finished');
                            return;
                        }

                        $image = $material->get($item['media_id']);

                        $ext = WechatContentModelHelper::getImageType($item['url']);

                        if(empty($ext)){
                            $ext = 'jpg';
                            Log::info($item['media_id'].' '.$item['url']);
                        }

                        // save file
                        $path = WechatContentModelHelper::saveFile($image,$ext);
                        $item['path'] = $path['path'];

                        // save data
                        WechatContentModelHelper::saveImage($item);
                        break;
                    default:
                        $this->info('no this type'.$type);
                        return;
                }
            }

            $log = [
                    'type' => $type,
                    'page' => $page,
                    'max'  => $max,
                    'days' => $days,
                    'pageNum' => $pageNum,
                    'time' => time()
            ];

            Log::info(json_encode($log));

            $page ++;
        }
        $this->info('finished');
    }
}
