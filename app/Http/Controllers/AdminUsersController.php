<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersCreateRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Models\Photo;
use App\Models\Role;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\DeclareDeclare;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
//       dd($users->find(1)->role->name);
//       dd($users);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->toArray();
//        $roles = Role::pluck('name', 'id')->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersCreateRequest $request)
    {
        if (trim($request->password) == ''){	//trimuje ako se unesu spaceovi smatra sve za prazan string
            $input = $request->except('password');
        }else{
            $input = $request->all();
            $input['password'] = bcrypt($request->password);        }

//      PROVERITI VRACANJE AKO EMAIL POSTOJI U DB!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        if ($file = $request->file('photo_id')) {
            $name = time() . '-' . $file->getClientOriginalName();
            $file->move('images', $name);

            $photo = Photo::create(['path' => $name]);
            $input['photo_id'] = $photo->id;
        }

        User::create($input);
        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id')->toArray();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UsersUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
//        psw condition – mozemo ga staviti u posebnu metodu pa pozvati. Takodje ovo cemo ukljuciti i u store metodu, da trimuje,
//        a tamo je validacija required, tj. psw mora da se unese-nikad nece biti prazan string.
        if (trim($request->password) == '') {    //trimuje ako se unesu spaceovi smatra sve za prazan string
            $input = $request->except('password');
        } else {
            $input = $request->all();
            //ALTHOUGH PSW IS NOT REQUIRED DURING USER EDITING, IF IT IS INSERTED IN ORDER TO CHANGE
            //WE NEED TO VALIDATE IT HERE NOW!!!
            $this->validate($request, [
                'password' => 'min:5'
            ]);
            $input['password'] = bcrypt($request->password);
        }

        if ($file = $request->file('photo_id')) {
            $name = time() . "-" . $file->getClientOriginalName();
            $file->move('images', $name);

            $photo = Photo::create(['path' => $name]);
            $input['photo_id'] = $photo->id;
        }
        $user->update($input);

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::whereId($id)->delete();
        return redirect(route('users.index'));

    }
}
