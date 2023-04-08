<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:user-list', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function json(){
        return DataTables::of(User::orderBy('created_at', 'DESC'))->addIndexColumn()->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $page['page'] = 'users';
        $page['can'] = 'user';
        $page['title'] = 'Users Management';
        return view('webmin.users.index',compact('page'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $page['page'] = 'users';
        $page['title'] = 'Users Management';
        $page['method'] = 'POST';
        $page['action'] = route('users.store');
        $userRole = [];

        $roles = Role::pluck('name','name')->all();
        $_roles = [];
        foreach($roles as $key => $val){
            $_roles[] = array('id'=>$val, 'name'=>$val);
        }
        $roles = json_decode(json_encode($_roles));
        return view('webmin.users.form',compact('page','roles','userRole'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('webmin.users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $_roles = [];
        foreach($roles as $key => $val){
            $_roles[] = array('id'=>$val, 'name'=>$val);
        }
        $roles = json_decode(json_encode($_roles));
        $userRole = $user->roles->pluck('name','name')->all();
        $_userRole = [];
        foreach ($userRole as $key => $value) {
            $_userRole[] = $key;
        }
        $userRole = implode(',',$_userRole);

        $page['page'] = 'users';
        $page['title'] = 'Users Management';
        $page['method'] = 'PUT';
        $page['action'] = route('users.update',$id);

        return view('webmin.users.form',compact('page','user','roles','userRole'));
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

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'roles' => 'required'
        ]);

        $user = User::find($id);
        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input['password'] = $user['password'];
        }


        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
       $user = Auth::user();

       $page['page'] = 'myprofile';
       $page['title'] = 'My Profile';
       $page['method'] = 'PUT';
       $page['action'] = route('myprofile.update',0);

       return view('webmin.users.profile.form',compact('page','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request, $id)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id
        ]);

        $user = User::find($id);
        $input = $request->all();
        $input['password'] = $user['password'];
        $user->update($input);

        return redirect()->route('myprofile')
                        ->with('success','Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
       $user = Auth::user();

       $page['page'] = 'changepassword';
       $page['title'] = 'Change Password';
       $page['method'] = 'PUT';
       $page['action'] = route('changepassword.update',0);

       return view('webmin.users.profile.changepassword',compact('page','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePasswordUpdate(Request $request, $id)
    {
        $id = Auth::user()->id;
        $request->validate([
            'password_current' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find($id);
        if (!Hash::check($request->password_current, $user->password)) {
            throw ValidationException::withMessages([
                'password_current' => ['Current password does not match'],
                ]);
            return redirect()->back();

        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('dashboard')
                        ->with('success','Password change successfully');
    }
}
