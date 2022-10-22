<?php

namespace App\Http\Controllers;

use Exception;
use Socialite;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;

class AuthController extends Controller
{
   public function location(){
    $ip = request()->ip();
    $ip1 = '130.0.0.4';
    // return $ip.' '.$ip1;
    $data = Location::get($ip);
    dd($data);
   }
    public function index()
    {
        return view('Auth.login');
    }

    public function sinup()
    {
        $roles = Role::all();
        return view('Auth.register',compact('roles'));
    }

    public function register(Request $request){
        $this->validate($request,[
            "name" => "required",
            "email" => "required",
            "role" => "required",
            "password" => "required",
            "confirm_password" => "required|same:password",
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email= $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->roles()->attach($request->role);
        return redirect()->route('/home');

    }

    public function login(Request $request){

        $this->validate($request,[
            "email" => "required",
            "password" =>"required",

        ]);
        // $email = $this->request->input("email");
        // $password = $this->request->input("password");
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return view('welcome');
        }
        else{
            return "falild to login please register";
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        // dd(Session::all());
        Auth::logout();
         return redirect()->route('/');
    }


    public function home()
    {
        return view('home.index');
    }


    public function redirectToGoogle()
    {
        // dd('sdfasf');

        return Socialite::driver('google')->redirect();

    }



    public function handleCallback()
    {
        // dd('sdfasf');
        try {
     
            $user = Socialite::driver('google')->user();
      
            $finduser = User::where('social_id', $user->id)->first();
      
            if($finduser){
      
                Auth::login($finduser);
     
                return redirect('/home');
      
            }else{

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'social_type'=> 'google',
                    'password' => encrypt('my-google')
                ]);
     
                Auth::login($newUser);
      
                return redirect('/home');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
