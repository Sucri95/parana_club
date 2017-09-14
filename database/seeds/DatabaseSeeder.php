<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

   private function initialActivities(){
        $this->activities = array(
            array('name'=>'Crossfit', 'description'=>'es una modalidad de entrenamiento que se realiza en las fuerzas militares de Estados Unidos y consiste en un trabajo de alta intensidad en poco tiempo.', 'image'=>'r1.jpg', 'm2'=>'3', 'status'=>'Activo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('name'=>'Bikram yoga', 'description'=>'también conocido como "Hot yoga". Es una variante del yoga que se realiza a una temperatura ambiente de 42ºC con una humedad del 60 por ciento', 'image'=>'5DDKSXYCJRHFNJRIK2GZYJSQTE.jpg', 'm2'=>'2', 'status'=>'Activo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('name'=>'Fitness boot camp', 'description'=>'es una forma de entrenamiento intensivo realizado al aire libre', 'image'=>'SKFPDRTKWNGCJJPCPI2FWDJONA.jpg', 'm2'=>'2', 'status'=>'Activo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            array('name'=>'Zumba fitness', 'description'=>'fusiona fitness y baile y utiliza un estilo libre coreografiado como método de enseñanza.', 'image'=>'C2757G74UZASZAEL2KXZWJSIW4.jpg', 'm2'=>'3', 'status'=>'Activo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            );
    }


    private function initialClassrooms(){

        $this->classrooms = array(
                array('name'=>'Sala Sol ', 'observation'=>'En es el mas chico', 'm2'=>'38', 'image'=> 'images (1).jpg', 'status'=>'Activo',  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
                array('name'=>'Sala luna', 'observation'=>'es la mas amplia', 'm2'=>'42', 'image'=> 'C2757G74UZASZAEL2KXZWJSIW4.jpg', 'status'=>'Activo',  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
                array('name'=>'Sala con equipos', 'observation'=>'Tiene equipos', 'm2'=>'40', 'image'=> 'images.jpg', 'status'=>'Activo',  'created_at' => Carbon::now(), 'updated_at' => Carbon::now()),
            );

    }

    private function initialDays() {
        $this->days = array(
            array('name'=>'Lunes'),
            array('name'=>'Martes'),
            array('name'=>'Miércoles'),
            array('name'=>'Jueves'),
            array('name'=>'Viernes'),
            array('name'=>'Sábado'),
            array('name'=>'Domingo'),
            array('name'=>'Todos'),

        );
    }


    private function initialTypeCashTransactions() {
        $this->types = array(
            array('name'=>'ingresos', 'description'=>'Todos los ingresos', 'status'=>'Activo'),
            array('name'=>'egresos', 'description'=>'Todos los egresos', 'status'=>'Activo'),
            array('name'=>'depositos', 'description'=>'Todos los depositos', 'status'=>'Activo'),
            array('name'=>'cierres', 'description'=>'Todos los cierres', 'status'=>'Activo'),
        );
    }


    private function initialSchedules() {
        $this->schedules = array(
            array('description'=>'06:00'),
            array('description'=>'06:30'),
            array('description'=>'07:00'),
            array('description'=>'07:30'),
            array('description'=>'08:00'),
            array('description'=>'08:30'),
            array('description'=>'09:00'),
            array('description'=>'09:30'),
            array('description'=>'10:00'),
            array('description'=>'10:30'),
            array('description'=>'11:00'),
            array('description'=>'11:30'),
            array('description'=>'12:00'),
            array('description'=>'12:30'),
            array('description'=>'13:00'),
            array('description'=>'13:30'),
            array('description'=>'14:00'),
            array('description'=>"14:30"),
            array('description'=>"15:00"),
            array('description'=>"15:30"),
            array('description'=>"16:00"),
            array('description'=>"16:30"),
            array('description'=>"17:00"),
            array('description'=>"17:30"),
            array('description'=>"18:00"),
            array('description'=>"18:30"),
            array('description'=>"19:00"),
            array('description'=>"19:30"),
            array('description'=>"20:00"),
            array('description'=>"20:30"),
            array('description'=>"21:00"),
            array('description'=>"21:30"),
            array('description'=>"22:00"),
            array('description'=>"22:30"),
            array('description'=>"23:00"),
            array('description'=>"23:30"),
        );
    }

    public function run()
    {

        DB::table('roles')->insert([
            'name' => 'admin',
            'display_name' => 'Administrador',
            'description' => 'Todos los permisos para administrar desde la web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'user',
            'display_name' => 'Usuario',
            'description' => 'Acceso unicamente a opciones específicas desde la app.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'employee',
            'display_name' => 'Empleado',
            'description' => 'Permisos para realizar tareas de empleado.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'tutor',
            'display_name' => 'Tutor/Profesor',
            'description' => 'Permisos para realizar tareas de tutor/profesor.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'last_name' => 'Admin',
            'document' => '12345678',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
            'autorizado' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);


        $this->initialDays();
        foreach ($this->days as $day)
            DB::table('days')->insert($day);

        $this->initialSchedules();
        foreach ($this->schedules as $schedule)
            DB::table('schedules')->insert($schedule);


        $this->initialActivities();
        foreach ($this->activities as $activity)
            DB::table('activities')->insert($activity);

        $this->initialClassrooms();
        foreach ($this->classrooms as $classroom)
            DB::table('classrooms')->insert($classroom);

        $this->initialTypeCashTransactions();
        foreach ($this->types as $type)
            DB::table('type_cash_transactions')->insert($type);
    }
}
