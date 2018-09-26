<?php

    namespace Modules\Danhgia\Http\Controllers;

    use App\Api\V1\Controllers\BaseController;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\DB;
    use Modules\Danhgia\Entities\Event;
    use Modules\Danhgia\Entities\event_detail_reply;
    use Modules\Danhgia\Entities\EventDetailProcess;
    use Modules\Danhgia\Entities\EventDetailReply;
    use Modules\Danhgia\Entities\GroupQuestion;
    use Modules\Danhgia\Entities\Question;
    use Modules\Department\Entities\Department;
    use Modules\Employee\Entities\Employment;

    class ReplyController extends BaseController
    {
        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index()
        {
            return view('danhgia::index');
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
            $request=$request->all();

            \DB::beginTransaction();
            try {
                foreach ($request['data'] as $val) {

                    $EventDetailProcess=EventDetailProcess::where('event_id',$request['event'])->where('user_id_receiver',$val['userID'])->first();
                    $number=$EventDetailProcess->number;
                    $EventDetailProcess->number= $number+1;
                    $EventDetailProcess->save();
                    $i=0;
                    foreach ($val['questions'] as $key => $value) {
                        $reply = new EventDetailReply();
                        $reply->event_detail_id = $request['event_id'];
                        $reply->user_id = $val['userID'];
                        $reply->event_id = $request['event'];
                        $reply->question_id = $value['id'];
                        $reply->data = $value['answer'];
                        $reply->status = 2;
                        $reply->save();

                        $update_event_detail = EventDetailProcess::find($request['event_id']);
                        $update_event_detail->status = 3;
                        $update_event_detail->save();
                    $i++;
                    }
                    $EventDetailProcess=EventDetailProcess::where('event_id',$request['event'])->where('user_id_receiver',$val['userID'])->first();
                    $EventDetailProcess->number_question= $i;
                    $EventDetailProcess->save();
                }


            } catch (\Exception $e) {
                \DB::rollBack();

                return $this->response->errorInternal($e->getMessage());
            }


            \DB::commit();

            return redirect()
                ->route('success')
                ->with([
                    'flash_level'   => 'success',
                    'flash_message' => 'Bạn thêm thành công!!!'
                ]);


        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show($code)
        {

            $event = EventDetailProcess::with('event')
                                       ->where('code', $code)
                                       ->first();
            if (!$event) {
                exit('loi');
            }
            // $department = Department::find($event->department_id);
            $employments = Employment::where('department_id', $event->department_id)
                                     ->whereNotIn('id', [$event->user_id_receiver])
                                     ->get()
                                     ->toArray();

            $groupQuestion = GroupQuestion::with('detail')
                                          ->with('detail_question')
                                          ->where('id', $event->event->qroup_question_id)
                                          ->get();
            if($event['status']==3){
                return view('danhgia::reply.error');
            }
            return view('danhgia::reply.detail', [
                'event'         => $event,
                'employments'   => $employments,
                'groupQuestion' => $groupQuestion
            ]);
        }

        public function success()
        {
            return view('danhgia::reply.success');
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

        public function get_event($id)
        {
            $data     = DB::table('event_detail_process')
                          ->join('event', 'event.id', 'event_detail_process.event_id')
                          ->where('event_detail_process.code', $id)
                          ->select('event.description', 'event_detail_process.id', 'event_detail_process.user_id_receiver', 'event_detail_process.department_id', 'event_detail_process.event_id', 'event.qroup_question_id')
                          ->get();
            $question = DB::table('group_question_detail')
                          ->join('question', 'question.id', 'group_question_detail.question_id')
                          ->where('group_question_detail.group_question_id', $data[0]->qroup_question_id)
                          ->get();
            $nhanvien = DB::table('event_detail_process')
                          ->join('user_details', 'user_details.id', 'event_detail_process.user_id_receiver')
                          ->where('event_detail_process.department_id', $data[0]->department_id)
                          ->where('event_detail_process.event_id', $data[0]->event_id)
                          ->whereNotIn('event_detail_process.user_id_receiver', [$data[0]->user_id_receiver])
                          ->select('user_details.id', 'user_details.full_name')
                          ->get();


            //            $data[0]->qroup_question_id
            return response()->json([
                'status'   => 'success',
                'event'    => $data,
                'question' => $question,
                'nhanvien' => $nhanvien
            ]);

        }


    }
