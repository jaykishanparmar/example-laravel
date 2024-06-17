<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;
    protected $table = "errorlogs";
    protected $fillable = ["user_id", "user_ip", "error_name", "user_agent", "request_method", "user_request", "user_response", "request_url"];
}
