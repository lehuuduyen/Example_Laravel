<?php
	
	namespace App\Http\Middleware;
	use App\Http\Controllers\BaseController;
	use Closure;
	use GuzzleHttp\Client;
	use GuzzleHttp\Exception\RequestException;
	use GuzzleHttp\Psr7;
	class CheckToken{
		/**
		 * Handle an incoming request.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \Closure                 $next
		 * @return mixed
		 */
		public function handle( $request,Closure $next,$permission ){
			$bearerToken = $request->header( 'Authorization' );
			$client      = new Client( array(
				'verify',
				FALSE
			) );
			try{
				
				$response = $client->request( 'POST',getenv( 'URL_LOGIN_CHECK_TOKEN' ),[
					'headers'     => [
						'Authorization' => $bearerToken,
					],
					'form_params' => [
						'sys_app_id' => getenv( 'SYS_APP_ID' ),
						'permission' => $permission
					],
					'http_errors' => TRUE
				] );
				$code     = $response->getStatusCode(); // 200
				$body     = $response->getBody();
				$arrBody  = json_decode( $body );
				session( [
					'userData' => $arrBody->data,
					'token'    => $bearerToken
				] );
				if( $arrBody->status_code != 200 ){
					return \Response::json( $arrBody,$arrBody->status_code );
				}
				
				return $next( $request );
			}catch( RequestException $e ){
				//echo Psr7\str( $e->getRequest() );
				//if( $e->hasResponse() ){
				//	echo Psr7\str( $e->getResponse() );
				//}
				//if( $e->hasResponse() ){
				//	$exception = (string)$e->getResponse()->getBody();
				//	$exception = json_decode( $exception );
				//
				//	return new JsonResponse( $exception,$e->getCode() );
				//}else{
				//	return new JsonResponse( $e->getMessage(),503 );
				//}
				$baseController = new BaseController();
				$exception      = $e->getResponse()->getBody();
				
				return $exception;
				
				return $baseController->responsePermissionDenied( $exception );
			}
		}
	}
