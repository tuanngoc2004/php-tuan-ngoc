<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $users = $this->userRepo->getAll();
        return view('users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
        ]);
        $user = $this->userRepo->create($data);
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $user = $this->userRepo->find($id);
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
        ]);
        $user = $this->userRepo->update($id, $data);
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $this->userRepo->delete($id);
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $user = $this->userRepo->find($id);
        return view('users.show', ['user' => $user]);
    }
}
