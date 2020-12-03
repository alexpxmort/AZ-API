<?php


namespace App\Repositories;

use App\Interfaces\UserInterfaceRepository;
use \App\User;

class UserRepository implements UserInterfaceRepository{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($vals = null):User{
      return  $this->user->create($vals);
    }

    public function update($vals = null,$obj = null){
        return  $obj->update($vals);
    }

    public function delete($obj = null){
        return  $obj->delete();
    }

    public function findAll($paginate = false){
        $users = ($paginate)? $this->user->paginate():$this->user->all();

        return $users;
    }

    public function findBy($attr,$column):User{

        $user = $this->user->where($attr,$column);

        return $user;
    }
}
