<?php
	
	namespace App\Http\Controllers;
	use Illuminate\Routing\Controller as BaseController;
	use Yajra\Datatables\Datatables;
	class Controller extends BaseController{
		public static function anyData( GetAnyDataRequest $request ){
			$list = Sms::select();
			//filter with date form => to
			if( ! empty( $request->dateStart ) && ! empty( $request->dateEnd ) ){
				
				$dateStart = DateHelper::convertDateToDateTime( $request->dateStart,'Y-m-d 00:00:00' );
				$dateEnd   = DateHelper::convertDateToDateTime( $request->dateEnd,'Y-m-d 23:59:00' );
				$list->where( 'created_at','>=',$dateStart );
				$list->where( 'created_at','<=',$dateEnd );
			}
			
			return Datatables::of( $list )->addColumn( 'username',function ( $data ){
				$user = User::find( $data->user_id );
				
				return $user->name;
			} )->addColumn( 'status_view',function ( $data ){
				$str = '';
				switch( $data->state ){
					case Sms::$STATUS_SUCCESS:
						$str = '<span class="label label-success">Hoàn thành</span>';
						break;
					case Sms::$STATUS_CREATED:
						$str = '<span class="label label-info">Đã tạo</span>';
						break;
					case Sms::$STATUS_ERROR:
						$str = "<span class=\"label label-danger\">Lỗi</span>";
						break;
					case Sms::$STATUS_PROCESSING:
						$str = '<span class="label label-primary">Đang xử lý</span>';
						break;
				}
				
				return $str;
			} )->addColumn( 'action',function (){
				//list action for row
			} )->rawColumns( [ 'status_view' ] )->make( TRUE );
		}
	}
