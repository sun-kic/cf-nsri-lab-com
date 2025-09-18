<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    //
    public function index(){
        $profile = Profile::where('user_id',auth()->id())->latest()->first();
        if (is_null($profile)){
            return view('profiles.create');
        }elseif (\Carbon\Carbon::now()->subMonth()->format("Y-m")==substr($profile->year_month,0,-3)){
            $user = User::where('id',auth()->id())->first();
            return view('profiles.edit',['profile' => $profile,'user'=>$user]);
        }else{
            $user = User::where('id',auth()->id())->first();
            return view('profiles.index',['profile' => $profile,'user'=>$user]);
        }
    }

    public function store(Request $request) {
        
        // $formFields = $request->validate([
        //     'prefecture' => 'required',
        //     'sex' => 'required',
        //     'age' => 'required',
        //     'house_type' => 'required',
        //     'house_build_year' => 'required',
        //     'house_area' => 'required',
        //     'year_month' => 'required',
        //     'power_company'=> 'nullable',
        //     'power_amount'=> 'nullable',
        //     'power_kw'=> 'nullable',
        //     'gas_type'=> 'nullable',
        //     'gas_amount'=> 'nullable',
        //     'gas_m'=> 'nullable',
        //     'kerosine_amount'=> 'nullable',
        //     'kerosine_l'=> 'nullable',
        // ]);
        $formFields = $request->all();

        // dd($formFields);

        $formFields['user_id'] = auth()->id();

        Profile::create($formFields);


        return redirect('/profile')->with('message', 'profile updated');
    }
    public function update(Request $request, Profile $profile) {
        
        $formFields = $request->all();

        $profile->update($formFields);

        return back()->with('message', 'profile updated');

    }
}
