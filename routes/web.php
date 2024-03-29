<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\OdsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaoController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\SgaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
    Route::post('/evolutionTasks', [DashboardController::class, 'evolutionTasks'])->middleware(['auth'])->name('dashboard.evolutionTasks');
    Route::get('/changeSkin/{skin}', [DashboardController::class, 'changeSkin'])->middleware(['auth'])->name('dashboard.changeSkin');
});


//IMPERSONATE OTHER USERS
Route::impersonate();
Route::get('/impersonate/{id}', [UserController::class, 'impersonate'])->name('user.impersonate');

//CUSTOMERS
Route::prefix('customers')->middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::put('/create', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/edit/{token}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/update', [CustomerController::class, 'update'])->name('customers.update');
});

//MODULES
Route::prefix('modules')->middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/create', [ModuleController::class, 'create'])->name('modules.create');
    Route::put('/create', [ModuleController::class, 'store'])->name('modules.store');
    Route::get('/edit/{token}', [ModuleController::class, 'edit'])->name('modules.edit');
    Route::put('/update', [ModuleController::class, 'update'])->name('modules.update');
});


//BLOG
Route::prefix('blog')->middleware(['auth', 'role:super-admin'])->group(function () {

    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/create', [BlogController::class, 'create'])->name('blog.create');
    Route::put('/create', [BlogController::class, 'store'])->name('blog.store');
    Route::post('/changeState', [BlogController::class, 'changeState'])->name('blog.changeState');
    Route::get('/edit/{token}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/update', [BlogController::class, 'update'])->name('blog.update');
    Route::put('/delete', [BlogController::class, 'delete'])->name('blog.delete');
    Route::get('/preview/{token}', [BlogController::class, 'preview'])->name('blog.preview');
});


//USERS
Route::prefix('users')->middleware(['auth', 'role:customer-manager'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::put('/create', [UserController::class, 'store'])->name('users.store');
    Route::get('/edit/{token}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/update', [UserController::class, 'update'])->name('users.update');
});

//BRANCHES
Route::prefix('branches')->middleware(['auth', 'role:customer-manager'])->group(function () {
    Route::get('/', [BranchController::class, 'index'])->name('branches.index');
    Route::get('/create', [BranchController::class, 'create'])->name('branches.create');
    Route::put('/create', [BranchController::class, 'store'])->name('branches.store');
    Route::get('/edit/{token}', [BranchController::class, 'edit'])->name('branches.edit');
    Route::put('/update', [BranchController::class, 'update'])->name('branches.update');
});

//DEPARTAMENTS
Route::prefix('departaments')->middleware(['auth', 'role:customer-manager'])->group(function () {
    Route::get('/', [DepartamentController::class, 'index'])->name('departaments.index');
    Route::get('/create', [DepartamentController::class, 'create'])->name('departaments.create');
    Route::put('/create', [DepartamentController::class, 'store'])->name('departaments.store');
    Route::get('/edit/{token}', [DepartamentController::class, 'edit'])->name('departaments.edit');
    Route::put('/update', [DepartamentController::class, 'update'])->name('departaments.update');
});

//PROFILE
Route::prefix('profile')->middleware(['auth'])->group(function () {
    Route::get('/', [UserController::class, 'profile'])->middleware(['auth'])->name('profile');
    Route::put('/{token}', [UserController::class, 'profile_update'])->middleware(['auth'])->name('profile.update');
    Route::post('/photo/{token}', [UserController::class, 'profile_photo'])->middleware(['auth'])->name('profile.photo');
});

//ODS MODULE
Route::prefix('ods')->middleware(['auth'])->group(function () {
    Route::get('/', [OdsController::class, 'index'])->name('ods.index');
    Route::get('/objective/create', [OdsController::class, 'create'])->name('ods.objective.create');
    Route::put('/objective/store', [OdsController::class, 'store'])->name('ods.objective.store');
    Route::get('/objective/edit/{token}', [OdsController::class, 'edit'])->name('ods.objective.edit');
    Route::put('/objective/update', [OdsController::class, 'update'])->name('ods.objective.update');
    Route::get('/objective/evaluate/{token}', [OdsController::class, 'evaluate'])->name('ods.objective.evaluate');
    Route::post('/evaluate/save', [OdsController::class, 'evaluate_save'])->name('ods.objective.evaluate_save');
    Route::post('/evaluate/get_evaluations', [OdsController::class, 'get_evaluations'])->name('ods.objective.get_evaluations');
    Route::post('/evaluate/save_file', [OdsController::class, 'save_file'])->name('ods.objective.save_file');
    Route::get('/strategy/{token}', [OdsController::class, 'strategy'])->name('ods.strategy.index');
    Route::get('/strategy/{token}/create', [OdsController::class, 'strategy_create'])->name('ods.strategy.create');
    Route::put('/strategy/{token}/create', [OdsController::class, 'strategy_store'])->name('ods.strategy.store');
    Route::get('/strategy/{token_objective}/edit/{token_strategy}', [OdsController::class, 'strategy_edit'])->name('ods.strategy.edit');
    Route::put('/strategy/{token}/update', [OdsController::class, 'strategy_update'])->name('ods.strategy.update');
    Route::post('/dashboard', [OdsController::class, 'dashboard'])->name('ods.dashboard');
    Route::post('/dashboard/objective/evolution', [OdsController::class, 'objective_evolution'])->name('ods.dashboard.objective_evolution');
    Route::post('/strategy/evolution_chart', [OdsController::class, 'evolution_chart'])->name('ods.strategy.evolution_chart');
    Route::get('/strategy/{token}/deleted_evaluations', [OdsController::class, 'deleted_evaluations'])->name('ods.evaluations.deleted');
    Route::put('/strategy/evaluation/recover', [OdsController::class, 'recover_evaluation'])->name('ods.evaluations.recover');
    Route::put('/strategy/evaluation/true_delete', [OdsController::class, 'true_delete_evaluation'])->name('ods.evaluations.true_delete');
    Route::post('/delete_file', [OdsController::class, 'delete_file'])->name('ods.evaluations.delete_file');
    Route::put('/strategy/delete', [OdsController::class, 'delete_strategy'])->name('ods.strategy.delete');
    Route::get('/strategy/{token}/recover', [OdsController::class, 'recover_strategies'])->name('ods.strategy.recover');
    Route::put('/strategy/recover', [OdsController::class, 'recover_strategy'])->name('ods.strategy.recovered');
    Route::put('/strategy/true_delete', [OdsController::class, 'strategy_true_delete'])->name('ods.strategy.true_delete');
    Route::get('/recover', [OdsController::class, 'recover'])->name('ods.objective.recover');
    Route::put('/delete', [OdsController::class, 'delete'])->name('ods.objective.delete');
    Route::put('/recovered', [OdsController::class, 'recover_objective'])->name('ods.objective.recovered');
    Route::put('/true_delete', [OdsController::class, 'true_delete'])->name('ods.objective.true_delete');
    Route::post('/dashboard/cards', [OdsController::class, 'cards'])->name('ods.dashboard.cards');
    Route::post('/objective/get_evaluations', [OdsController::class, 'get_objective_evaluations'])->name('ods.objective.get_objective_evaluations');
    Route::post('/objective/evaluate/save', [OdsController::class, 'objective_evaluate_save'])->name('ods.objective.objective_evaluate_save');
    Route::post('/objective/variationChart', [OdsController::class, 'variationChart'])->name('ods.objective.variationChart');
    Route::post('/objective/evolutionChart', [OdsController::class, 'evolutionChart'])->name('ods.objective.evolutionChart');
    Route::get('/strategy/toTask/{token}', [OdsController::class, 'strategy_to_task'])->name('ods.strategy.toTask');
    Route::get('/objective/toTask/{token}', [OdsController::class, 'objective_to_task'])->name('ods.objective.toTask');
    Route::post('/observation', [OdsController::class, 'observation'])->name('ods.objective.observation');
    Route::post('/strategy/observation', [OdsController::class, 'strategy_observation'])->name('ods.objective.strategy.observation');
    Route::post('/addFile', [OdsController::class, 'addFile'])->name('ods.addFiles');
    Route::put('/updateFile', [OdsController::class, 'updateFile'])->name('ods.updateFile');
    Route::put('/delete_file', [OdsController::class, 'deleteFile'])->name('ods.deleteFile');
});

//TASKS MODULE
Route::prefix('tasks')->middleware(['auth'])->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/project/create', [TaskController::class, 'create'])->name('tasks.project.create');
    Route::put('/project/create', [TaskController::class, 'store'])->name('tasks.project.store');
    Route::get('/project/edit/{token}', [TaskController::class, 'edit'])->name('tasks.project.edit');
    Route::put('/project/update', [TaskController::class, 'update'])->name('tasks.project.update');
    Route::get('/project/{token}', [TaskController::class, 'tasks'])->name('tasks.project.details');
    Route::post('/project/get_departaments', [TaskController::class, 'get_departaments'])->name('tasks.project.get_departaments');
    Route::post('/project/add_task', [TaskController::class, 'add_task'])->name('tasks.project.add_task');
    Route::post('/project/update_task', [TaskController::class, 'update_task'])->name('tasks.project.update_task');
    Route::post('/projects/delete_task', [TaskController::class, 'delete_task'])->name('tasks.project.delete_task');
    Route::post('/projects/delete_subtask', [TaskController::class, 'delete_subtask'])->name('tasks.project.delete_subtask');
    Route::get('/project/{project}/task/{task}', [TaskController::class, 'task_details'])->name('tasks.project.task_details');
    Route::put('/project/task/comment', [TaskController::class, 'task_comment'])->name('tasks.project.task_comment');
    Route::put('/project/task/updateCommen/{comment}', [TaskController::class, 'updateComment'])->name('tasks.project.updateComment');
    Route::post('/project/task/add_subtask', [TaskController::class, 'add_subtask'])->name('tasks.project.add_subtask');
    Route::post('/project/task/get_subtask', [TaskController::class, 'get_subtask'])->name('tasks.project.task.get_subtask');
    Route::post('/project/task/subtask/changeState', [TaskController::class, 'changeState'])->name('tasks.project.subtask.changeState');
    Route::post('/project/task/update_subtask', [TaskController::class, 'update_subtask'])->name('tasks.project.update_subtask');
    Route::post('/project/task/addFiles', [TaskController::class, 'addFiles'])->name('tasks.project.addFiles');
    Route::put('/project/task/file/update', [TaskController::class, 'updateFiles'])->name('tasks.file.update');
    Route::post('/project/task/changeState', [TaskController::class, 'changeState_task'])->name('tasks.project.task.changeState');
    Route::put('/project/delete', [TaskController::class, 'project_delete'])->name('tasks.project.delete');
    Route::put('/project/deleteFile', [TaskController::class, 'file_delete'])->name('tasks.project.deleteFile');
    Route::put('/task/updateProgress/{task}', [TaskController::class, 'updateProgress'])->name('tasks.updateProgress');

    Route::delete('/comment/{comment}', [TaskController::class, 'destroyComment'])->name("comment.destroy");
});

//VAO MODULE
Route::prefix('vao')->middleware(['auth', 'can:read Vigilancia Ambiental'])->group(function () {
    Route::get('/', [VaoController::class, 'index'])->name('vao.index');
    Route::get('/create', [VaoController::class, 'create'])->name('vao.create');
    Route::put('/create', [VaoController::class, 'store'])->name('vao.store');
    Route::get('/edit/{token}', [VaoController::class, 'edit'])->name('vao.edit');
    Route::put('/update', [VaoController::class, 'update'])->name('vao.update');
    Route::get('/{token}', [VaoController::class, 'details'])->name('vao.details');
    Route::post('/create_layer_group', [VaoController::class, 'create_layer_group'])->name('vao.create_layer_group');
    Route::post('/addlayer_index', [VaoController::class, 'addlayer_index'])->name('vao.addlayer_index');
    Route::post('/addLayer', [VaoController::class, 'addLayer'])->name('vao.addLayer');
    Route::post('/get_layers', [VaoController::class, 'get_layers'])->name('vao.get_layers');
    Route::get('/{vao_token}/edit/{layer_token}', [VaoController::class, 'layer_edit'])->name('vao.edit.layer');
    Route::put('/update/layer', [VaoController::class, 'layer_update'])->name('vao.update.layer');
    Route::post('/delete_layer', [VaoController::class, 'delete_layer'])->name('vao.delete.layer');
    Route::get('/{token}/visits/create', [VaoController::class, 'create_visit'])->name('vao.create.visits');
    Route::put('/visits/create', [VaoController::class, 'store_visit'])->name('vao.store.visits');
    Route::post('/get_visits', [VaoController::class, 'get_visits'])->name('vao.get.visits');
    Route::get('/{token}/edit', [VaoController::class, 'edit_visit'])->name('vao.edit.visits');
    Route::put('/visits/update', [VaoController::class, 'update_visit'])->name('vao.update.visits');
    Route::post('/delete_visit', [VaoController::class, 'delete_visit'])->name('vao.delete.visits');
    Route::get('/visit/{token_visit}', [VisitController::class, 'details'])->name('vao.visit');
});

//TEAMS MODULE
Route::prefix('teams')->middleware(['auth', 'can:read Teams'])->group(function () {

    Route::get("/", [TeamController::class, 'index'])->name("teams.index");
    Route::get("/create", [TeamController::class, 'create'])->name("teams.create");
    Route::put("/store", [TeamController::class, 'store'])->name("teams.store");
    Route::get("/edit/{token}", [TeamController::class, 'edit'])->name("teams.edit");
    Route::put("/update", [TeamController::class, 'update'])->name("teams.update");
    Route::get("/team/{token}", [TeamController::class, 'team'])->name("teams.team");
    Route::post("/send/message", [TeamController::class, 'send_message'])->name("teams.send.message");
    Route::post("/get/messages", [TeamController::class, 'get_messages'])->name("teams.get.message");
    Route::post("/create/folder", [TeamController::class, 'create_folder'])->name("teams.create.folder");
    Route::post("/get/files", [TeamController::class, 'get_files'])->name("teams.get.files");
    Route::post("/upload/file", [TeamController::class, 'upload_file'])->name("teams.set.files");
});

//SGA MODULE
Route::prefix('sga')->middleware(['auth', 'can:read SGA'])->group(function () { //grupo de rutas
    Route::get("/", [SgaController::class, 'index'])->name("sga.index"); // ruta independiente
    Route::get("/create/activitypre", [SgaController::class, 'create_activity_pre'])->name("sga.create_activity_pre"); //ruta independiente
    Route::put("/store/activitypre", [SgaController::class, 'store_activity_pre'])->name("sga.store_activity_pre");
    Route::get("/edit/activitypre/{id}", [SgaController::class, 'edit_activity_pre'])->name("sga.edit_activity_pre");
    Route::put("/update/activitypre", [SgaController::class, 'update_activity_pre'])->name("sga.update_activity_pre");
    Route::get("/create/processpre", [SgaController::class, 'create_process_pre'])->name("sga.create_process_pre");
    Route::put("/store/processpre", [SgaController::class, 'store_process_pre'])->name("sga.store_process_pre");
    Route::get("/edit/processpre/{id}", [SgaController::class, 'edit_process_pre'])->name("sga.edit_process_pre");
    Route::put("/update/processpre", [SgaController::class, 'update_process_pre'])->name("sga.update_process_pre");
    Route::post('/delete_activitypre', [SgaController::class, 'delete_activity_pre'])->name('sga.delete_activity_pre');
    Route::post('/delete_processpre', [SgaController::class, 'delete_process_pre'])->name('sga.delete_process_pre');
    Route::get('/create/process/{process_type_id}', [SgaController::class, 'create_process'])->name('sga.create_process');
    Route::put("/store/process", [SgaController::class, 'store_process'])->name("sga.store_process");



    //AJAX REQUETS
    Route::post('/get_actions', [SgaController::class, 'get_actions'])->name('sga.get_actions');
});


//NOTIFICATIONS
Route::post('/get_notifications', [DashboardController::class, "get_notifications"])->name("get_notifications"); //CHECK NOTIFICATIONS


require __DIR__ . '/auth.php';
