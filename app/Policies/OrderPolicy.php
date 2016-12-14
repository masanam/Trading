<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the user can view the order.
   *
   * @param  App\User  $user
   * @param  App\Order  $order
   * @return mixed
   */
  public function view(User $user, Order &$order)
  {
    $subs = $user->subordinates();
    $users = $subs->pluck('id')->all(); 
    $users[] = $user->id;

    // modify records based on the positions
    foreach($order->sells as &$sell)
      if(!in_array($sell->user_id, $users))
        $sell->seller = $sell->location = $sell->port_name = $sell->address = '-hidden value-';

    foreach($order->buys as &$buy)
      if(!in_array($sell->user_id, $users))
        $buy->buyer = $buy->location = $buy->port_name = $buy->address = '-hidden value-';

    foreach($order->users as $orderUser){
      if($orderUser->id === $user->id) return true;
    }
    return $user->id === $order->user_id;
  }

  /**
   * Determine whether the user can create orders.
   *
   * @param  App\User  $user
   * @return mixed
   */
  public function create(User $user)
  {
      //
  }

  /**
   * Determine whether the user can update the order.
   *
   * @param  App\User  $user
   * @param  App\Order  $order
   * @return mixed
   */
  public function update(User $user, Order $order)
  {
    return $user->id === $order->user_id;
  }

  /**
   * Determine whether the user can delete the order.
   *
   * @param  App\User  $user
   * @param  App\Order  $order
   * @return mixed
   */
  public function delete(User $user, Order $order)
  {
      //
  }
}
