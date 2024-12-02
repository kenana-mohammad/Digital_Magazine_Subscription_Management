<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Magazine;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\AuthorizationException;

class MagazinePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
        Log::debug('User Role in Policy: ' . $user->role);

        if( $user->role == 'admin' )
        {
            return true;

        };
        throw new AuthorizationException('يُسمح فقط للمدير  .');


    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Magazine $magazine)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
        
         if( $user->role == 'admin'  || $user->role == 'publisher')
        {
            return true;

        };
        throw new AuthorizationException('يُسمح فقط للمدير والناشر بإضافة مجلة.');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user,Magazine $magazine)
    {
        //
        Log::debug('User Role in Policy: ' . $user->role);
        return in_array($user->role, ['admin']);
       
        // إذا لم يكن المستخدم مسؤولاً، يتم رفع استثناء

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Magazine $magazine)
    {
        //
        return in_array($user->role, ['admin']);

    }
    public function subscribe(User $user, Magazine $magazine){
        if($user->role=='subscriber'){
       
            return true;
  }

  else{
    throw new AuthorizationException('يُسمح فقط للمشترك  .');

  }
}
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Magazine $magazine)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Magazine $magazine)
    {
        //
    }
    //add article
    public function add_article(User $user,Magazine $magazine){
        Log::debug('User Role in Policy: ' . $user->role);

        if(  $user->role == 'publisher')
        {
            return true;

        };
        throw new AuthorizationException('يُسمح فقط للناشر  .');

    }
    //view articles 
    public function getAricles(User $user,Magazine $magazine)
{
   $check=$magazine->users()->where('magazine_id',$magazine->id)->where('user_id',$user->id)->first();
  if($check->pivot->status === 'active'){
    Log::debug('view articles  '. $check->pivot->status);

    return true;

  }

  throw new AuthorizationException(' لا يمكن انت غير مشترك    .');
  Log::debug('لا يمكن لست مشترك');

}
}
