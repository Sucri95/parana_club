<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tasks;
use App\SalesByUser;
use App\SalesDetail;
use App\Sales;
use App\TasksByResponsable;
use App\Product;
use App\CashDeposit;
use App\Classroom;
use App\ClassDaySchedule;
use App\Reservation;
use App\CashTransaction;
use App\Plans;
use App\PlanByUser;
use App\ActivityByTutor;
use App\Classes;
use App\PaidTutors;
use DB;
use Auth;
use View;

class ReceptionController extends Controller
{

	public function showView()
	{
		$user = Auth::user()->id;

		if(!empty($user)){
			$tasks = Tasks::where('responsable_user_id', $user)->where(function ($query) {
                $query->where('show_on', DB::raw('CURDATE()'))
                		->orWhere('all_days', true);
            })->where('status', 'Activo')->get();

            foreach ($tasks as $keyvalue) {
            	$tasks_by_user = TasksByResponsable::where('responsable_user_id', $user)->where('tasks_id', $keyvalue->id)->whereDate('created_at', DB::raw('CURDATE()'))->first();

            	if(!empty($tasks_by_user)){

            		$keyvalue->check = true;
            		$keyvalue->tasks_by_user_id = $tasks_by_user;
            	} else {
            		$keyvalue->check = false;

            	}
            }

			//WHERE all_days == 1 (tarea de todos los días) OR show_on today.

            return View::make('list.tasks_list_byusers', array('tasks' => $tasks));
		}
	}

	public function showCreateBlade()
	{
		return View::make('tasksbyuser');

	}


	//MI PERFIL OBTENER LAS TAREAS 
	/*ROUTE -> site/get_tasks_by_user */

	public function getTasksByUser(){

		if(!empty($_GET['user'])){

			$user = $_GET['user'];

			$tasks = Tasks::where('responsable_user_id', $user)->where(function ($query) {
                $query->where('show_on', DB::raw('CURDATE()'))
                		->orWhere('all_days', true);
            })->where('status', 'Activo')->get();

            foreach ($tasks as $keyvalue) {
            	$tasks_by_user = TasksByResponsable::where('responsable_user_id', $user)->where('tasks_id', $keyvalue->id)->whereDate('created_at', DB::raw('CURDATE()'))->first();

            	if(!empty($tasks_by_user)){

            		$keyvalue->check = true;
            		$keyvalue->tasks_by_user_id = $tasks_by_user;
            	} else {
            		$keyvalue->check = false;

            	}
            }

			//WHERE all_days == 1 (tarea de todos los días) OR show_on today.

			return $tasks;
		}

	}
	
	//MI PERFIL GUARDAR COMPLETADO DE TAREAS
	/*ROUTE -> site/store_tasks_by_user */

	public function storeTasksByUser(Request $request){

		if(!empty($request->user) && !empty($request->tasks_id)){

			$tasks_by_user = TasksByResponsable::where('responsable_user_id', $user)->where('tasks_id', $keyvalue->id)->whereDate('created_at', DB::raw('CURDATE()'))->first();

			if(!empty($tasks_by_user)){

				$task_by_user = new TasksByResponsable;
				$task_by_user->responsable_user_id = $request->user;
				$task_by_user->tasks_id = $request->tasks_id;
				$task_by_user->save();

				return $task_by_user;				
			}


			//GUARDAR ID PARA PODER ELIMINAR

		}

	}

	//MI PERFIL REMOVER COMPLETADO DE TAREAS DESTILDA CHECK
	/*ROUTE -> site/remove_tasks_by_user */

	public function removeTasksByUser(Request $request){

		if(!empty($request->user) && !empty($request->tasks_by_user_id)){

			$tasks_by_user = TasksByResponsable::find($request->tasks_by_user_id);
			$tasks_by_user->delete();

			return $request->tasks_by_user_id;


		}

	}

	//EMPLEADOS LISTADO TODOS EMPLEADOS, USER OBTENER UN SOLO EMPLEADO.
	/*ROUTE -> site/get_employees */

	public function getEmployees(){

		if(empty($_GET['user'])){

			$employees = User::whereHas('roles', function ($query) {
		            $query->where('name', '=', 'employee');
		 	})->get();

		 	return $employees;

		} else {
			$employees = User::findOrFail($_GET['user']);

		 	return $employees;
		}
	}

	//LISTADO TODOS CLIENTES
	/*ROUTE -> site/get_clients */

	public function getClients(){

		if(empty($_GET['user'])){

			$clients = User::whereHas('roles', function ($query) {
		            $query->where('name', '=', 'user');
		 	})->get();

		 	return $clients;

		}
	}
	// LISTADO CON CLIENTES QUE TIENEN DEUDAS DE PRODUCTOS
	/*ROUTE -> site/get_clients_with_debt */
	public function getClientsWithDebt(){

		if(empty($_GET['user'])){
			$sales_by_user = SalesByUser::with('sales')->with('user')->where('status', 'Activo')->groupBy('user_id')->get();
			return $sales_by_user;
		} else {
			$sales_by_user = SalesByUser::with('sales')->with('user')->where('status', 'Activo')->where('user_id', $_GET['user'])->get();

			foreach ($sales_by_user as $keyvalue) {
				$sales_detail = SalesDetail::with('products')->where('sales_id', $keyvalue->sales_id)->get();
				$keyvalue->sales->detail = $sales_detail;
			}

			return $sales_by_user;

		}

	}

	//Store employees
	/*ROUTE -> site/store_user */
	function storeUsers(Request $request){

		if (!empty($request->name) /*completar*/) {
		
			$user = new User;
			$user->name = $request->name;
			$user->last_name = $request->last_name;
			$user->document = $request->document;
			$user->phone_number = $request->phone_number;
			$user->address = $request->address;
			$user->autorizado = true;
			$user->email = $request->email;
			//El primer password es su apellido + el número de documento
			$user->password = bcrypt($user->last_name . $user->document);
			$user->genre = $request->genre;
			$user->birthdate = date('Y-m-d', strtotime($request->birthdate));
			if(!empty($request->medical_certificate)){
				$user->medical_certificate = $request->medical_certificate;
			}

			if(!empty($request->expiration_date)){
				$user->expiration_date = $request->expiration_date; 
			}

	        if($request->file('file')) {
	            $image = $request->file('file');
	            $imageName = $request->file('file')->getClientOriginalName();
	            $path_t = public_path('storage/profile/thumb_' . $imageName);
	            $path = public_path('storage/profile/' . $imageName);
	            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
	            Img::make($image->getRealPath())->save($path);
	            $user->image = $imageName;
	        }
			$user->save();

		/*Rol puede ser "employee" o "user" */
		if(!empty($request->role)){

			$role = Role::findOrFail($request->role);

		}

        $user->attachRole($role);

	        
		$user->save();

	        return $user;
		}

	}

	/*Generar ventas de productos*/
	/*Route site/store_sales_receptions */
    public function storeSalesReceptions(Request $request)
    {

    	//PSD Es un array de todos los productos
    	//uid_user Si haces la búsqueda por ID, este es el cliente al que se le va a agregar la deuda.

    	//Hacer la comprobación de empty values product id, quantity, subtotal, user y total.
    	$response = array();
        $sales = new Sales;
        $sales->user_id = $request->user; //user id
        $sales->total = $request->total;
        $sales->save();

        if(!empty($request->psd)){
            
            $saved = SalesDetail::where('sales_id', $sales->id)->delete();

            foreach ($request->psd as $keyvalue) {


                $data = $keyvalue; //No es necesario hacer el explode si en el AJAX enviamos el array
                $sales_details = new SalesDetail;
                $sales_details->sales_id = $sales->id;
                $sales_details->products_id = $data['products_id'];
                $sales_details->quantity = $data['quantity'];
                $sales_details->sub_total = $data['sub_total'];
                $sales_details->save();

                $response['sales_details'] = $sales_details;

                $products = Product::find($sales_details->products_id);
                $products->stock_actual = $products->stock_actual-$sales_details->quantity;
                $products->save();

            }
        }

        if(!empty($request->uid_user)){

            $sales_by_user = new SalesByUser;
            $sales_by_user->user_id = $request->uid_user;
            $sales_by_user->sales_id = $sales->id;
            $sales_by_user->status = 'Activo';
            $sales_by_user->save();

            $response['sales_by_user'] = $sales_by_user;


        }

        $response['sales'] = $sales;

       	return $response;

    }

    /*Get Clients by DNI */
    /*Route: site/find_user_by_id */
    function findUserById(Request $request){

		$document = $_GET['document'];
		$user = User::where('document', $document)->first();

        return $user;
	}

	/*Update Product's Stock*/
	/*Route: site/update_products_stock */
	//Recibir mercancia
	
	public function updateProductStock(Request $request)
    {

        $products = Product::findOrFail($request->id);
        $products->name = $request->name;
        $products->cost = $request->cost;
        $products->stock_inicial = $request->stock_inicial;
        $products->stock_actual = $request->stock_inicial;
        $products->status = $request->status;
        $products->save();

        return $products;

    }

    /*Listar todos los productos que están disponibles*/
    /*Route: site/list_products_available*/

   public function listProductsAvailable()
   {
   	 $products = Product::where('status', 'Activo')->get();

   	 return $products;
   }

    //Hacer un depósito
    //Route site/store_deposit
    public function storeDeposit(Request $request)
    {

        $cash_deposits = new CashDeposit;
        $cash_deposits->responsable_user_id = $request->user;
        $cash_deposits->amount = $request->amount;
        $cash_deposits->deposit_number = $request->deposit_number;
        $cash_deposits->status = 'Activo';
        $cash_deposits->save();

        return $cash_deposits;
    }

    /*Listar todas las canchas*/
    //Route: site/list_all_fields
    public function listAllFields()
    {
    	$fields = Classroom::where('type', 'Cancha')->get();
    	return $fields;
    }

    /*Mostrar una cancha por ID*/
    //Route: site/show_field
    public function showFields()
    {

        $fields = Classroom::find($_GET['id']);

        return $fields;
    }

    /*Registrar una Cancha*/
    //Route: site/store_field
    public function storeField(Request $request)
    {

        $field = new Classroom;

        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = $request->file('file')->getClientOriginalName();
            $path_t = public_path('storage/thumb_' . $imageName);
            $path = public_path('storage/' . $imageName);
            Img::make($image->getRealPath())->resize(240,200)->save($path_t);
            Img::make($image->getRealPath())->save($path);
            $field->image = $imageName;
        }

        $field->name = $request->name;
        $field->observation = $request->observation;
        $field->m2 = $request->m2;
        $field->status = "Activo";
        $field->type = "Cancha";
        $field->save();

        return $field;

    }

    /*Reserva de Canchas*/
    /*Route: site/reserve_fields*/
    public function reserveFields(Request $request)
    {

    	$response = array();

    	$reserve = new Reservation;
    	$reserve->date = date('Y-m-d', strtotime($request->date));
    	$reserve->hour = $request->hour;
    	$reserve->field_id = $request->field;
    	$reserve->name = $request->name;
    	$reserve->email = $request->email;
    	$reserve->phone_number = $request->phone_number;
    	$reserve->status = "Activo";
    	$reserve->amount = $request->amount;
    	$reserve->amount_type = $request->amount_type;
    	$reserve->save();

    	$response['reserva'] = $reserve;

    	//Check if client is registered
    	$client = User::find($request->client_user_id);

        $cash_transactions = new CashTransaction;
        $cash_transactions->responsable_user_id = $request->responsable_user_id;
        if(!empty($client)){
			$cash_transactions->client_user_id = $request->client_user_id;
        }
        $cash_transactions->type_cash_transactions_id = $request->type_cash_transactions_id;
        $cash_transactions->amount = $request->amount;
        $cash_transactions->meta = 'Reservación';
        $cash_transactions->meta_id = $reserve->id;
        if($reserve->amount_type == 'P'){
			$cash_transactions->description = "Pago parcial";
        }else{
			$cash_transactions->description = "Pago completo";
        }
        
        $cash_transactions->status = 'Activo';
        $cash_transactions->save();

        $response['pago'] = $cash_transactions;

    	return $response;
    }

    /*Ver todas las reservaciones de Canchas*/
    /*Route: site/view_all_reservations*/
    public function viewAllReservations()
    {
    	$reserve = Reservation::all();

    	return $reserve;
    }

    /*Ver todas las reservaciones de Canchas*/
    /*Route: site/view_reservations_by_id_field*/
    public function viewReservationsByIdField(Request $request)
    {
    	$reserve = Reservation::where('id', $_GET['id'])->first();

    	return $reserve;
    }

    /*Cancelar reservación*/
	/*Route: site/cancel_reservation */
	
	public function cancelReservation(Request $request)
    {

        $reserve = Reservation::findOrFail($request->id);
        $reserve->observation = $request->observation;
        $reserve->status = "Inactivo";
        $reserve->save();
		
		$date1 = date('Y-m-d');
		$date2 = $reserve->date;
        
        if ($request->observation == 'Lluvia') {
        	//Retornar el dinero
        }else{
        	//No retornar el dinero
        }

        return $reserve;

    }

    /*Registrar un plan*/
    /*Route: site/create_plan*/

    public function createPlan(Request $request)
    {
        $plan = new Plans;
        $plan->title = $request->title;
        $plan->description = $request->description;
        $plan->amount = $request->amount;
        $plan->status = $request->status;
        $plan->save();

        return $plan;
    }

    /*Listar planes*/
    /*Route: site/list_plans*/

    public function listPlan()
    {
        $plan = Plans::all();

        return $plan;
    }

    /*Comprar un plan*/
    /*Route: site/buy_plans*/
    public function buyPlans(Request $request)
    {
        $cash_transactions = new CashTransaction;
        $cash_transactions->responsable_user_id = $request->responsable_user_id;
        $cash_transactions->client_user_id = $request->client_user_id;
        $cash_transactions->type_cash_transactions_id = $request->type_cash_transactions_id;
        $cash_transactions->amount = $request->amount;
        $cash_transactions->meta = 'Plan';
        $cash_transactions->meta_id = $request->plan_id;
        $cash_transactions->description = $request->description;        
        $cash_transactions->status = 'Activo';
        $cash_transactions->save();

        

        return $cash_transactions;
    }

    /*Pago de profesores por clases*/
    /*Route: site/tutor_payments_by_classes */

    public function tutorPaymentsByClasses(Request $request)
    {

        $response = array();
        $user_id = $request->user_id;
        $class_id = $request->class_id;
        $activity_id = $request->activity_id;


        $activity = ActivityByTutor::where('user_id', $user_id)->where('activity_id', $activity_id)->first();
        $classes = ClassDaySchedule::where('class_id', $class_id)->first();

        $amount_to_pay = ($activity->percentage_gain * $classes->value) / 100;

        $payment = new PaidTutors;
        $payment->tutor_user_id = $user_id;
        $payment->responsable_user_id = $request->responsable_user_id;
        $payment->amount = $amount_to_pay; 
        $payment->status = 'Activo';
        $payment->save();

        $response['payment'] = $payment;

        $cash_transactions = new CashTransaction;
        $cash_transactions->responsable_user_id = $request->responsable_user_id;
        $cash_transactions->client_user_id = $request->user_id;
        $cash_transactions->type_cash_transactions_id = $request->type_cash_transactions_id; //2
        $cash_transactions->amount = $payment->amount;
        $cash_transactions->meta = 'Pago a profesor';
        $cash_transactions->meta_id = $payment->id;
        $cash_transactions->description = $request->description;        
        $cash_transactions->status = 'Activo';
        $cash_transactions->save();

        $response['cash_transactions'] = $cash_transactions;        

        return $response;
    }


 }
