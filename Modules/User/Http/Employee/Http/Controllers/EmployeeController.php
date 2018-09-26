<?php

namespace Modules\Employee\Http\Controllers;

use App\Api\V1\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Employee\Entities\Employment;
use Modules\Employee\Entities\Position;
use Modules\User\Entities\User;
use Yajra\DataTables\DataTables;

class EmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('employee::employment.index');
    }
    public function create(){
        return view( "employee::employment.add" );
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

        return $this->responseSuccess([
            'user'       => $user,
            'Employment' => $userDetail
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
    public function store(Request $request)
    {
            $userDetail                = new Employment();
            $userDetail->email         = $request->email;
            $userDetail->full_name     = $request->full_name;
            $userDetail->gender        = $request->gender;
            $userDetail->department_id = $request->department_id;
            $userDetail->phone         = $request->phone;
            $userDetail->type          = $request->type;
            $userDetail->position_id   = $request->position_id;
            $userDetail->job_title     = $request->job_title;
            $userDetail->save();
        return $this->responseCreated($userDetail);
    }

    public function update($id, UpdateEmploymentRequest $request)
    {
        $userDetail = Employment::where('user_id', $id)
            ->first();
        if (!$userDetail) {
            return $this->responseServerError("ID user detail not exist");
        }

        //Personal
        if ($request->action == 'personal') {
            $userDetail->birth_place       = $request->birth_place;
            $userDetail->origin_place      = $request->origin_place;
            $userDetail->ethnic_group      = $request->ethnic_group;
            $userDetail->religious         = $request->religious;
            $userDetail->normal_address    = $request->normal_address;
            $userDetail->temporary_address = $request->temporary_address;
            if (!empty($request->dob)) {
                $userDetail->dob = $request->dob;
            }

        }
        //Contact
        if ($request->action == 'contact') {
            $userDetail->tax_number            = $request->tax_number;
            $userDetail->social_number         = $request->social_number;
            $userDetail->social_number_address = $request->social_number_address;
            if (!empty($request->social_date_create)) {
                $userDetail->social_date_create = $request->social_date_create;
            }

        }
        //Technique
        if ($request->action == 'technique') {
            $userDetail->foreign_language = $request->foreign_language;
            $userDetail->computer         = $request->computer;
            $userDetail->education_level  = $request->education_level;
            $userDetail->academic_level   = $request->academic_level;
            $userDetail->professional     = $request->professional;
        }
        //Health
        if ($request->action == 'health') {
            $userDetail->ensurance_number = $request->ensurance_number;
            if (!empty($request->ensurance_date_create)) {
                $userDetail->ensurance_date_create = $request->ensurance_date_create;
            }
            $userDetail->ensurance_address  = $request->ensurance_address;
            $userDetail->ensurance_hospital = $request->ensurance_hospital;
            $userDetail->health             = $request->health;
            $userDetail->weight             = $request->weight;
            $userDetail->height             = $request->height;
        }
        try {
            $userDetail->save();
        } catch (\Exception $e) {
            \DB::rollBack();

            return $this->responseBad($e->getMessage());
        }


        return $this->responseSuccess();

    }

    public function anyData(Request $request)
    {
        $data     = Employment::select()
            ->with('position')->orderBy('id','DESC');
//            ->with('user');
        $dbResult = DataTables::of($data)

            ->addColumn('type_name', function ($dat) {
                $str = '';
                if ($dat->type == User::$TYPE_WORK_FULL_TIME) {
                    $str = 'Nhân Viên Chính Thức';
                }
                if ($dat->type == User::$TYPE_WORK_PART_TIME) {
                    $str = 'Cộng tác viên';
                }

                return $str;
            })
            ->addColumn('action', function ($dat) {
                $action='';
                if($dat->user_id==null){
                    $action =  '<a href="http://danhgia.dev-altamedia.com/user/employment/'.$dat->id.'" class="btn btn-xs btn-warning" title="Thêm tài khoản"><i class="fa fa-edit"></i></a> &nbsp;';
                }
                else{
                    $action =  '<a href="http://danhgia.dev-altamedia.com/user/employment/'.$dat->id.'" class="btn btn-xs btn-default" title="Xửa tài khoản"><i class="fa fa-edit"></i></a> &nbsp;';
                }
                $action .=  '<a href="http://danhgia.dev-altamedia.com/user/employment/'.$dat->id.'" class="btn btn-xs btn-success" title="Chi tiết"><i class="fa fa-eye"></i></a> &nbsp;';
                $action .=  '<a href="javascript:setUpdate('.$dat->id.');" class="btn btn-xs btn-primary" title="Chỉnh sửa"><i class="fa fa-edit"></i></a> &nbsp;';
                $action .=  '<a href="javascript:setDelete('.$dat->id.');" class="btn btn-xs btn-danger" title="Xóa"><i class="fa fa-times"></i> </a> &nbsp;';

                return $action;
            })
            ->make(TRUE);

        return $dbResult;
    }
    public function get_all(){
        return Employment::all()->pluck('full_name','id')->toArray();
    }
    public function get_all_by_department($id){
        return DB::table('user_details')->where('department_id',$id)->get();
    }
    public static function get_id($id){
        return Employment::find($id);
    }
    public static function update_id(Request $request,$id){
        $employ=Employment::find($id);
        $employ->user_id=$request->user_id;
        $employ->save();
    }
    public function delete($id)
    {
        $data= new Employment();
        $data->destroy($id);
        return parent::responseDeleted($data); // TODO: Change the autogenerated stub
    }
}
