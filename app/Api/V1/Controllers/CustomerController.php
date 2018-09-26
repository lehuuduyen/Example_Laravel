<?php
	
	namespace App\Api\V1\Controllers;
	use App\Api\V1\Requests\CreateCustomerRequest;
	use App\Http\Controllers\BaseController;
	use App\User;
	use Auth;
	use Illuminate\Http\Request;
	use Modules\Coin\Entities\CoinAddress;
	use Modules\Coin\Http\Controllers\CoinTransactionController;
	use Modules\Customer\Entities\UserTransaction;
	use Tymon\JWTAuth\Exceptions\JWTException;
	use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
	class CustomerController extends BaseController{
		public function verifyCode( $code = '' ){
			$user = User::where( [
				'verify_code'   => $code,
				'verify_status' => 0
			] )->first();
			if( ! $user ){
				return $this->responseNoContent();
			}
			$user->verify_status = 1;
			$user->save();
			
			return $this->responseSuccess();
		}
		public function store( CreateCustomerRequest $request ){
			try{
				
				$data                = $request->dataOnly();
				$data['verify_code'] = str_random( 60 );
				$user                = User::create( $data );
			}catch( \Exception $e ){
				return $this->responseServerError( $e->getMessage() );
			}
			
			return $this->responseSuccess( $user );
		}
		public function show(){
			$user = User::find( Auth::user()->id );
			if( ! $user ){
				return $this->responseNoContent();
			}
			
			return $user;
		}
		/*
		 * Cap nhat thong tin vi vao giao dich
		 */
		public function verifyStatus(){
			$user = User::where( [
				'id'     => Auth::user()->id,
				'status' => 0
			] )->first();
			if( ! $user ){
				return $this->responseNoContent();
			}
			//Check coin address
			$btcAddress  = CoinAddress::where( [
				'type'   => CoinAddress::$TYPE_BTC,
				'status' => CoinAddress::$STATUS_CREATED
			] )->first();
			$ethAddress  = CoinAddress::where( [
				'type'   => CoinAddress::$TYPE_ETH,
				'status' => CoinAddress::$STATUS_CREATED
			] )->first();
			$usdtAddress = CoinAddress::where( [
				'type'   => CoinAddress::$TYPE_USDT,
				'status' => CoinAddress::$STATUS_CREATED
			] )->first();
			if( ! $btcAddress || ! $ethAddress || ! $usdtAddress ){
				return $this->responseServerError( "Limited Wallet Address" );
			}
			$user->btc_address       = $btcAddress->address;
			$btcAddress->user_id_use = Auth::user()->id;
			$btcAddress->status      = 1;
			$btcAddress->save();
			$user->eth_address       = $ethAddress->address;
			$ethAddress->user_id_use = Auth::user()->id;
			$ethAddress->status      = 1;
			$ethAddress->save();
			$user->usdt_address       = $usdtAddress->address;
			$usdtAddress->user_id_use = Auth::user()->id;
			$usdtAddress->status      = 1;
			$usdtAddress->save();
			$user->status = 1;
			$user->save();
			
			return $this->responseSuccess( "Created wallet success" );
		}
		public function update( Request $request ){
		}
		/**
		 * Chay kien tra transaction nap tien tu dong
		 *
		 * @param string $coinType
		 */
		public function updateCoinTransaction( $coinType = 'btc' ){
			if( $coinType == CoinAddress::$TYPE_BTC ){
				$coinTransactionController = new CoinTransactionController();
				list( $result,$data ) = $coinTransactionController->updateDbBTC( Auth::user()->btc_address );
				list( $result,$data ) = $coinTransactionController->updateDbETH( Auth::user()->eth_address );
				exit( 'Done' );
			}
		}
	}
