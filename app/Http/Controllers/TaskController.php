<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Task\AddTaskRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    protected $userRepository;

    function __construct(UserRepositoryInterface $userRepository)
    {
       $this->userRepository = $userRepository;
    }

    public function getTask()
    {
        try {
            $data = $this->userRepository->getTask();
            return $this->sendResponse(true, 'List of Tasks', $data, 200);
         } catch (\Exception $e) {
            return $this->handleException($e);
         }
    }

   public function addTask(AddTaskRequest $request)
   {
      DB::beginTransaction();
      try {
         $data = $request->all();
         $data['image_data'] = [];
         if ($request->file('attachment')) {
            $response = addFiles($request,$data);  
         }
         $result = $this->userRepository->storeTask($response);
         DB::commit();
         return $this->sendResponse(true, 'Task Added', $result, 200);
      } catch (\Exception $e) {
         DB::rollback();
         return $this->handleException($e);
      }
   }

}
