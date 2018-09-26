<?php

namespace Modules\Danhgia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Danhgia\Entities\Event;
use Modules\Danhgia\Entities\EventDetailProcess;
use Modules\Danhgia\Entities\EventDetailReply;
use Yajra\DataTables\DataTables;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $events= Event::all();
        return view('danhgia::statistic.list',[
            'events' => $events,
        ]);
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
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('danhgia::show');
    }
    public function view_detail($id,$user_id)
    {
        $reply=EventDetailReply::where('event_id',$id)
            ->where('user_id',$user_id)->orderBy('question_id','ASC')->get();

      


//        return view('danhgia::statistic.detail');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('danhgia::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }


    public function get_department($id)
    {
        $data = DB::table('departments')
            ->join('event_detail_process', 'departments.id', 'event_detail_process.department_id')
            ->where('event_detail_process.event_id', $id)
            ->select('departments.name', 'departments.id')
            ->groupBy('departments.id')
            ->groupBy('departments.name')
            ->get();
        $data1 = DB::table('event_detail_process')
            ->where('event_detail_process.event_id', $id)
            ->where('event_detail_process.department_id', 0)
            ->get();
        if (count($data1) > 0) {
            $data1 = "Danh sách nhân viên kèm theo";
        }

        return response()->json([
            'department' => $data,
            'nhanvien' => $data1,
        ]); // TODO: Change the autogenerated stub
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
                $action = '<a href="http://danhgia.dev-altamedia.com/danhgia/statistic/view_detail/'.$data->event_id.'/'.$data->user_id_receiver.'" onclick="myFunction('.$data->id.')" class="btn btn-xs btn-success" title="Chi tiết"><i class="fa fa-eye"></i></a> &nbsp;';

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

    public function sum(){
            $event= Event::all();
        foreach ($event as $val) {
            $event_detail_process= EventDetailProcess::where('event_id',$val['id'])->get();
//            return $event_detail_process;
            foreach ($event_detail_process as $value){
                $event_detail_reply= EventDetailReply::where('user_id',$value['user_id_receiver'])
                    ->where('event_id',$value['event_id'])
                    ->get();
                $tong=0;

                foreach($event_detail_reply as $value1){
                    $tong+=$value1['data'];
                }
                $sum_save=EventDetailProcess::find($value['id']);
                if($sum_save->number !=0 && $sum_save->number_question!=0){
                    $trungbinh=($tong)/($sum_save->number *$sum_save->number_question);
                    $sum_save->sum=($tong)/($sum_save->number *$sum_save->number_question);
                    $sum_save->save();
                }

            }

        }


    }
}