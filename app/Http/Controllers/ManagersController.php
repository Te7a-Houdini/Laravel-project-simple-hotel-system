<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\File;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;


class ManagersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $managers = User::where('type', '=', 2)->paginate(2);
        return view('managers.index',[

            'managers' => $managers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admins = User::where('type', '=', 1);
        return view('managers.create',[
            'admins' => $admins
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if($request->file('avatar_image')==null){
        $path='/avatars2/Nophoto.jpg';
        }
        else{
        $path = Storage::putFile('avatars2', $request->file('avatar_image'));
        }
        Storage::setVisibility($path, 'public');
			User::create([
				'name' => $request->name,
				'email' => $request->email,
                'password' => $request->password,
                'national_id' => $request->national_id,
                'avatar_image' => $path,
                'type' => 2,
            ]);

       return redirect(route('managers.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $managers = User::where('id', $request->id)->first();
        return view('managers.show',[
            'managers' => $managers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $managers = User::where('id', '=', $id)->first();
		return view('managers.update',[
            'managers' => $managers
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        $managers = User::where('id', $request->id)->first();
        if($request->file('photo')==null){
			 $managers->update([
                'name' => $request->name,
				'email' => $request->email,
                'national_id' => $request->national_id,
                'type' => 2,
        ]);
        }
        else{
            Storage::delete($managers->photo);
            $path = Storage::putFile('avatars2', $request->file('avatar_image'));
             Storage::setVisibility($path, 'public');
                 $managers->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'avatar_image' => $path,
                    'national_id' => $request->national_id,
                    'type' => 2,
            ]);
        }
        
       return redirect(route('managers.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $managers = User::where('id', $request->id)->first();
        Storage::delete($managers->photo);
        $managers->delete();
        return redirect(route('managers.index')); 
    }
}
