<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    public function Settings(){

        $setting=Setting::first();
        return view('settings.index',compact('setting'));
    }

    public function SettingsSave(Request $request){

        $settings=Setting::first();
        if($settings==null){
            $settings=new Setting();
        }

        $settings->auto_push_orders=isset($request->auto_push_orders)?$request->auto_push_orders:0;
        $settings->email=$request->email;
        $settings->password=$request->password;
        $settings->save();
        return Redirect::tokenRedirect('settings', ['notice' => 'Settings Save Successfully']);
    }
}
