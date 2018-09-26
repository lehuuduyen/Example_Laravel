<?php

    namespace Modules\Employee\Http\Controllers;


    use App\Http\Controllers\BaseController;
    use Modules\Employee\Http\Requests\CreateEmployeeRequest;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\DB;
    use Modules\Employee\Entities\Employment;
    use Modules\Employee\Entities\Position;
    use Modules\Employee\Http\Requests\UpdateEmploymentRequest;
    use Modules\Profile\Entities\Profile;
    use Modules\User\Entities\ModelRole;
    use Modules\User\Entities\Role;
    use Modules\User\Entities\User;
    use Modules\User\Http\Controllers\SignUpController;
    use Yajra\DataTables\DataTables;

    class EmployeeController extends BaseController
    {
        /**
         * Display a listing of the resource.
         * @return Response
         */
        protected $_currentRoute;

        public function __construct(){
            $this->_currentRoute = \Route::currentRouteName();
            view()->share('currentRoute',  $this->_currentRoute);
        }
        public function index()
        {
            return view('employee::employment.index');
        }

        public function create()
        {

            return view("employee::employment.add");
        }

        public function show($id)
        {
            $user = User::find($id);
            if (!$user) {
                return $this->responseNoContent();
            }
            $userDetail = Employment::where('user_id', $user->id)
                                    ->first();
            if (!$userDetail) {
                return $this->responseBad("User detail not exist");
            }
            $role=ModelRole::where('model_id',$id)->pluck('role_id')->toArray();
            return $this->responseSuccess([
                'user'       => $user,
                'Employment' => $userDetail,
                'role' => $role
            ]);
        }

        /**
         * Get gender for data add and edit
         *
         * @return mixed
         */
        public function gender()
        {
            return $this->responseSuccess([
                [
                    'id'   => User::$TYPE_GENDER_FEMALE,
                    'name' => 'Nữ'
                ],
                [
                    'id'   => User::$TYPE_GENDER_MALE,
                    'name' => 'Nam'
                ],
                [
                    'id'   => User::$TYPE_GENDER_OTHER,
                    'name' => 'Khác'
                ]
            ]);
        }

        //
        public function type()
        {
            return $this->responseSuccess([
                [
                    'id'   => User::$TYPE_WORK_FULL_TIME,
                    'name' => 'Nhân viên chính thức'
                ],
                [
                    'id'   => User::$TYPE_WORK_PART_TIME,
                    'name' => 'Bán thời gian'
                ]
            ]);
        }

        public function position()
        {
            $position = Position::all();
            if (!$position) {
                return $this->responseNoContent();
            }

            return $this->responseSuccess($position);
        }

        public function store(CreateEmployeeRequest $request)
        {
            $employee          = Employment::create($request->dataOnly());
            $array['email']    = $request->email;
            $array['name']     = $request->full_name;
            $array['password'] = $request->password;
            $user              = new SignUpController();
            $data              = $user->signUp_user($array);
            $employee->user_id = $data;
            $employee->save();
            if($request->permission){
                foreach ($request->permission as $value){

                    ModelRole::create([
                        'role_id'=>$value,
                        'model_id'=>$data,
                        'model_type'=>'App\User',
                    ]);

                }
            }

            return $this->responseSuccess($employee);
        }

        public function update($id, UpdateEmploymentRequest $request)
        {
            $userDetail = Employment::where('id', $id)
                                    ->first();
            if (!$userDetail) {
                return $this->responseServerError("Id Employee detail not exist");
            }
            $data=$request->dataOnly();
            if(!isset($data['is_email'])){
                $data['is_email']=0;
            }
            $employee          = Employment::find($id)
                ->update($data);
            User::find($userDetail->user_id)->update([
                'name'=>$request->full_name]);
            if($request->password!=null){
                User::find($userDetail->user_id)->update([
                    'password'=>$request->password]);
            }
            ModelRole::where('model_id',$id)->delete();
            if($request->permission) {

                foreach ($request->permission as $value) {
                    $data = ModelRole::create([
                        'role_id' => $value,
                        'model_id' => $id,
                        'model_type' => 'App\User',
                    ]);

                }
            }

        }

        public function anyData(Request $request)
        {
            $data = Employment::select();
            //            ->with('user');
            $dbResult = DataTables::of($data)

                                  ->addColumn('action', function ($dat) {
                                      $actual_link =$_SERVER['HTTP_HOST'];
                                      $action = '';
                                      $action .= '<a href="employee/create?id=' . $dat->id . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a> &nbsp;  ';
                                      $action .= '<a href="javascript:setDelete(' . $dat->id . ');" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Delete</a>';

                                      return $action;
                                  })
                ->addColumn('permission', function ($dat) {


                    $all_permission = ModelRole::where('model_id', $dat->user_id)
                        ->get();

                    $permission = [];

                    foreach ($all_permission as $value) {
                        $detail = Role::where('id', $value->role_id)
                            ->first();
                        if (count($detail) != 0) {
                            $permission[] = $detail->name;
                        }
                    }

                    return $permission;
                })
                                  ->rawColumns([
                                      'action',

                                  ])
                                  ->make(TRUE);

            return $dbResult;
        }

        public function get_all()
        {
            return Employment::all()
                             ->pluck('full_name', 'id')
                             ->toArray();
        }

        public function get_all_by_department($id)
        {
            return DB::table('user_details')
                     ->where('department_id', $id)
                     ->get();
        }

        public function get_all_by_id($id)
        {
            return DB::table('user_details')
                     ->where('department_id', $id)
                     ->get();
        }

        public static function get_id($id)
        {
            return Employment::find($id);
        }

        public static function update_id($data_update)
        {
            $update = User::where($data_update['id']);
            //echo "<pre>"; print_r($update);die;
            $update->full_name = $data_update['full_name'];
            $update->phone     = $data_update['phone'];
            $update->email     = $data_update['email'];
            $update->user_id   = $data_update['user_id'];
            $update->save();
        }

        public function delete($id)
        {
            $data =Employment::find($id);
            $user =User::destroy($data->user_id);
            $data->destroy($id);


            return parent::responseDeleted($data); // TODO: Change the autogenerated stub
        }
    }
