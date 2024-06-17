<?php

namespace App\Repositories\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function login(Request $request);
    public function getTask();
    public function storeTask(Array $request);
}
