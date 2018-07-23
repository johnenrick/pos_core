<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\UserAuth;
use App\AccountInformation as AccountInformation;
use App\Account;

class AuthenticateController extends Controller
{
  public function __construct()
   {
     // Apply the jwt.auth middleware to all methods in this controller
     // except for the authenticate method. We don't want to prevent
     // the user from retrieving their token if they don't already have it
     $this->middleware('jwt.auth', ['except' => ['authenticate']]);
   }
  public function index()
  {
    $users = UserAuth::all();
    return $users;
  }
  public function refreshToken(){
    // config/jwt.php ttl to change token life
    if ($token = JWTAuth::parseToken()->refresh()){
      return response()->json(['error' => 'failed_parse', 'token' => JWTAuth::getToken()], 401);
    }
    // $current_token  = JWTAuth::getToken();
    // $token          = JWTAuth::refresh($current_token);
    return response()->json(compact('token'))->header('Authorization', 'Bearer ' . $token);;
  }
  public function refresh(){
    return response([
      'status' => 'success'
    ]);
  }
  public function authenticate(Request $request)
  {
      $credentials = $request->only('username', 'password');
      $credentials['deleted_at'] = NULL;
      try {
        // verify the credentials and create a token for the user
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
      } catch (JWTException $e) {
        // something went wrong
        return response()->json(['error' => 'could_not_create_token'], 500);
      }
      // if no errors are encountered we can return a JWT
      return response()->json(compact('token'))->header('Authorization', 'Bearer ' . $token);
  }
  public function deauthenticate(){
    JWTAuth::invalidate();
    return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
  }
  public function getAuthenticatedUser()
  {
      try {
        if (! $user = JWTAuth::parseToken()->authenticate()) {
          return response()->json(['user_not_found'], 404);
        }
      } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        return response()->json(['error' => 'token_expired'], $e->getStatusCode());
      } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        return response()->json(['error' => 'token_invalid'], $e->getStatusCode());
      } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
        return response()->json(['error' => 'token_absent'], $e->getStatusCode());
      }
      $acountModel  = new Account();
      $account = $acountModel->where('id', $user['id'])->get()->toArray();

      // $accountInformationModel  = new AccountInformation();
      // $accountInformation = $accountInformationModel->where('account_id', $user['id'])->get()->toArray();


      if(count($account)){
        $user['account_type_id'] = $account[0]['account_type_id'];
        return response()->json(['data' => $user, 'error' => []]);
      }else{
        return response()->json(['error' => 'invalid_credentials', 'user_id' => $user['id']], 401);
      }
  }
}
