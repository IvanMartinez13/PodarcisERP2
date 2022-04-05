<?php

namespace App\Http\Controllers;

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
    function index()
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


            return view('dashboard', compact('customers', 'modules', 'size', 'restante'));
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
}
