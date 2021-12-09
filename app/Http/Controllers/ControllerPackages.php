<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Packages;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

use File;

use Illuminate\Support\Facades\Auth;

use SimpleXLS;

use DB;


class ControllerPackages extends Controller
{
    //



         public function packages(){

            
            $packages = Packages::all();
            
            return view('packages',['packages'=>$packages]);

         }
         
         
         
         
         public function delete($id){

            
            $package = Packages::where('id',$id)->delete();
            
            //return view('edit',['package'=>$package]);
            
            return redirect()->route('packages')->with('success', '<p>Посылка ID-'.$id.' удалена!</p>');

         }
         
         
         public function edit($id){

            
            $package = Packages::where('id',$id)->first();
            
            return view('edit',['package'=>$package]);

         }
         
         
         public function edit_submit(Request $req){
                    
                    $user = Auth::user();
                    
                    $id = $req->input('id');
                    
                        
                    if($req->input('TTN_auto')){
                        $validator = Packages::ValidateFields2($req->all());
                    }else{
                        $validator = Packages::ValidateFields($req->all());
                    }


                    if ($validator->fails()) {
                        $messages = $validator->messages();
                        Log::error('Error create_package:', $messages->all());
                        $m = '';
                        foreach($messages->all() as $message){
                            $m .= '<p>'.$message.'<p>';
                        }
                        return redirect()->route('edit',$id)->with('error', $m)->with('form',$req->all());
                    
                    }else{

                            $TTN = $req->input('TTN');
                            
                            if($req->input('TTN_auto')){
                                $code_Sender = Packages::getCountryCode($req->input('Sender_city'));  
                                $code_Recipient = Packages::getCountryCode($req->input('Recipient_city'));    
                                $TTN = 'TL'.sprintf('%04d', $user->id).sprintf('%06d', $id).$code_Sender.'-'.$code_Recipient;
                            }                            
                            
                            
                            
                            Packages::where('id', $id)
                                    ->update(['TTN' => $TTN,
                                              'Status' => $req->input('Status'),
                                              'Sender' => $req->input('Sender'),
                                              'Recipient' => $req->input('Recipient'),
                                              'Sender_city' => $req->input('Sender_city'),
                                              'Recipient_city' => $req->input('Recipient_city'),
                                              'updated_at' => Carbon::now()]);   
                                              
                                              
                            return redirect()->route('packages')->with('success', '<p>Посылка ID-'.$id.' обновлена</p>');
          
                    }
                    
                    
                    
                    
         }
         
         
 
 
         public function create_submit(Request $req){
            
                    $user = Auth::user();
            
                   
                    if($req->input('TTN_auto')){
                        $validator = Packages::ValidateFields2($req->all());
                    }else{
                        $validator = Packages::ValidateFields($req->all());
                    }
                    
                    
                    if ($validator->fails()) {
                        $messages = $validator->messages();
                        Log::error('Error create_package:', $messages->all());
                        $m = '';
                        foreach($messages->all() as $message){
                            $m .= '<p>'.$message.'<p>';
                        }
                        return redirect()->route('create')->with('error', $m)->with('form',$req->all());
                    
                    }else{
                                
                
                        $Packages = new Packages();
                        
                        $Packages->TTN = $req->input('TTN');
                        $Packages->Status = $req->input('Status');
                        $Packages->Sender = $req->input('Sender');
                        $Packages->Recipient = $req->input('Recipient');
                        $Packages->Sender_city = $req->input('Sender_city');
                        $Packages->Recipient_city = $req->input('Recipient_city');
                        $Packages->created_at = Carbon::now()->timestamp;            
                        $Packages->updated_at = Carbon::now()->timestamp;            
        
                        
                        if($Packages->save()){
                            
                            $package_id = $Packages->id;
                                                    
                            if($req->input('TTN_auto')){
                                
                                $code_Sender = Packages::getCountryCode($req->input('Sender_city'));  
                                $code_Recipient = Packages::getCountryCode($req->input('Recipient_city'));    

                                $TTN = 'TL'.sprintf('%04d', $user->id).sprintf('%06d', $package_id).$code_Sender.'-'.$code_Recipient;
                                
                                Packages::where('id', $package_id)
                                        ->update(['TTN' => $TTN]);                               
                                    
                            }
                        
                            //echo $TTN;
                            //die;
                            
                            return redirect()->route('packages')->with('success', 'Создана новая посылка ID-'.$package_id);
                        
                        }else{
                            
                            return redirect()->route('packages')->with('error', 'Ошибка сохранения');
                        }
            
                }
            
         }    
         
         
         public function load_xlsx_submit(Request $req){
         
            
            $file = $req->file('file');
            if($file){
                $fileName = substr(md5(microtime() . rand(0, 9999)), 0, 20).'_'.date('d_m_Y').'.'.$file->getClientOriginalExtension();
                $file->move(public_path('upload'),$fileName); 
            }
            
            
            $count_add = 0;
            $count_upd = 0;
            $count_skip = 0;
            $m = '';
            
            if ( $xls = SimpleXLSX::parseFile(public_path('upload/'.$fileName)) ) {
                
                if(count($xls->rows())>0){
                    
                    foreach($xls->rows() as $key=>$item){
                        if($key>0){
                            
                            
                            
                            $TTN = $item[0];
                            $Status = $item[1];
                            $Sender = $item[2];
                            $Recipient = $item[3];
                            $Sender_city = $item[4];
                            $Recipient_city = $item[5];
                            

                            $validator = Packages::ValidateFields(['TTN'=>$TTN,
                                                                   'Status'=>$Status,
                                                                   'Sender'=>$Sender,
                                                                   'Recipient'=>$Recipient,
                                                                   'Sender_city'=>$Sender_city,
                                                                   'Recipient_city'=>$Recipient_city]);
                                    
                            if ($validator->fails()) {
                                
                                $messages = $validator->messages();
                                Log::error('Error create_package:', $messages->all());
                                foreach($messages->all() as $message){
                                    $m .= '<p>IN ROW '.($key+1).' ('.$message.')<p>';
                                }                                
                                
                                $count_skip++;
                                
                            }else{
                                

                            
                            
                            
                                $package_id = Packages::getPackageId($TTN);
                                
                                if(!$package_id){            
                            
                                    $Packages = new Packages();
                                    
                                    $Packages->TTN = $TTN;
                                    $Packages->Status = $Status;
                                    $Packages->Sender = $Sender;
                                    $Packages->Recipient = $Recipient;
                                    $Packages->Sender_city = $Sender_city;
                                    $Packages->Recipient_city = $Recipient_city;
                                    $Packages->created_at = Carbon::now()->timestamp;            
                                    $Packages->updated_at = Carbon::now()->timestamp;  
                                
                                    $Packages->save();
                                    
                                    $count_add++;
                                
                                }else{
                                    
                                    
                                    Packages::where('id', $package_id)
                                            ->update(['TTN' => $TTN,
                                                      'Status' => $Status,
                                                      'Sender' => $Sender,
                                                      'Recipient' => $Recipient,
                                                      'Sender_city' => $Sender_city,
                                                      'Recipient_city' => $Recipient_city,
                                                      'updated_at' => Carbon::now()]);                                    
                                    
                                    $count_upd++;
                                    
                                }
                            
                            
                           } 
                            

                        }
                    
                    
                    }
                }
                
                
            } else {
            	echo SimpleXLSX::parseError(); die;
            }            
            
            
            return redirect()->route('packages')->with('success', '<p>Создано новых '.$count_add.'; Обновлено '.$count_upd.'; Пропущено '.$count_skip.'</p>'.$m);
            
            
            
         }


     public function get_cities(Request $request)
     {

        $cities = DB::table('cities')
            ->select('cities.name as city_name','countries.name as country_name')
            ->leftJoin('countries', 'countries.id', '=', 'cities.country_id')
            //->join('region', 'region.id_region', '=', 'city.id_region')
            //->where('city.id_country', '=', 82)
            ->where('cities.name','LIKE',"{$request->string}%")
            ->get();

            
            $out = '';
            
            foreach($cities as $city){
                
                $out .= '<p><a>'.$city->city_name.'</a>('.$city->country_name.')</p>';
                
            }
            
            return response()->json(['data'=>$out]);
            
     }
         
         
}
