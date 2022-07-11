<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityPre;
use App\Models\ProcessPre;
use App\Models\ProcessType;
use Illuminate\Support\Facades\DB;

class SgaController extends Controller
{
    /**
     * @method index
     * todo: te enseña la pagina principal del modulo sga, recoge informacion de las actividades
     * @return view sga.index
     */
    public function index()
    {
        /* 1) recoger informacion de las actividades y los procesos
           2) enviar informacion a la vista de sga index
         */
        $actividades = ActivityPre::get(); //select masivo Modelo::get(); fetch_all(); FORMATO: [obj, obj, ...]
        $procesos = ProcessPre::with('process_type')->get();

        return view("pages.sga.index", compact("actividades", "procesos")); //[alias => $valor]
    }

    /**
     * @method create_activity_pre
     * todo: te enseña la pagina de creacion de actividades
     * @return view sga.create_activity_pre
     */
    public function create_activity_pre() //Llama a a la pagina
    {

        return view("pages.sga.create_activity_pre");
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
        //2) VERIFY DATA
        if ($name != null) {

            //3) SAVE DATA
            try {
                DB::beginTransaction();
                ActivityPre::create(["name" => $name]); //crea la actividad
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
        return view("pages.sga.edit_activity_pre", compact("actividad"));
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
        //2) VERIFY DATA
        if ($name != null) {

            //3) SAVE DATA
            try {
                DB::beginTransaction();
                ActivityPre::where("id", $id)->update(["name" => $name]); //crea la actividad
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
        $activities = ActivityPre::get();
        $proceso = ProcessPre::where("id", $id)->with('process_type')->with('activities_pre')->first(); //select individual Modelo::where("id", $valor)->first(); fetch(); FORMATO: obj
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
}
