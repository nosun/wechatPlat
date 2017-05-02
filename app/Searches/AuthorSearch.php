<?php

namespace Share\Searches;

use Share\ModelHelpers\AuthorHelper;

class AuthorSearch extends Search{

    private static $_instance;

    public static function instance(){
        if(!self::$_instance){
            self::$_instance = new AuthorSearch('ecms_author');
        }else{
            self::$_instance->resetDb();
        }
        return self::$_instance;
    }

    public function get(){
        $ids = $this->getIds();
        $return = [];
        foreach($ids as $id){
            $author = AuthorHelper::find($id);
            if($author){
                $return[] = $author;
            }
        }
        return $return;
    }

    public function first(){
        $this->limit(1);
        $ids = $this->getIds();
        if(!empty($ids)){
            return AuthorHelper::find($ids[0]);
        }else{
            return null;
        }
    }
}