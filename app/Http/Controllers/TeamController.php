<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        if ($user->hasRole('customer-manager')) {
            $teams = Team::where('customer_id', $user->customer_id)->get();
        }else{
            $teams = Team::whereHas('users', function($q) use($user) {
                $q->where("user_id", $user->id);
            })->get();
        }
        return view("pages.teams.index", compact("teams"));
    }

    public function create(){

        $customer_id = Auth::user()->customer_id;
        $users = User::where('customer_id', $customer_id)->get();
        return view("pages.teams.create", compact('users'));
    }

    public function store(StoreTeamRequest $request){

        //1) GET DATA
        $user = Auth::user();
        $users = User::whereIn("token", $request->users)->get('id');//id array
        $data = [
            "name" => $request->name,
            "description" => $request->description,
            "token" => md5( $request->name.'+'.date("d/m/Y H:i:s") ),
            "customer_id" => $user->customer_id,
        ];
        $image =  $request->file('image');//file
        //2) PREPARE DATA
        if ($image != null) {
            
            $folder = "/teams/".$user->customer_id."/".$data["token"];

            if (!is_dir( storage_path('/app/public').$folder )) {
                mkdir(storage_path('/app/public').$folder, 0777, true);
            }

            $ext = '.'.$image->guessExtension();
            $path = $folder.'/'.$data['token'].$ext;

            move_uploaded_file($image, storage_path('/app/public').$path);
            $data["image"]=$path;
        }
        //3) STORE DATA
        $team = new Team($data);
        $team->save();
        $team->users()->sync($users);
        //4) RETURN REDIRECT
        return redirect( route('teams.index') )->with("status", "success")->with("message", "Equipo de trabajo creado.");

    }

    public function edit($token){
        $customer_id = Auth::user()->customer_id;
        $users = User::where('customer_id', $customer_id)->get();
        $team = Team::where("token", $token)->with('users')->first();
        return view("pages.teams.edit", compact('users', 'team'));
    }


    public function update(UpdateTeamRequest $request){
       
        //1) GET DATA
        $team = Team::where("token", $request->token)->first();
        $data = [
            "name" => $request->name,
            "description" => $request->description,
        ];
        $users = User::where("token", $request->users)->get('id');
        $image = $request->file('image');
        //2) PREPARE DATA
        //2) PREPARE DATA
        if ($image != null) {
            
            $folder = "/teams/".$team->customer_id."/".$team->token;

            if (!is_dir( storage_path('/app/public').$folder )) {
                mkdir(storage_path('/app/public').$folder, 0777, true);
            }

            if (is_file( storage_path('/app/public').$team->image )) {
                unlink(storage_path('/app/public').$team->image);
            }

            $ext = '.'.$image->guessExtension();
            $path = $folder.'/'.$team->token.$ext;

            move_uploaded_file($image, storage_path('/app/public').$path);
            $data["image"]=$path;
        }
        //3) UPDATE DATA
        $team = Team::where("token", $request->token)->update($data);
        $team = Team::where("token", $request->token)->first();
        $team->users()->sync($users);
        //4) RETURN REDIRECT
        return redirect( route('teams.index') )->with("status", "success")->with("message", "Equipo de trabajo editado.");
    }
}
