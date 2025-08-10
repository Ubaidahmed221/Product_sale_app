<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = User::query();
            $query->where('is_admin', 0);
            if($request->input('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('name','like',"%$search%")
                    ->orwhere('email','like',"%$search%");
                });

            }

        $users =  $query->latest()->paginate(10);

            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }

     public function toggleBlock(User $user)
    {
        try {

            $user->is_block = !$user->is_block;
            $user->save();
            return back()->with('success', 'User block status updated successfully.');

           
        } catch (\Exception $e) {
           
            return back()->with('error', $e->getMessage());

        }
    }

      public function destroy(User $user)
    {
        try {

           $user->delete();
            return back()->with('success', 'User deleted successfully.');
           
        } catch (\Exception $e) {
           
            return back()->with('error', $e->getMessage());

        }
    }

    public function orders(User $user)
    {
        try {
            $orders = $user->orders()->latest()->paginate(10);
            return view('admin.users.orders', compact('user','orders'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to retrieve user orders: ' . $e->getMessage());
        }
    }
}
