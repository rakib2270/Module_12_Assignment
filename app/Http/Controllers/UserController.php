<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
     // Show the user registration form
     public function showRegistrationForm()
     {
         return view('auth.register');
     }
 
     // Handle user registration
     public function register(Request $request)
     {
         // Validation logic goes here
 
         $user = new User();
         // Set user attributes from the request
 
         $user->save();
 
         // Log in the registered user
         Auth::login($user);
 
         // Redirect to the user dashboard or any other relevant page
         return redirect()->route('dashboard')->with('success', 'Registration successful.');
     }
 
     // Show the user login form
     public function showLoginForm()
     {
         return view('auth.login');
     }
 
     // Handle user login
     public function login(Request $request)
     {
         // Validation logic goes here
 
         $credentials = $request->only('email', 'password');
 
         if (Auth::attempt($credentials)) {
             // Authentication passed, redirect to the user dashboard or any other relevant page
             return redirect()->route('dashboard')->with('success', 'Login successful.');
         } else {
             // Authentication failed, redirect back with an error message
             return redirect()->back()->with('error', 'Invalid login credentials. Please try again.');
         }
     }
 
     // Log out the user
     public function logout()
     {
         Auth::logout();
 
         // Redirect to the home page or any other relevant page
         return redirect('/');
     }
 
     // Show the user dashboard
     public function dashboard()
     {
         // Fetch user's booked trips and other information
         $user = Auth::user();
         $bookedTrips = $user->seatAllocations()->with('trip')->get();
 
         return view('dashboard', compact('bookedTrips'));
     }
 
    
}
