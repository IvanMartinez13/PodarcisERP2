<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Nop;

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
        $users = User::whereIn("token", $request->users)->get('id');
        
        $image = $request->file('image');
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


    public function team($token){

        $team = Team::where("token", $token)->with('users')->first();
        return view("pages.teams.team", compact('team'));
    }

    public function send_message(Request $request){

        //1) GET DATA
        $data = [
            "value" => $request->value,
            "user_id" => $request->user_id,
            "team_id" => $request->team_id,
            "token" => md5($request->value.'+'.date('d/m/Y H:i:s'))
        ];

        //2) VERIFY DATA
        $rules = [
            "value" => ["required", "string"],
            "user_id" => ["required", "numeric"],
            "team_id" => ["required", "numeric"],
            "token" =>["required", "string"],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails() == true) {

            return response()->json(["status" => "error", "message" => "No se ha podido enviar el mensaje. "]);
        }

        //3) STORE DATA
        $message = new Message($data);
        $message->save();

        $me = Auth::user();
        //NOTIFY USERS
        $team = Team::where('id', $data["team_id"])
        ->with('users')
        ->first();

        $users = $team["users"];

        foreach ($users as $key => $user) {
            
            if ($user->id != $me->id) {
                
                //CREATE NOTIFICATION
                $data_notification = [
                    "user_id" => $user->id,
                    "message_id" => $message->id,
                    "notified" => 0,
                    "seen" => 0,
                    "token" => md5( $message->id.'+'.$user->id.'+'.date('d/m/Y H:i:s'))
                ];
                $notification = new Notification($data_notification);
                $notification->save();
            }
        }


        //4) RETURN RESPONSE
        return response()->json(["status" => "success", "message" => "Mensaje enviado."]);
    }

    public function get_messages(Request $request){

        $messages = Message::where('team_id', $request->team)->with('user')->get();
        //MARK AS SEEN FOR ME

        $user = Auth::user();
        foreach($messages as $message){

            $notification = Notification::where('user_id', $user->id)
            ->where('message_id', $message->id);

            $notification->update(["seen" => 1, "notified" => 1]);
        }

        return response()->json(["messages" => $messages]);
    }
}
