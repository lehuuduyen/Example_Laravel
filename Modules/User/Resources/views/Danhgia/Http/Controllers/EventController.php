<?php

namespace Modules\Danhgia\Http\Controllers;

use App\Api\V1\Controllers\BaseController;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Danhgia\Entities\Event;
use Modules\Danhgia\Entities\EventDetailProcess;
use Modules\Danhgia\Entities\EventDetailRegisty;
use Modules\Department\Http\Controllers\DepartmentController;
use Modules\Employee\Http\Controllers\EmployeeController;
use Yajra\DataTables\DataTables;

class EventController extends BaseController
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //nhom
        $group_question = new GroupQuestionController();
        $group_question = $group_question->get_all();
        //phong
        $department = new DepartmentController();
        $department = $department->get_all();
        //user
        $employment = new EmployeeController();
        $employment = $employment->get_all();

        return view('danhgia::event.list', compact('group_question', 'department', 'employment'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('danhgia::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */


    /**
     * Show the specified resource.
     * @return Response
     */
    public function view_detail()
    {
        return view('danhgia::event.detail');
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        //        Event

        try {
            $event             = new Event();
            $event->description=$request->name;
            $event->qroup_question_id=$request->Gquestion;
            $event->user_id=$request->user_id;
            $event->save();
        } catch (\Exception $e) {
            \DB::rollBack();

            return $this->response->errorInternal($e->getMessage());
        }
        //        Event

        //        EventDetailRegisty


        try {
            if(count($request->department)>0){
                foreach ($request->department as $value){
                    $Event_detail      = new EventDetailRegisty();
                    $Event_detail->department_id       =$value ;
                    $Event_detail->event_id     = $event->id;
                    $Event_detail->save();


                    $employee    = new EmployeeController();
                    $employee=$employee->get_all_by_department($value);

                    foreach ($employee as $values){
                        $EventDetailProcess    = new EventDetailProcess();
                        $EventDetailProcess->user_id_receiver       =$values->id ;
                        $EventDetailProcess->count_send     = 0;
                        $EventDetailProcess->status     = 1;
                        $EventDetailProcess->event_id     = $event->id;
                        $EventDetailProcess->code     = $this->generateRandomString();
                        $EventDetailProcess->department_id     = $value;
                        $EventDetailProcess->save();
                    }

                }
            }

        } catch (\Exception $e) {
            \DB::rollBack();

            return $this->response->errorInternal($e->getMessage());
        }



        try {
            if(count($request->nhanvien)>0){
                foreach ($request->nhanvien as $value){
                    $Event_detail      = new EventDetailRegisty();
                    $Event_detail->user_id_receiver       =$value ;
                    $Event_detail->event_id     = $event->id;
                    $Event_detail->save();

                    //EventDetailProcess
                    $EventDetailProcess    = new EventDetailProcess();
                    $EventDetailProcess->user_id_receiver       =$value ;
                    $EventDetailProcess->count_send     = 0;
                    $EventDetailProcess->status     = 1;
                    $EventDetailProcess->event_id     = $event->id;
                    $EventDetailProcess->code     = $this->generateRandomString() ;
                    $EventDetailProcess->department_id     = 0;

                    $EventDetailProcess->save();



                }
            }

        } catch (\Exception $e) {
            \DB::rollBack();
            return $this->response->errorInternal($e->getMessage());
        }

        //        EventDetailRegisty





        \DB::commit();


        return $this->responseCreated($request);
//
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $event= DB::table('event')
            ->join('group_question','group_question.id','event.qroup_question_id')
            ->where('event.id',$id)
            ->select('event.description','event.id','group_question.name')
            ->get();

        return $event;
    }

    public function update(CreateQuestionRequest $request,$id )
    {
        $row=Question::find($id);
        if (!$row) {
            return $this->responseBad("ID not exist");
        }
        $data = '';
        $arr = [];
        if($request->type==3) {
            $arrData = explode(',', $request->data);
            if (count($arrData) > 1) {
                foreach ($arrData as $val) {
                    list($key, $val) = explode(':', $val);
                    $arr[] = array($key => $val);
                }
                $data = json_encode($arr);
            }
            else{
                return $this->responseServerError('bạn phải nhập đáp án');
            }
        }

        $dataInsert = $request->data_only();
        $dataInsert['data'] = $data;
        $question = Question::find($id)->update($dataInsert);
        return $this->responseCreated($question);
//

    }
    public function anyData(){
        $data     =DB::table("event")->join('group_question','event.qroup_question_id','group_question.id')->
            select('event.*','group_question.name')->get();
//            ->with('user');
        $dbResult = DataTables::of($data)
            ->addColumn('action', function ($data) {
                $action = '<a href="http://danhgia.dev-altamedia.com/danhgia/event/view_detail/'.$data->id.'" class="btn btn-xs btn-success" title="Chi tiết"><i class="fa fa-eye"></i></a> &nbsp;';
                $action .= '<a href="javascript:setUpdate('.$data->id.')" class="btn btn-xs btn-primary" title="Chỉnh sửa"><i class="fa fa-edit"></i></a> &nbsp;';
                $action .= '<a href="javascript:setDelete('.$data->id.')" class="btn btn-xs btn-danger" title="Xóa"><i class="fa fa-times"></i> </a> &nbsp;';

                return $action;
            })


            ->make(TRUE);

        return $dbResult;
    }
    public function delete($id)
    {
        $data= new Event();
        $data->destroy($id);
        return parent::responseDeleted($data); // TODO: Change the autogenerated stub
    }
    public function generateRandomString($length =100) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public function anyData_detail(Request $request,$id){
        $data     =DB::table("event_detail_process")
            ->join('user_details','user_details.id','event_detail_process.user_id_receiver')
            ->join('event','event.id','event_detail_process.event_id')
            ->where('event_detail_process.event_id',$id);
        if(count($request->data)>0){
            $arr=[];
            $all='';
            foreach($request->data as $value){
              if($value=='one')
              {
                  $arr[]=0;
              }
              elseif ($value==''){
                $all='co';
              }
              else{
                  $arr[]=$value;
              }
            }
            if($all!="co"){
                $data=$data->whereIn('event_detail_process.department_id',$arr);
            }




        }
//        $data = $data->whereIn('event_detail_process.department_id',[1,null]);




//
        $data= $data->select('event_detail_process.*','user_details.full_name as name','event.description')->get();
//            ->with('user');
        $dbResult = DataTables::of($data)
            ->addColumn('action', function ($data) {
                if($data->status==3){
                    $action='';
                }
                else{
                    $action = '<a href="http://danhgia.dev-altamedia.com/danhgia/reply/show/'.$data->code.'" onclick="myFunction('.$data->id.')" class="btn btn-xs btn-success" title="Chi tiết"><i class="fa fa-eye"></i></a> &nbsp;';

                }

                return $action;
            })
            ->editColumn('status', function($data) {
                if($data->status==1){
                    return "<span  class=\"btn btn-xs label-info pull-center\">Đang xử lý</span>";
                }
                elseif($data->status==2){
                    return "<span class=\"btn btn-xs label-warning pull-center\">Đã gửi link</span>";
                }
                else{
                    return "<span  class=\"btn btn-xs label-success pull-center\">Đã đánh giá</span>";

                }
            })

            ->rawColumns(['status','action'])

            ->make(TRUE);

        return $dbResult;
    }


    public function get_department($id)
    {
        $data= DB::table('departments')
            ->join('event_detail_process','departments.id','event_detail_process.department_id')
            ->where('event_detail_process.event_id',$id)
            ->select('departments.name','departments.id')
            ->groupBy('departments.id')
            ->groupBy('departments.name')
            ->get() ;
        $data1= DB::table('event_detail_process')
            ->where('event_detail_process.event_id',$id)
            ->where('event_detail_process.department_id',0)
            ->get() ;
        if(count($data1)>0)
        {
            $data1="Danh sách nhân viên kèm theo";
        }

        return response()->json([
            'department'=>$data,
            'nhanvien'=>$data1,
        ]) ; // TODO: Change the autogenerated stub
    }


    public function update_count($id){
        $data=EventDetailProcess::find($id);
        $data->count_send=$data->count_send+1;
        $data->status=2;
        $data->save();

    }
















}

