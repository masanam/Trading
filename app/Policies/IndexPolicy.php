<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Index;
use App\Model\IndexPrice;
use Illuminate\Auth\Access\HandlesAuthorization;

class IndexPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the user can view the order.
   *
   * @param  App\User  $user
   * @param  App\Index  $index
   * @return mixed
   */
  public function view(User $user, Index $index)
  {
    //
  }

  /**
   * Determine whether the user can create orders.
   *
   * @param  App\User  $user
   * @return mixed
   */
  public function create(User $user)
  {
    return in_array('intel', $user->role);
  }

  /**
   * Determine whether the user can update the order.
   *
   * @param  App\User  $user
   * @param  App\Index  $index
   * @return mixed
   */
  public function update(User $user, Index $index)
  {
    return in_array('intel', $user->role);
  }

  /**
   * Determine whether the user can delete the order.
   *
   * @param  App\User  $user
   * @param  App\Index  $index
   * @return mixed
   */
  public function delete(User $user, Index $index)
  {
    return in_array('intel', $user->role);
  }
}
