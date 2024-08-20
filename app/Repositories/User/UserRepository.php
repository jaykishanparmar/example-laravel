<?php

namespace App\Repositories\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\Note;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;
use Carbon\Carbon;
use Illuminate\Http\Request;


class UserRepository implements UserRepositoryInterface
{
    public function __construct(Controller $response)
    {
       $this->response = $response;
    }

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    public function checkLogin($request)
    {
        return $credentials = $request->token;

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    protected function getToken($data)
    {
        $client = DB::table('oauth_clients')->where('password_client', 1)->first();
        $url = env('BACKEND_URL') . 'oauth/token';
        //dd($client);
        $response = Http::asForm()->withoutVerifying()->post($url, [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $data['email'],
            'password' => $data['password'],
            'scope' => '',
        ]);
        return $response->json();
    }
    
    public function getTask()
    {
        return Task::with('taskNotes')->get();
    }

    public function storeTask($data)
    {
        $task = Task::create($data);
        foreach ($data['notes'] as $note) {
            Note::create([
                "task_id" => $task->id,
                "subject" => $note['subject'],
                "attachments" => data_get($data['image_data'],'image_path'),
                "note" => $note['note']
            ]);
        }
        return Task::find($task->id);
    }

}
