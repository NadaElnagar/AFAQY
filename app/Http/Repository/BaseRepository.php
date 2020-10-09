<?php


namespace App\Http\Repository;


class BaseRepository
{

    public function paginationRepository($request,$query)
    {
        $total_page_count = 0;
        $limit    = $request['perPage'];
        $offset   = ($request['page'] - 1) * $limit;
        $count = $query->count();
        if(isset($limit)) {
            $total_page_count  = ceil($count/$limit);
        }
        if (isset($limit) ) $query->limit($limit);
        if(isset($offset) && $offset!=null)  $query->offset($offset);
        $data = $query->get();
        return array('count'=>$count,'total_page_count'=>$total_page_count,'data'=>$data);
     }
}
