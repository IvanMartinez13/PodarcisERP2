<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\ActivityPre;
use App\Models\Customer;
use App\Models\ProcessPre;
use App\Models\ProcessType;
use App\Models\Process;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SgaController extends Controller
{
    /**
     * @method index
     * todo: te enseña la pagina principal del modulo sga, recoge informacion de las actividades
     * @return view sga.index
     */
    public function index()
    {
        $user = Auth::user();
        //@ts-ignore
        if ($user->hasRole("super-admin")) {
            /* 1) recoger informacion de las actividades y los procesos
                2) enviar informacion a la vista de sga index
            */
            $actividades = ActivityPre::get(); //select masivo Modelo::get(); fetch_all(); FORMATO: [obj, obj, ...]
            $procesos = ProcessPre::with('process_type')->get();

            return view("pages.sga.index", compact("actividades", "procesos")); //[alias => $valor]
        }

        $soporte = ProcessType::SOPORTE;  //id 1
        $operativos = ProcessType::OPERATIVOS; //id 2
        $estrategicos = ProcessType::ESTRATEGICOS; //id 3
        $manager = $user->customer->manager;

        //SELECCIONAR PROCESOS DE SOPORTE
        $soporteProcesos = Process::where("type_process_id", $soporte)->get();
        //SELECCIONAR PROCESOS OPERATIVOS
        $operativosProcesos = Process::where("type_process_id", $operativos)->get();
        //SELECCIONAR PROCESOS ESTRATEGICOS
        $estrategicosProcesos = Process::where("type_process_id", $estrategicos)->get();

        return view("pages.sga.customer.index", compact(
            "estrategicos",
            "operativos",
            "soporte",
            "manager",
            "soporteProcesos",
            "operativosProcesos",
            "estrategicosProcesos"
        )); //[alias => $valor]
    }

    /**
     * @method create_activity_pre
     * todo: te enseña la pagina de creacion de actividades
     * @return view sga.create_activity_pre
     */
    public function create_activity_pre() //Llama a a la pagina
    {
        $tiposProcesos = ProcessType::get();
        return view("pages.sga.create_activity_pre", compact("tiposProcesos"));
    }

    /**
     * @method store_activity_pre
     * todo: save form data on db
     * @param request objeto con los datos del formulario
     * @return redirection to index page
     */
    public function store_activity_pre(Request $request) //Guardar datos
    {
        //1) GET DATA
        $name = $request->name;
        $type = $request->process_type_id;
        //2) VERIFY DATA
        if ($name != null) {

            //3) SAVE DATA
            try {
                DB::beginTransaction();
                ActivityPre::create(["name" => $name, "process_type_id" => $type]); //crea la actividad
                DB::commit();

                //4) RETURN REDIRECT
                return redirect(route("sga.index"))->with("status", "success")->with("message", "La actividad ha sido creada correctamente.");
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                //abort(500);
                return redirect(route("sga.index"))->with("status", "error")->with("message", "Fatal: La actividad no se ha podido crear.");
            }
        }
        abort(500);
    }

    /**
     * @method edit_activity_pre
     * todo: te enseña la pagina de edicion de actividades
     * @return view sga.edit_activity_pre
     */
    public function edit_activity_pre($id) //llama a la pagina
    {
        /* 1) recoger el id (ok)
           2) hacer select para mostrar los datos (ok)
           3) enviar datos al formulario
        */


        $actividad = ActivityPre::where("id", $id)->first(); //select individual Modelo::where("id", $valor)->first(); fetch(); FORMATO: obj
        $tiposProcesos = ProcessType::get();
        return view("pages.sga.edit_activity_pre", compact("tiposProcesos", "actividad")); // DEVUELVE LA VISTA con los datos necesarios compact("variable", "variable", ...)
    }

    /**
     * @method update_activity_pre
     * todo: actualiza base de datos con los datos del formulario
     * @param request objeto con los datos del formulario
     * @return redirection to index page
     */
    public function update_activity_pre(Request $request) //edita los datos
    {
        //1) GET DATA
        $name = $request->name;
        $id = $request->id;
        $process_type_id = $request->process_type_id;
        //2) VERIFY DATA
        if ($name != null) {

            //3) SAVE DATA
            try {
                DB::beginTransaction();
                ActivityPre::where("id", $id)->update(["name" => $name, "process_type_id" =>  $process_type_id]); //crea la actividad
                DB::commit();

                //4) RETURN REDIRECT
                return redirect(route("sga.index"))->with("status", "success")->with("message", "La actividad ha sido editada correctamente.");
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                //abort(500);
                return redirect(route("sga.index"))->with("status", "error")->with("message", "Fatal: La actividad no se ha podido editar.");
            }
        }
        abort(500);
    }

    /**
     * @method create_process_pre
     * todo: te enseña la pagina de creacion de procesos
     * @return view sga.create_process_pre
     */
    public function create_process_pre() //llama a la pagina
    {

        $tiposProcesos = ProcessType::get(); //select masivo Modelo::get(); fetch_all(); FORMATO: [obj, obj, ...]
        $activities = ActivityPre::get();
        return view("pages.sga.create_process_pre", compact("tiposProcesos", "activities")); //[alias => $valor]


    }

    /**
     * @method store_process_pre
     * todo: save form data on db
     * @param request objeto con los datos del formulario
     * @return redirection to index page
     */
    public function store_process_pre(Request $request) //guarda los datos
    {
        //1) GET DATA
        $datos = [
            "name" => $request->name,
            "responsable" => $request->responsable,
            "target" => $request->target,
            "process_type_id" => $request->process_type_id,
        ];
        $activities = $request->activities;
        //2) VERIFY DATA
        if ($datos != null) {

            //3) SAVE DATA
            try {
                DB::beginTransaction();
                $processPre = new ProcessPre($datos); //crea el process
                $processPre->save(); //create insert
                $processPre->activities_pre()->sync($activities); //array de id
                DB::commit();

                //4) RETURN REDIRECT
                return redirect(route("sga.index"))->with("status", "success")->with("message", "El proceso ha sido creado correctamente.");
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                echo $th;
                //abort(500);
                //return redirect(route("sga.index"))->with("status", "error")->with("message", "Fatal: el proceso no se ha podido crear.");
            }
        }
        abort(500);
    }

    public function edit_process_pre($id) //llama a la pagina
    {
        /* 1) recoger el id (ok)
           2) hacer select para mostrar los datos (ok)
           3) enviar datos al formulario
        */
        $tiposProcesos = ProcessType::get(); //select masivo Modelo::get(); fetch_all(); FORMATO: [obj, obj, ...]
        $proceso = ProcessPre::where("id", $id)->with('process_type')->with('activities_pre')->first(); //select individual Modelo::where("id", $valor)->first(); fetch(); FORMATO: obj
        $activities = ActivityPre::where("process_type_id", $proceso->process_type_id)->get();
        return view("pages.sga.edit_process_pre", compact("proceso", "tiposProcesos", "activities"));
    }

    /**
     * @method update_activity_pre
     * todo: actualiza base de datos con los datos del formulario
     * @param request objeto con los datos del formulario
     * @return redirection to index page
     */
    public function update_process_pre(Request $request) //edita los datos
    {
        //1) GET DATA

        $datos = [
            "name" => $request->name,
            "responsable" => $request->responsable,
            "target" => $request->target,
            "process_type_id" => $request->process_type_id,
        ];

        $id = $request->id;
        $activities = $request->activities;

        //2) VERIFY DATA
        if ($datos != null) {

            //3) SAVE DATA
            try {
                DB::beginTransaction();
                ProcessPre::where("id", $id)->update($datos); //crea la actividad
                //recoger el proceso editado
                $process = ProcessPre::where("id", $id)->first();
                //Gurardar las relaciones
                $process->activities_pre()->sync($activities); //array de id
                DB::commit();

                //4) RETURN REDIRECT
                return redirect(route("sga.index"))->with("status", "success")->with("message", "El proceso ha sido editado correctamente.");
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                abort(500);
                return redirect(route("sga.index"))->with("status", "error")->with("message", "Fatal: El proceso no se ha podido editar.");
            }
        }
        abort(500);
    }

    public function delete_activity_pre(Request $request)
    {

        //1) GET DATA
        $id = $request->id;


        //3) CLEAR  DATA
        try {
            DB::beginTransaction();
            ActivityPre::where("id", $id)->delete(); //elimina la actividad
            DB::commit();

            //4) RETURN REDIRECT
            return redirect(route("sga.index"))->with("status", "success")->with("message", "La actividad ha sido eliminada correctamente.");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            //abort(500);
            return redirect(route("sga.index"))->with("status", "error")->with("message", "Fatal: La actividad no se ha podido eliminar.");
        }

        abort(500);
    }

    public function delete_process_pre(Request $request)
    {

        //1) GET DATA
        $id = $request->id;


        //3) CLEAR  DATA
        try {
            DB::beginTransaction();
            ProcessPre::where("id", $id)->delete(); //elimina el proceso
            DB::commit();

            //4) RETURN REDIRECT
            return redirect(route("sga.index"))->with("status", "success")->with("message", "El proceso ha sido eliminado correctamente.");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            //abort(500);
            return redirect(route("sga.index"))->with("status", "error")->with("message", "Fatal: El proceso no se ha podido eliminar.");
        }

        abort(500);
    }

    /**
     * @method get_actions
     * @param request with id processType
     * @return response JSON object with actionsPre
     */
    public function get_actions(Request $request)
    {
        $process_type_id =  $request->process_type_id;
        $actividades = ActivityPre::where("process_type_id", "=", $process_type_id)->get(); //get() == fetchAll()
        $response = ["actividades" => $actividades];
        return response()->json($response); // { indice: valor }
    }

    public function create_process($process_type_id)
    {
        $processType = ProcessType::where("id", "=", $process_type_id)->first();
        $actividadesPredefinidas = ActivityPre::where("process_type_id", "=", $process_type_id)->get(); //get() == fetchAll()
        return view("pages.sga.customer.create_process", compact("processType", "actividadesPredefinidas")); //[alias => $valor]

    }

    /**
     * @method store_process
     * todo: save form data on db
     * @param request objeto con los datos del formulario
     * @return redirection to index page
     */
    public function store_process(Request $request) //guarda los datos
    {
        //1) GET DATA
        $datos = [
            "name" => $request->name,
            "responsable" => $request->responsable,
            "target" => $request->target,
            "customer_id" => Auth::user()->customer_id,
            "type_process_id" => $request->type_process_id,
        ];
        $actividadesPredefinidas = ActivityPre::whereIn("id", $request->activitiesPre)->get();
        $actividades = $request->activities;
        //2) VERIFICAR DATOS
        //rules -> array de reglas a seguir
        $rules = [
            "name" => "required|string",
            "responsable" => "required|string",
            "target" => "required|string",
            "customer_id" => "required|integer",
            "type_process_id" => "required|integer",
        ];

        $validator = Validator::make($datos, $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        //CREAR PROCESO
        try {
            DB::beginTransaction();
            $process = new Process($datos); //crea el process
            $process->save(); //create insert
            if ($actividades != null) {
                foreach ($actividades as $actividad) {
                    if ($actividad != null) {
                        Activity::create(["name" => $actividad, "process_id" => $process->id]);
                    }
                }
            }
            if ($actividadesPredefinidas != null) {
                foreach ($actividadesPredefinidas as $actividad) {
                    if ($actividad->name != null) {
                        Activity::create(["name" => $actividad->name, "process_id" => $process->id]);
                    }
                }
            }


            DB::commit();

            //4) RETURN REDIRECT
            return redirect(route("sga.index"))->with("status", "success")->with("message", "El proceso se ha creado.");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return redirect(route("sga.index"))->with("status", "error")->with("message", "Fatal: el proceso no se ha podido crear.");
        }
    }
}
