<?php

namespace App\Services;
use App\Models\User;

class UserService
{
    // USER LISTINGS
    function userListings($request)
    {
        $query = User::where('id','!=',$request->id);
        if(isset($request->search) && !empty($request->search))
        {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%');
              });
        }
        $query->orderBy('created_at','desc');
        $response = $query->paginate(10);
        return ['status' => true,'response' => $response,'msg' => 'User listings successfully'];
    }
}