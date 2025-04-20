<?php

namespace App\Http\Controllers\Auth;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Traveller;
use App\Models\Transport;
use App\Models\Guide;
use App\Models\Hotel;


class RegisterController extends Controller
{
    protected $redirectTo = '/login';
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest');
        $this->userRepository = $userRepository;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validateRequest($request);
        $this->createUser($request);
        return redirect($this->redirectTo)->with('success');
    }

    protected function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:transport,traveller,admin,hotel,guide,manager'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    protected function createUser(Request $request){
        $user = $this->userRepository->create([
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        switch ($user->role) {
            case 'traveller':
                Traveller::create([
                    'user_id' => $user->id,
                ]);
                break;

            case 'guide':
                Guide::create([
                    'user_id' => $user->id,
                ]);
                break;

            case 'hotel':
                Hotel::create([
                    'user_id' => $user->id,
                ]);
                break;

            case 'transport':
                Transport::create([
                    'user_id' => $user->id,
                ]);
                break;
                
            // Manager doesn't need a separate model, as it uses only the User model with 'manager' role
        }
        return $user;
    }
}