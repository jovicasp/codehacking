<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersCreateRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Models\Photo;
use App\Models\Role;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
     * Random user create method
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function create_random_user()
    {
        $names = ['Nikola Jovanović', 'Ivan Petrović', 'Jovan Nikolić', 'Marija Marković', 'Ana Đorđević', 'Mihailo Stojanović', 'Aleksandar Ilić', 'Andrej Stanković', 'Teodora Pavlović', 'Jelena Milošević', 'Sofija Jovanović', 'Katarina Petrović', 'Nikola Nikolić', 'Đorđe Marković', 'Stefan Đorđević', 'Petar Stojanović', 'Vasilije Ilić', 'Todor Stanković', 'Marko Pavlović', 'Anđelka Milošević', 'Antonije Jovanović', 'Pavle Petrović', 'Srđan Nikolić', 'Marina Marković', 'Natalija Đorđević', 'Kornelije Stojanović', 'Igor Ilić', 'Oliver Stanković', 'Olga Pavlović'];
        $emails = ['nikolajovanovic@mail.com', 'ivanpetrovic@mail.com', 'jovannikolic@mail.com', 'marijamarkovic@mail.com', 'anadjordjevic@mail.com', 'mihailostojanovic@mail.com', 'aleksandarilic@mail.com', 'andrejstankovic@mail.com', 'teodorapavlovic@mail.com', 'jelenamilosevic@mail.com', 'sofijajovanovic@mail.com', 'katarinapetrovic@mail.com', 'nikolanikolic@mail.com', 'djordjemarkovic@mail.com', 'stefandjordjevic@mail.com', 'petarstojanovic@mail.com', 'vasilijeilic@mail.com', 'todorstankovic@mail.com', 'markopavlovic@mail.com', 'andjelkamilosevic@mail.com', 'antonijejovanovic@mail.com', 'pavlepetrovic@mail.com', 'srdjannikolic@mail.com', 'marinamarkovic@mail.com', 'natalijadjordjevic@mail.com', 'kornelijestojanovic@mail.com', 'igorilic@mail.com', 'oliverstankovic@mail.com', 'olgapavlovic@mail.com'];
        $photo_id = random_int(1, 25);
        $name = $names[array_rand($names, 1)];
        $email = $emails[array_rand($emails, 1)];

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => '12345678',
            'role_id' => '3',
            'is_active' => '0',
            'photo_id' => $photo_id,
        ]);
        Session::flash('created_user', 'The user ' . $user->name . ' has been created!');
        return redirect(route('users.index'));
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

        $user = User::create($input);
        Session::flash('created_user', 'The user '.$user->name.' has been created!');
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

        Session::flash('updated_user', 'The user '.$user->name.' has been updated!');
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
        $user=User::findOrFail($id);
        Photo::findOrFail($user->photo->id)->delete();      //DELETE FROM DB-TABLE-PHOTOS
        unlink(public_path().$user->photo->path);   //DELETE FILE FROM PUBLIC/IMAGES FOLDER

        Session::flash('deleted_user', 'The user '.$user->name.' has been deleted!');
        $user->delete();

        return redirect(route('users.index'));

    }
}
