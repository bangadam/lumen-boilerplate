<?php

namespace App\Services;

class Keyword{

    public static function search($query, $request, $table=null){
        $keyword = $request->get('search');
        if(isset($keyword)){
            $param = explode('|',$keyword);
            if(count($param) >= 2){
                list($searchBy, $word) = $param;

                if($table != null){
                    $query = $word == null ? $query
                        : $query->where($table.'.'.$searchBy,'ilike','%'.$word.'%');
                }
                else{
                    $query = $word == null ? $query
                        : $query->where($searchBy,'ilike','%'.$word.'%');
                }
            }
            else{
                if($table != null){
                    $query = $query->where($table.'.'.'name','ilike','%'.$keyword.'%');
                }
                else{
                    $query = $query->where('name','ilike','%'.$keyword.'%');
                }
            }
        }
        return $query;
    }

    public static function status($model, $query, $request, $table=null){
        $status = $request->get('status');
        if(isset($status)){
            if($status === 'all'){
                return $model;
            }
            if($table != null){
                $query = $status == null ? $query
                    : $model::where($table.'.status',$status);
            }
            else{
                $query = $status == null ? $query
                    : $model::where('status',$status);
            }
        }
        return $query;
    }

    public static function order($query, $request, $table=null){
        $order = $request->get('sort');
        if(isset($order)){
            $param = explode('|',$order);
            if(count($param) >= 2){
                list($orderBy,$value) = $param;

                if($table != null){
                    $query = $query->orderBy($table.'.'.$orderBy,$value);
                }
                else{
                    $query = $query->orderBy($orderBy,$value);
                }
            }
            else{
                if($table != null){
                    $query = $query->orderBy($table.'.id',$order);
                }
                else{
                    $query = $query->orderBy('id',$order);
                }
            }
        }
        else{
            if($table != null){
                return $query->orderBy($table.'.dateCreated','desc');    
            }
            return $query->orderBy('dateCreated','desc');
        }
        return $query;
    }

    public static function price($query, $request, $table=null){
        $priceMin = $request->get('priceMin');
        $priceMax = $request->get('priceMax');

        if(isset($priceMin) && $priceMin != null){
            if($table != null){
                $query = $query->where($table.'.price','>=',$priceMin);
            }
            else{
                $query = $query->where('price','>=',$priceMin);
            }
        }

        if(isset($priceMax) && $priceMax != null){
            if($table != null){
                $query = $query->where($table.'.price','<=',$priceMax);
            }
            else{
                $query = $query->where('price','<=',$priceMax);
            }
        }

        return $query;
    }

    public static function district($query, $request, $table=null){
        $districtId = $request->get('districtId');

        if(isset($districtId) && $districtId != null){
            if($table != null){
                $query = $query->where($table.'.district_id',$districtId);
            }
            else{
                $query = $query->where('district_id',$districtId);
            }
        }
    
        return $query;
    }

    public static function village($query, $request, $table=null){
        $villageId = $request->get('villageId');

        if(isset($villageId) && $villageId != null){
            if($table != null){
                $query = $query->where($table.'.village_id',$villageId);
            }
            else{
                $query = $query->where('village_id',$villageId);
            }
        }
    
        return $query;
    }

    public static function paginateUrl($service, $request, $path){
        $url = $service->withPath(env('APP_URL').'/'.$request->segment(1).'/'.$request->segment(2).'/'.$path);
        return $url;
    }

    public static function isJSON($string){
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}