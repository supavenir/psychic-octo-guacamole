<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $users=User::with(['category'])->get();
        foreach ($users as $user) {
            echo $user->category->name;
        }
    }
}
