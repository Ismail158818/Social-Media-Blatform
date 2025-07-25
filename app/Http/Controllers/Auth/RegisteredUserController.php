<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.login_register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'max:15', 'min:9', 'regex:/^[0-9]+$/'],
            'image' => ['nullable', 'sometimes', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ], [
            'phone_number.regex' => 'The phone number must contain only digits.',
            'phone_number.min' => 'The phone number must be at least 9 digits.',
            'phone_number.max' => 'The phone number must not exceed 15 digits.',
            'image.max' => 'The image size must not exceed 2MB.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.'
        ]);

        try {
            // Get the trainee role
            $traineeRole = Role::where('name', 'Trainer')->first();
            if (!$traineeRole) {
                throw new \Exception('Trainee role not found');
            }

            // Create the user with default image if none provided
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'role_id' => $traineeRole->id,
                'image' => 'images/Default_image.jpg', // Default image
            ]);

            // Handle the image upload if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Store the image in the public disk
                $image->storeAs('profile_pictures', $imageName, 'public');
                
                // Update the user's image path with the full path
                $user->image = 'profile_pictures/' . $imageName;
                $user->save();
            } else {
                // Set default image if no image is uploaded
                $user->image = 'images/Default_image.jpg';
                $user->save();
            }

            event(new Registered($user));
            Auth::login($user);

            return redirect()->route('posts')->with('success', 'Registration successful! Welcome to our platform.');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Registration Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['general' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
}
