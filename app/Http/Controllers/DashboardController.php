<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Module;
use App\Models\Objective;
use App\Models\Project;
use App\Models\Session;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('super-admin')) {
            $customers = Customer::get(); //get all customers
            $modules = Module::get(); //get all modules
            $size = filesize(storage_path('/app/public')); // Bytes;
            $maximo = 1073741824;
            $restante = ($maximo - $size) / $maximo;

            $length = strlen((string)$size);

            if ($length >= 4 && $length < 8) { //KB
                $size = $size / 1024 . " KB";
            } elseif ($length >= 8 && $length < 12) { //MB
                $size = $size / 1048576 . " MB";
            } elseif ($length >= 12) { //GB
                $size = $size / 1073741824 . " GB";
            } else {
                $size = $size . " Bytes";
            }

            $blogs = Blog::get();


            return view('dashboard', compact('customers', 'modules', 'size', 'restante', 'blogs'));
        }

        $customer = Customer::where('id', $user->customer_id)->first();

        //BRANCHES
        $branches = Branch::where('customer_id', $customer->id)->get();
        $last_year = date('Y') - 1;
        $this_year = date('Y');

        $branches_actually = Branch::where('customer_id', $customer->id)->whereYear('created_at', $this_year)->get();
        $branches_past = Branch::where('customer_id', $customer->id)->whereYear('created_at', $last_year)->get();

        $trending = 100;
        if (count($branches_past) > 0) {
            $trending = (count($branches_actually) * 100) / count($branches_past);

            if ($trending > 100) {
                $trending -= 100;
            }
        }


        //OBJECTIVES
        $objectives = Objective::where('customer_id', $customer->id)->whereHas('evaluations', function ($q) {

            $q->where('value', '!=', null);
        })->get();
        $all_objectives = Objective::where('customer_id', $customer->id)->get();
        $objectives_pending = count($all_objectives) - count($objectives);

        //TASKS
        $projects = Project::where('customer_id', $customer->id)->get('id');
        $tasks = Task::whereIn('project_id', $projects)->where('task_id', null)->get();
        $tasks_pending = Task::whereIn('project_id', $projects)->where('task_id', null)->where('is_done', 0)->get();


        //ONLINE USERS
        $users = User::where('customer_id', $customer->id)->get('id'); //all users
        $sessions = Session::whereIn('user_id', $users)->get();

        return view('dashboard', compact(
            'customer',
            'branches',
            'trending',
            'objectives',
            'objectives_pending',
            'tasks',
            'tasks_pending',
            'users',
            'sessions'
        ));
    }

    public function evolutionTasks(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if ($user->hasRole('customer-manager')) {

            //1) GET ALL TASKS
            $projects = Project::where('customer_id', $user->customer_id)->get('id');
            $tasks = Task::whereIn('project_id', $projects)->where('task_id', null)->get();
            //2) FILTER BY MONTH
            $MONTHS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

            $array_tasks = [];
            $array_done = [];
            $array_undone = [];

            foreach ($MONTHS as $month) {
                $array_tasks[$month] = [];
                foreach ($tasks as $task) {
                    $task_month = date('m', strtotime($task->created_at));
                    if ($task_month == $month) {

                        array_push($array_tasks[$month], $task);
                    }
                }
            }
            //3) FILTER BY IS_DONE
            foreach ($MONTHS as $month) {
                $array_done[$month] = 0;
                $array_undone[$month] = 0;
                foreach ($array_tasks[$month] as $task) {
                    if ($task->is_done == 0) {

                        $array_undone[$month] += 1;
                    } else {

                        $array_done[$month] += 1;
                    }
                }
            }
            //4) RETURN ARRAY

            return response()->json(['tasks' => $array_tasks, 'done' => $array_done, 'undone' => $array_undone]);
        } else {

            return response()->json(['respuesta' => 'no tienes derecho']);
        }
    }
}
