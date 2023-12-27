<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('verify.secret', ['except' => ['sendOtp', 'verifyOtp', 'userLogin']]);
        //$this->middleware('verify.secret');
    }

    ### MASTERS START ###
    public function getMasters(Request $request)
    {
        if($request->type != "")
        {
            $masters = DB::table('master_list')
                ->where('type', '=', $request->type)
                ->where('status', '=', 1)
                ->get();
        } else
        {
            $masters = DB::table('master_list')
                ->where('status', '=', 1)
                ->get();
        }

        if(count($masters))
        {
			$responseArray['status'] = 1;
			$responseArray['content'] = $masters;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No Data found";
		}
        return $responseArray;

    }

    public function getMasters1(Request $request)
    {
        $parliaments = DB::table('parliaments')->select('uuid', 'stateId', 'name')->where('status', '=', 1)->get();
        $assemblies = DB::table('assemblies')->select('uuid', 'parliamentId', 'name')->where('status', '=', 1)->get();
        $mandals = DB::table('mandals')->select('uuid', 'assemblyId', 'name', 'lattitude', 'longitude')->where('status', '=', 1)->get();
        $muncipalities = DB::table('muncipalities')->select('uuid', 'stateId', 'name')->where('status', '=', 1)->get();
        $wards = DB::table('wards')->select('uuid', 'muncipalityId', 'name', 'lattitude', 'longitude')->where('status', '=', 1)->get();

        $responseArray = array();

		$responseArray['status'] = 1;
		$responseArray['mssg'] = "Success";
		$responseArray['content'][] = array(
					"parliaments" => $parliaments,
					"assemblies" => $assemblies,
					"mandals" => $mandals,
					"municipalities" => $muncipalities,
					"wards" => $wards
				);
        return $responseArray;

    }

    public function mastersActions(Request $request)
    {
        $result = DB::table('master_list')->whereIn('uuid', $request->ids)->update(array('status' => $request->status));

        $masters = DB::table('master_list')->whereIn('uuid', $request->ids)->where('status', '=', 1)->get();
        if(count($masters) > 0)
		{
			$responseArray['status'] = 1;
			$responseArray['content'] = $masters;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
		}

        return $responseArray;
    }

    public function upSertMasters(Request $request)
    {
        $request_array = $request;

        $data = array();
        $data['type'] = $request_array->type;
        $data['dependId'] = $request_array->dependId;
        $data['name'] = $request_array->name;

        $check = DB::table('master_list')
                ->select('uuid')
                ->where('name', '=', $request_array->name)
                ->where('type', '=', $request_array->type)
                ->limit(1)->get();
            
        if(count($check) > 0)
        {
            if($request_array->uuid == "")
            {
                $responseArray['status'] = 0;
                $responseArray['content'] = "";
                $responseArray['mssg'] = "Name exists";
            } else
            {
                $data['status'] = $request_array->status;
                $result = DB::table('master_list')->where('uuid', '=', $request_array->uuid)->update($data);

                $responseArray['status'] = 1;
                $responseArray['content'] = "";
                $responseArray['mssg'] = "Success";
            }
        } else 
        {
            if($request_array->uuid != "")
            {
                $data['status'] = $request_array->status;
                $result = DB::table('master_list')->where('uuid', '=', $request_array->uuid)->update($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            } else {
                $data['uuid'] = (string) Str::uuid();
                $data['status'] = 1;
                $result = DB::table('master_list')->insertGetId($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            }
        }

		return $responseArray;
		
    }
    ### MASTERS END ###

    ### EMPLOYEES START ###
    public function employeeActions(Request $request)
    {
        if($request->status==4){
            $result = DB::table('employees')->whereIn('uuid', $request->ids)->update(array('deviceId' => ''));
        }else{
            $result = DB::table('employees')->whereIn('uuid', $request->ids)->update(array('status' => $request->status));
        }

        $employees = DB::table('employees')
                    ->whereIn('uuid', $request->ids)
                    ->where('status', '=', 1)
                    ->get();

        if(count($employees) > 0)
		{
			$responseArray['status'] = 1;
			$responseArray['content'] = $employees;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = '';
			$responseArray['mssg'] = "No employee found";
		}

        return $responseArray;
    }

    public function getEmployees(Request $request)
    {
        //\DB::enableQueryLog();
        $employees = [];
        if($request->parentId != "" && $request->roleId != "")
        {
            $employees = DB::table('employees')
                ->where('parentId', '=', $request->parentId)
                ->where('roleId', '=', $request->roleId)
                ->where('status', '=', 1)
                ->get();
        } else if($request->parentId != "")
        {
            $employees = DB::table('employees')
                ->where('parentId', '=', $request->parentId)
                ->where('status', '=', 1)
                ->get();
        } else if($request->roleId != "")
        {
            $employees = DB::table('employees')
                ->where('roleId', '=', $request->roleId)
                ->where('status', '=', 1)
                ->get();
        } else {
            $employees = DB::table('employees')
                ->where('status', '=', 1)
                ->get();
        }
        
        if(count($employees))
        {
			$responseArray['status'] = 1;
			$responseArray['content'] = $employees;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = array();
			$responseArray['mssg'] = "Fail";
		}
        return $responseArray;
        //dd(\DB::getQueryLog());
        //die;

    }

    public function upSertEmployees(Request $request)
    {
        $request_array = $request;

        $data = array();
        $data['appCode'] = $request_array->appCode;
        $data['appVersion'] = $request_array->appVersion;
        $data['companyId'] = $request_array->companyId;
        $data['createdBy'] = $request_array->createdBy;
        $data['createdDate'] = $request_array->createdDate;
        $data['description'] = $request_array->description;
        $data['deviceId'] = $request_array->deviceId;
        $data['deviceInfo'] = $request_array->deviceInfo;
        $data['email'] = $request_array->email;
        $data['jobTitle'] = $request_array->jobTitle;
        $data['location'] = $request_array->location;
        $data['loginDate'] = $request_array->loginDate;
        $data['mobileNumber'] = $request_array->mobileNumber;
        $data['modifiedBy'] = $request_array->modifiedBy;
        $data['modifiedDate'] = $request_array->modifiedDate;
        $data['name'] = $request_array->name;
        $data['parentId'] = $request_array->parentId;
        $data['password'] = Hash::make($request_array->password);
        $data['roleId'] = $request_array->roleId;
		$data['status'] = $request_array->status;

        if($request_array->uuid != "")
        {
            //update
            unset($data['mobileNumber']);
            $result = DB::table('employees')->where('uuid', '=', $request_array->uuid)->update($data);

            $responseArray['status'] = 1;
			$responseArray['content'][] = $data;
			$responseArray['mssg'] = "Success";
        } else {

            //insert
            $check = DB::table('employees')
                ->select('uuid')
                ->where('mobileNumber', '=', $request_array->mobileNumber)
                ->limit(1)->get();
            if(count($check) > 0)
            {
                $responseArray['status'] = 0;
                $responseArray['content'] = "";
                $responseArray['mssg'] = "Mobilenumner exists";
            } else
            {
                $data['uuid'] = (string) Str::uuid();
                $result = DB::table('employees')->insertGetId($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            }
        }
		return $responseArray;
		
    }
    ### EMPLOYEES END ###

    ### ASSEMBLIES START ###
    public function upsertAssemblies(Request $request)
    {
        $request_array = $request;

        $data = array();
        $data['parliamentId'] = $request_array->parliamentId;
        $data['stateId'] = $request_array->stateId;
        $data['name'] = $request_array->name;
        $data['lattitude'] = $request_array->lattitude;
        $data['longitude'] = $request_array->longitude;

        $check = DB::table('assemblies')
                ->select('uuid')
                ->where('name', '=', $request_array->name)
                ->where('stateId', '=', $request_array->stateId)
                ->limit(1)->get();
            
        if(count($check) > 0)
        {
            $responseArray['status'] = 0;
            $responseArray['content'] = "";
            $responseArray['mssg'] = "Name exists";
        } else 
        {
            if($request_array->uuid != "")
            {
                $result = DB::table('assemblies')->where('uuid', '=', $request_array->uuid)->update($data);

                $responseArray['status'] = 1;
                $responseArray['content'] = $data;
                $responseArray['mssg'] = "Success";
            } else {
                $data['uuid'] = (string) Str::uuid();
                $data['status'] = 1;
                $result = DB::table('assemblies')->insertGetId($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            }
        }

		return $responseArray;

    }

    public function getAssemblyByState(Request $request)
    {
        if($request->stateId != "")
        {
            $assemblies = DB::table('assemblies')
                ->where('stateId', '=', $request->stateId)
                ->where('status', '=', 1)
                ->get();
        } else
        {
            $assemblies = DB::table('assemblies')
                ->where('status', '=', 1)
                ->get();
        }
        if(count($assemblies) > 0)
        {
            $responseArray['status'] = 1;
            $responseArray['content'] = $assemblies;
            $responseArray['mssg'] = "Success";
        } else 
        {
            $responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
        }
        return $responseArray;
    }

    public function assemblyActions(Request $request)
    {
        $result = DB::table('assemblies')->whereIn('uuid', $request->ids)->update(array('status' => $request->status));

        $assemblies = DB::table('assemblies')->whereIn('uuid', $request->ids)->where('status', '=', '1')->get();

        if(count($assemblies) > 0)
		{
			$responseArray['status'] = 1;
			$responseArray['content'] = $assemblies;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
		}

        return $responseArray;
    }
    ### ASSEMBLIES END ###

    ### MANDALS START ###
    public function upSertMandals(Request $request)
    {
        $request_array = $request;

        $data = array();
        $data['assemblyId'] = $request_array->assemblyId;
        $data['name'] = $request_array->name;
        $data['lattitude'] = $request_array->lattitude;
        $data['longitude'] = $request_array->longitude;

        $check = DB::table('mandals')
                ->select('uuid')
                ->where('name', '=', $request_array->name)
                ->where('assemblyId', '=', $request_array->assemblyId)
                ->limit(1)->get();
            
        if(count($check) > 0)
        {
            $responseArray['status'] = 0;
            $responseArray['content'] = "";
            $responseArray['mssg'] = "Name exists";
        } else 
        {
            if($request_array->uuid != "")
            {
                $result = DB::table('mandals')->where('uuid', '=', $request_array->uuid)->update($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            } else {
                $data['uuid'] = (string) Str::uuid();
                $data['status'] = 1;
                $result = DB::table('mandals')->insertGetId($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            }
        }

		return $responseArray;

    }

    public function getMandalsByAssemblyId(Request $request)
    {
        if($request->assemblyId != "")
        {
            $mandals = DB::table('mandals')
                ->where('assemblyId', '=', $request->assemblyId)
                ->where('status', '=', 1)
                ->get();
        } else
        {
            $mandals = DB::table('mandals')
                ->where('status', '=', 1)
                ->get();
        }
        if(count($mandals) > 0)
        {
            $responseArray['status'] = 1;
            $responseArray['content'] = $mandals;
            $responseArray['mssg'] = "Success";
        } else 
        {
            $responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
        }
        return $responseArray;
    }

    public function mandalActions(Request $request)
    {
        $result = DB::table('mandals')->whereIn('uuid', $request->ids)->update(array('status' => $request->status));

        $mandals = DB::table('mandals')->whereIn('uuid', $request->ids)->where('status', '=', '1')->get();

        if(count($mandals) > 0)
		{
			$responseArray['status'] = 1;
			$responseArray['content'] = $mandals;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
		}

        return $responseArray;
    }

    ### MANDALS END ###

    ### MUNCIPALITIES START ###
    public function upSertMuncipalities(Request $request)
    {
        $request_array = $request;

        $data = array();
        $data['stateId'] = $request_array->stateId;
        $data['name'] = $request_array->name;
        $data['lattitude'] = $request_array->lattitude;
        $data['longitude'] = $request_array->longitude;

        $check = DB::table('muncipalities')
                ->select('uuid')
                ->where('name', '=', $request_array->name)
                ->where('stateId', '=', $request_array->stateId)
                ->limit(1)->get();
            
        if(count($check) > 0)
        {
            $responseArray['status'] = 0;
            $responseArray['content'] = "";
            $responseArray['mssg'] = "Name exists";
        } else 
        {
            if($request_array->uuid != "")
            {
                $result = DB::table('muncipalities')->where('uuid', '=', $request_array->uuid)->update($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            } else {
                $data['uuid'] = (string) Str::uuid();
                $data['status'] = 1;
                $result = DB::table('muncipalities')->insertGetId($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            }
        }

		return $responseArray;

    }

    public function getMuncipalityByState(Request $request)
    {
        if($request->stateId != "")
        {
            $muncipalities = DB::table('muncipalities')
                ->where('stateId', '=', $request->stateId)
                ->where('status', '=', 1)
                ->get();
        } else
        {
            $muncipalities = DB::table('muncipalities')
                ->where('status', '=', 1)
                ->get();
        }
        if(count($muncipalities) > 0)
        {
            $responseArray['status'] = 1;
            $responseArray['content'] = $muncipalities;
            $responseArray['mssg'] = "Success";
        } else 
        {
            $responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
        }
        return $responseArray;
    }

    public function muncipalityActions(Request $request)
    {
        $muncipalities = DB::table('muncipalities')->whereIn('uuid', $request->ids)->update(array('status' => $request->status));

        $muncipalities = DB::table('muncipalities')->whereIn('uuid', $request->ids)->where('status', '=', '1')->get();

        if(count($muncipalities) > 0)
		{
			$responseArray['status'] = 1;
			$responseArray['content'] = $muncipalities;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
		}

        return $responseArray;
    }

    ### MUNCIPALITIES END ###

    ### WARDS START ###
    public function upSertWards(Request $request)
    {
        $request_array = $request;

        $data = array();
        $data['muncipalityId'] = $request_array->muncipalityId;
        $data['name'] = $request_array->name;
        $data['lattitude'] = $request_array->lattitude;
        $data['longitude'] = $request_array->longitude;

        $check = DB::table('wards')
                ->select('uuid')
                ->where('name', '=', $request_array->name)
                ->where('muncipalityId', '=', $request_array->muncipalityId)
                ->limit(1)->get();
            
        if(count($check) > 0)
        {
            $responseArray['status'] = 0;
            $responseArray['content'] = "";
            $responseArray['mssg'] = "Name exists";
        } else 
        {
            if($request_array->uuid != "")
            {
                $result = DB::table('wards')->where('uuid', '=', $request_array->uuid)->update($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            } else {
                $data['uuid'] = (string) Str::uuid();
                $data['status'] = 1;
                $result = DB::table('wards')->insertGetId($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            }
        }

		return $responseArray;

    }

    public function getWardsByMuncipality(Request $request)
    {
        if($request->muncipalityId != "")
        {
            $wards = DB::table('wards')
                ->where('muncipalityId', '=', $request->muncipalityId)
                ->where('status', '=', 1)
                ->get();
        } else
        {
            $wards = DB::table('wards')
                ->where('status', '=', 1)
                ->get();
        }
        if(count($wards) > 0)
        {
            $responseArray['status'] = 1;
            $responseArray['content'] = $wards;
            $responseArray['mssg'] = "Success";
        } else 
        {
            $responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
        }
        return $responseArray;
    }

    public function wardActions(Request $request)
    {
        $muncipalities = DB::table('wards')->whereIn('uuid', $request->ids)->update(array('status' => $request->status));

        $wards = DB::table('wards')->whereIn('uuid', $request->ids)->where('status', '=', '1')->get();

        if(count($wards) > 0)
		{
			$responseArray['status'] = 1;
			$responseArray['content'] = $wards;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
		}

        return $responseArray;
    }

    ### WARDS END ###

    ### MANDAL POLLING STATIONS START ###
    public function getMandalPollingStations(Request $request)
    {
        if($request->assemblyId != "" && $request->mandalId != "")
        {
            $pStations = DB::table('mandal_polling_stations')
                ->where('assemblyId', '=', $request->assemblyId)
                ->where('mandalId', '=', $request->mandalId)
                ->where('status', '=', 1)
                ->get();
        } else if($request->assemblyId != "")
        {
            $pStations = DB::table('mandal_polling_stations')
                ->where('assemblyId', '=', $request->assemblyId)
                ->where('status', '=', 1)
                ->get();
        } else if($request->mandalId != "")
        {
            $pStations = DB::table('mandal_polling_stations')
                ->where('mandalId', '=', $request->mandalId)
                ->where('status', '=', 1)
                ->get();
        } else {
            $pStations = DB::table('mandal_polling_stations')
                ->where('status', '=', 1)
                ->get();
        }

        if(count($pStations) > 0)
        {
            $responseArray['status'] = 1;
            $responseArray['content'] = $pStations;
            $responseArray['mssg'] = "Success";
        } else 
        {
            $responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
        }
        return $responseArray;
    }

    public function upSertMandalPollingStations(Request $request)
    {
        $request_array = $request;

        $data = array();
        $data['assemblyId'] = $request_array->assemblyId;
        $data['mandalId'] = $request_array->mandalId;
        $data['name'] = $request_array->name;
        $data['number'] = $request_array->number;
        $data['lattitude'] = $request_array->lattitude;
        $data['longitude'] = $request_array->longitude;

        $check = DB::table('mandal_polling_stations')
                ->select('uuid')
                ->where('name', '=', $request_array->name)
                ->where('mandalId', '=', $request_array->mandalId)
                ->where('number', '=', $request_array->number)
                ->limit(1)->get();
            
        if(count($check) > 0)
        {
            $responseArray['status'] = 0;
            $responseArray['content'] = "";
            $responseArray['mssg'] = "Name exists";
        } else 
        {
            if($request_array->uuid != "")
            {
                $result = DB::table('mandal_polling_stations')->where('uuid', '=', $request_array->uuid)->update($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            } else {
                $data['uuid'] = (string) Str::uuid();
                $data['status'] = 1;
                $result = DB::table('mandal_polling_stations')->insertGetId($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            }
        }

		return $responseArray;

    }

    public function mandalPollingStationsActions(Request $request)
    {
        $res = DB::table('mandal_polling_stations')->whereIn('uuid', $request->ids)->update(array('status' => $request->status));

        $pStations = DB::table('mandal_polling_stations')->whereIn('uuid', $request->ids)->where('status', '=', '1')->get();

        if(count($pStations) > 0)
		{
			$responseArray['status'] = 1;
			$responseArray['content'] = $pStations;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
		}

        return $responseArray;
    }

    ### MANDAL POLLING STATIONS END ###

    ### WARD POLLING STATIONS START ###
    public function getWardPollingStations(Request $request)
    {
        if($request->muncipalityId != "" && $request->wardId != "")
        {
            $pStations = DB::table('wards_polling_stations')
                ->where('muncipalityId', '=', $request->muncipalityId)
                ->where('wardId', '=', $request->wardId)
                ->where('status', '=', 1)
                ->get();
        } else if($request->muncipalityId != "")
        {
            $pStations = DB::table('wards_polling_stations')
                ->where('muncipalityId', '=', $request->muncipalityId)
                ->where('status', '=', 1)
                ->get();
        } else if($request->wardId != "")
        {
            $pStations = DB::table('wards_polling_stations')
                ->where('wardId', '=', $request->wardId)
                ->where('status', '=', 1)
                ->get();
        } else {
            $pStations = DB::table('wards_polling_stations')
                ->where('status', '=', 1)
                ->get();
        }

        if(count($pStations) > 0)
        {
            $responseArray['status'] = 1;
            $responseArray['content'] = $pStations;
            $responseArray['mssg'] = "Success";
        } else 
        {
            $responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
        }
        return $responseArray;
    }

    public function upSertWardPollingStations(Request $request)
    {
        $request_array = $request;

        $data = array();
        $data['muncipalityId'] = $request_array->muncipalityId;
        $data['wardId'] = $request_array->wardId;
        $data['name'] = $request_array->name;
        $data['number'] = $request_array->number;
        $data['lattitude'] = $request_array->lattitude;
        $data['longitude'] = $request_array->longitude;

        $check = DB::table('wards_polling_stations')
                ->select('uuid')
                ->where('name', '=', $request_array->name)
                ->where('wardId', '=', $request_array->wardId)
                ->where('number', '=', $request_array->number)
                ->limit(1)->get();
            
        if(count($check) > 0)
        {
            $responseArray['status'] = 0;
            $responseArray['content'] = "";
            $responseArray['mssg'] = "Name exists";
        } else 
        {
            if($request_array->uuid != "")
            {
                $result = DB::table('wards_polling_stations')->where('uuid', '=', $request_array->uuid)->update($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            } else {
                $data['uuid'] = (string) Str::uuid();
                $data['status'] = 1;
                $result = DB::table('wards_polling_stations')->insertGetId($data);

                $responseArray['status'] = 1;
                $responseArray['content'][] = $data;
                $responseArray['mssg'] = "Success";
            }
        }

		return $responseArray;

    }

    public function wardPollingStationsActions(Request $request)
    {
        $res = DB::table('wards_polling_stations')->whereIn('uuid', $request->ids)->update(array('status' => $request->status));

        $pStations = DB::table('wards_polling_stations')->whereIn('uuid', $request->ids)->where('status', '=', '1')->get();

        if(count($pStations) > 0)
		{
			$responseArray['status'] = 1;
			$responseArray['content'] = $pStations;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = "";
			$responseArray['mssg'] = "No data found";
		}

        return $responseArray;
    }

    ### WARD POLLING STATIONS END ###

    ### PARTY SYMBOLS START ###
    public function getPartySymbols(Request $request)
    {
        $symbols = DB::table('partySymbols')->get();
        
        if(count($symbols) > 0)
        {
            $responseArray['status'] = 1;
            $responseArray['content'] = $symbols;
            $responseArray['mssg'] = "Success";
        } else
        {
            $responseArray['status'] = 0;
            $responseArray['content'] = "";
            $responseArray['mssg'] = "No data found";
        }
		
        return $responseArray;

    }

    ### PARTY SYMBOLS END ###

    ### STATES START ###
    public function getStates(Request $request)
    {
        $states = DB::table('states')->where('status', '=', 1)->get();
        
        if(count($states) > 0)
        {
            $responseArray['status'] = 1;
            $responseArray['content'] = $states;
            $responseArray['mssg'] = "Success";
        } else
        {
            $responseArray['status'] = 0;
            $responseArray['content'] = "";
            $responseArray['mssg'] = "No data found";
        }
		
        return $responseArray;

    }

    ### STATES END ###

    ### QUESTION AND OPTIONS MASTERS START ###
    public function upSertQuesOptionsMasters(Request $request)
    {
        $request_array = $request;
        $responseArray = array();

        //print_r($request_array->getContent()); die;
        $data = array();
        $data['name'] = $request_array->name;
        $data['selectionType'] = $request_array->selectionType;
        $data['stateId'] = $request_array->stateId;
        $data['questionType'] = $request_array->questionType;

        //insert start
        if($request_array->uuid == "")
        {
            $check = DB::table('questions_masters')
                ->select('uuid')
                ->where('name', '=', $request_array->name)
                ->limit(1)->get();
            
            if(count($check) > 0)
            {
                $responseArray['status'] = 0;
                $responseArray['content'] = "";
                $responseArray['mssg'] = "Name exists";
                
                return $responseArray;
            } else
            {
                $data['uuid'] = (string) Str::uuid();
                $data['status'] = 1;
                $result = DB::table('questions_masters')->insertGetId($data);
                $servey_uuid = $data['uuid'];
                
                $response = $this->upsertOptions(1, $servey_uuid, $request_array->options);

                $responseArray['status'] = 1;
                $responseArray['content'] = '';
                $responseArray['mssg'] = "Question and options are inserted";
            }   //insert end
        } else 
        {
            $servey_uuid = $request_array->uuid;
            $check = DB::table('questions_masters')
                ->select('uuid')
                ->where('name', '=', $request_array->name)
                ->where('stateId', '=', $request_array->stateId)
                ->limit(1)->get();
            
            if(count($check) == 0)
            {
                $data['status'] = $request_array->status;
                $result = DB::table('questions_masters')->where('uuid', '=', $request_array->uuid)->update($data);

                $response = $this->upsertOptions(2, $servey_uuid, $request_array->options);
                
                $responseArray['status'] = 1;
                $responseArray['content'] = '';
                $responseArray['mssg'] = "Question and options are updated";
            } else 
            {
                $data1['status'] = $request_array->status;
                $result = DB::table('questions_masters')->where('uuid', '=', $request_array->uuid)->update($data1);
                $response = $this->upsertOptions(2, $servey_uuid, $request_array->options);

                $responseArray['status'] = 1;
                $responseArray['content'] = '';
                $responseArray['mssg'] = "Quesion is exists and options are updated";
            }
        }
        return $responseArray;

    }

    public function upsertOptions($action, $uuid, $options)
    {
        if(count($options) > 0)
        {
            if($action == 1)
            {
                foreach($options as $option)
                {
                    $dataOpt = array();
                    $dataOpt['uuid'] = (string) Str::uuid();
                    $dataOpt['questionsMastersId'] = $uuid;
                    $dataOpt['name'] = $option['name'];
                    $dataOpt['symbolCode'] = $option['symbolCode'];
                    $dataOpt['status'] = 1;

                    $result = DB::table('questions_options_masters')->insertGetId($dataOpt);
                }
                return true;
            } else if($action == 2)
            {
                foreach($options as $option)
                {
                    $dataOpt = array();

                    $dataOpt['name'] = $option['name'];
                    $dataOpt['symbolCode'] = $option['symbolCode'];

                    // $check_opt = DB::table('questions_options_masters')
                    //         ->select('uuid')
                    //         ->where('name', '=', $option['name'])
                    //         ->where('questionsMastersId', '=', $uuid)
                    //         ->limit(1)->get();

                    if($option['uuid'] != '')
                    {
                        $dataOpt['status'] = $option['status'];
                        $result = DB::table('questions_options_masters')->where('uuid', '=', $option['uuid'])->update($dataOpt);
                    } else
                    {
                        $dataOpt['uuid'] = (string) Str::uuid();
                        $dataOpt['questionsMastersId'] = $uuid;
                        $dataOpt['status'] = 1;

                        $result = DB::table('questions_options_masters')->insertGetId($dataOpt);
                    }
                }
                return true;
            }
        } else {
            return true;
        }
    }

    public function getQuesOptionsMasters(Request $request)
    {
        if($request->stateId != "")
        {
            $responseArray = array();
            $questions = DB::table('questions_masters')
                    ->select('uuid', 'name', 'questionType', 'selectionType', 'stateId')
                    ->where('stateId', '=', $request->stateId)
                    ->where('status', '=', 1)
                    ->get();
            
            if(count($questions) > 0)
            {
                $data = array();
                $a = 0;
                foreach($questions as $ques)
                {
                    $data[$a] = $ques;

                    $options = DB::table('questions_options_masters')
                                ->select('uuid', 'name', 'questionsMastersId', 'symbolCode')
                                ->where('questionsMastersId', '=', $ques->uuid)
                                ->where('status', '=', 1)
                                ->get();
                    foreach($options as $opt)
                    {
                        $data[$a]->options = $options;
                    }     
                    $a++;
                }
                
                $responseArray['status'] = 1;
                $responseArray['content'] = $data;
                $responseArray['mssg'] = "Success";
                // echo "<pre>";
                // print_r($data); die;
            } else
            {
                $responseArray['status'] = 0;
                $responseArray['content'] = "";
                $responseArray['mssg'] = "No data found";
            }
        }
        
		
        return $responseArray;

    }

    ### QUESTION AND OPTIONS MASTERS END ###

    ### SURVEYS START ###
    public function upSertSurvey(Request $request)
    {
        $request_array = $request;

        $data = array();
        $data['areaType'] = $request_array->areaType;
        $data['companyId'] = $request_array->companyId;
        $data['distanceGap'] = $request_array->distanceGap;
        $data['durationGap'] = $request_array->durationGap;
        $data['name'] = $request_array->name;
        $data['startDate'] = $request_array->startDate;
        $data['stateId'] = $request_array->stateId;
        $data['type'] = $request_array->type;
        $data['createdBy'] = $request_array->createdBy;
        $data['endDate'] = $request_array->endDate;
        $data['fileDuration'] = $request_array->fileDuration;

        if($request_array->uuid != "")
        {
            $data['status'] = $request_array->status;
            $data['modifiedDate'] = date("Y-m-d H:i:s");
            $result = DB::table('surveys')->where('uuid', '=', $request_array->uuid)->update($data);
            
            $res = $this->insertSurveyDependents($request_array->uuid, $request_array);
            if($res)
            {
                $responseArray['status'] = 1;
                $responseArray['content'] = '';
                $responseArray['mssg'] = "Success";
            }
        } else {
            $data['uuid'] = (string) Str::uuid();
            $data['status'] = 1;
            $data['createdDate'] = date("Y-m-d H:i:s");
            //$data['createdDate'] = date('Y-m-d H:i:s');;
            $result = DB::table('surveys')->insertGetId($data);
            $res = $this->insertSurveyDependents($data['uuid'], $request_array);
            if($res)
            {
                $responseArray['status'] = 1;
                $responseArray['content'] = '';
                $responseArray['mssg'] = "Success";
            }
        }
		return $responseArray;

    }

    public function insertSurveyDependents($uuid, $data)
    {
        if(count($data->areaList))
        {
            DB::table('surveys_areas')->where('surveyId', '=', $uuid)->delete();
            foreach($data->areaList as $area)
            {
                DB::table('surveys_areas')->insert([
                    'surveyId' => $uuid,
                    'assemblyMuncipalityId' => $area
                ]);
            }
        }
        if(count($data->userList))
        {
            DB::table('surveys_employees')->where('surveyId', '=', $uuid)->delete();
            foreach($data->userList as $user)
            {
                DB::table('surveys_employees')->insert([
                    'surveyId' => $uuid,
                    'employeeId' => $user
                ]);
            }
        }
        if(count($data->question))
        {
            DB::table('surveys_questions')->where('surveyId', '=', $uuid)->delete();
            foreach($data->question as $squestions)
            {
                DB::table('surveys_questions')->insert([
                    'surveyId' => $uuid,
                    'uuid' => (string) Str::uuid(),
                    'questionsMastersId' => $squestions['questionsMastersId'],
                    'sortId' => $squestions['sortId'],
                    'assemblyMuncipalityId' => $squestions['assemblyMuncipalityId']
                ]);
            }
        }
        return true;
    }

    public function getSurvey(Request $request)
    {
        //\DB::enableQueryLog();
        $employees = [];
        if($request->employeeId != "")
        {
            $surveys = DB::table('surveys')
                ->join('surveys_employees', 'surveys_employees.surveyId', '=', 'surveys.uuid')
                ->where('surveys_employees.employeeId', '=', $request->employeeId)
                ->select('surveys.*')
                ->get();
        }
        
        if(count($surveys))
        {
			$responseArray['status'] = 1;
			$responseArray['content'] = $surveys;
			$responseArray['mssg'] = "Success";
		} else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = array();
			$responseArray['mssg'] = "Fail";
		}
        return $responseArray;
        //dd(\DB::getQueryLog());
        //die;

    }

    public function getSurveyDetails(Request $request)
    {
        if($request->employeeId != "" && $request->surveyId != "")
        {
            $data = array();
            $survey_areas = array();

            $survey_areas = DB::table('surveys_areas')
                                ->join('surveys_employees', 'surveys_employees.surveyId', '=', 'surveys_areas.surveyId')
                                ->where('surveys_employees.employeeId', '=', $request->employeeId)
                                ->where('surveys_employees.surveyId', '=', $request->surveyId)
                                ->select('surveys_areas.assemblyMuncipalityId')
                                ->get();

            $questions = DB::table('questions_masters')
                            ->join('surveys_questions', 'surveys_questions.questionsMastersId', '=', 'questions_masters.uuid')
                            ->select('questions_masters.uuid', 'questions_masters.name', 'questions_masters.questionType', 'questions_masters.selectionType', 'questions_masters.stateId',
                                    'surveys_questions.sortId', 'surveys_questions.assemblyMuncipalityId')
                            ->where('surveys_questions.surveyId', '=', $request->surveyId)
                            ->where('status', '=', 1)
                            ->get();

            if(count($questions) >0)
            {
                $a = 0;
                foreach($questions as $ques)
                {
                    $data[$a] = $ques;

                    $options = DB::table('questions_options_masters')
                                ->select('uuid', 'name', 'questionsMastersId', 'symbolCode')
                                ->where('questionsMastersId', '=', $ques->uuid)
                                ->where('status', '=', 1)
                                ->get();
                    foreach($options as $opt)
                    {
                        $data[$a]->options = $options;
                    }     
                    $a++;
                }
            }
            
            $responseArray['status'] = 1;
			$responseArray['content'][] = array(
                "surveyAreas" => $survey_areas,
                "surveyQuestions" => $data
            );
			$responseArray['mssg'] = "Success";
        } else 
		{
			$responseArray['status'] = 0;
			$responseArray['content'] = array();
			$responseArray['mssg'] = "Fail";
		}
        return $responseArray;

    }

    ### SURVEYS END ###

    ### SURVEY RECORDS START ###
    public function insertSurveyRecords(Request $request)
    {
        $request_array = $request;

        if($request_array->surveyId != "")
        {
            $check = DB::table('survey_records')
                ->select('uuid')
                ->where('mobileRecordId', '=', $request_array->mobileRecordId)
                ->limit(1)->get();
            if(count($check) == 0)
            {
                $data = array();
                $data['surveyId'] = $request_array->surveyId;
                $data['mobileRecordId'] = $request_array->mobileRecordId;
                $data['assemblyMuncipalityId'] = $request_array->assemblyMuncipalityId;
                $data['accuracy'] = $request_array->accuracy;
                $data['fileDuration'] = $request_array->fileDuration;
                $data['latitude'] = $request_array->latitude;
                $data['longitude'] = $request_array->longitude;
                $data['deviceInfo'] = $request_array->deviceInfo;
                $data['imei'] = $request_array->imei;
                $data['appVer'] = $request_array->appVer;
                $data['mandalWardId'] = $request_array->mandalWardId;
                $data['votMobile'] = $request_array->votMobile;
                $data['votName'] = $request_array->votName;
                $data['votFather'] = $request_array->votFather;
                $data['pollingStationId'] = $request_array->pollingStationId;
                $data['natId'] = $request_array->natId;
                $data['ageId'] = $request_array->ageId;
                $data['castId'] = $request_array->castId;
                $data['religId'] = $request_array->religId;
                $data['profId'] = $request_array->profId;
                $data['qualId'] = $request_array->qualId;
                $data['genderId'] = $request_array->genderId;
                $data['createdBy'] = $request_array->createdBy;
                $data['mobileDate'] = $request_array->mobileDate;
                $data['status'] = 1;
                $data['uuid'] = (string) Str::uuid();
                $data['mobileDate'] = $request_array->mobileDate;
                $data['insertedDate'] = date("Y-m-d H:i:s");
                $result = DB::table('survey_records')->insertGetId($data);

                if($result)
                {
                    if(count($request_array->questAnsList) > 0)
                    {
                        foreach($request_array->questAnsList as $qans)
                        {
                            DB::table('survey_records_ques_ans')->insert([
                                'uuid' => (string) Str::uuid(),
                                'surveyId' => $request_array->surveyId,
                                'surveyRecordId' => $data['uuid'],
                                'questionsMastersId' => $qans['questionsMastersId'],
                                'optionId' => $qans['optionId']
                            ]);
                        }
                    }
                }
            }
            $responseArray['status'] = 1;
            $responseArray['content'] = '';
            $responseArray['mssg'] = "Success";
            
            return $responseArray;
        }

    }

    public function uploadLocUrl(Request $request)
    {
        if($request->file('locURL'))
        {
            $file = $request->file('locURL');
            $allowed_types = array("image/png", "image/jpg", "image/jpeg");
            $destinationPath = 'uploads/records';

            $fileName = time()."_".str_replace(" ", "_", $file->getClientOriginalName());
            $ext = $file->getMimeType();
            //echo url("/"); die;
            if(in_array($ext, $allowed_types))
            {
                $res = $file->move($destinationPath, $fileName);
                if($res)
                {
                    $updateData['locURL'] = $fileName;
                    $result = DB::table('survey_records')->where('surveyId', '=', $request->surveyId)->update(array('locURL' => $fileName));
                    $responseArray['status'] = 1;
                    $responseArray['content'] = $fileName;
                    $responseArray['mssg'] = "Success";
                }
            }
        } else {
            $responseArray['status'] =0;
            $responseArray['content'] = '';
            $responseArray['mssg'] = "No file found";
        }
        return $responseArray;
    }

    ### SURVEY RECORDS END ###

    ### USER LOGIN START ###
    public function userLogin(Request $request)
    {
        //echo Hash::make("suryass"); 
        // $sdfs = '$2y$10$iBHudRncN.XUXjdDzwWKc.TC2oBDIE2/0oaWF7VdtXj3CrarXTCwy';
        // if (Hash::check('suryass', $sdfs)) {
        //     echo "mathced";
        // } else echo 'not';
        // die;
        $responseArray = array();
        if($request->mobileNumber != "" && $request->password != "")
        {
            $user_auth = DB::table('employees')
                            ->where('mobileNumber', '=', $request->mobileNumber)
                            ->limit(1)->get();
            
            if(count($user_auth) > 0)
            {
                if($user_auth[0]->status == 0)
                {
                    $responseArray['status'] = 0;
                    $responseArray['content'] = '';
                    $responseArray['mssg'] = "User is Deactivated/Blocked";
                } else
                {
                    if (Hash::check($request->password, $user_auth[0]->password))
                    {
                        $login_token = Str::random(60);
                        $user_auth[0]->loginToken = $login_token;
                        unset($user_auth[0]->password);
                        DB::table('employees')->where('uuid', '=', $user_auth[0]->uuid)->update(array('loginToken' => $login_token));

                        $responseArray['status'] = 0;
                        $responseArray['content'][] = $user_auth[0];
                        $responseArray['mssg'] = "Success";
                    } else
                    {
                        $responseArray['status'] = 0;
                        $responseArray['content'] = '';
                        $responseArray['mssg'] = "Invalid login details";
                    }
                }
            } else
            {
                $responseArray['status'] = 0;
                $responseArray['content'] = '';
                $responseArray['mssg'] = "User not found";
            }
            return $responseArray;
        }
    }

    ### USER LOGIN END ###

    ### OTP START ###
    public function sendOtp(Request $request)
    {
        if($request->mobileNumber != "")
        {
            $user_auth = DB::table('employees')
                        ->where('mobileNumber', '=', $request->mobileNumber)
                        ->limit(1)->get();

            if(count($user_auth) == 0)
            {
                $responseArray['status'] = 0;
                $responseArray['content'] = '';
                $responseArray['mssg'] = "Your mobile number is Deactivated/Blocked. Please contact admin";
            } else if($user_auth[0]->status == 0)
            {
                $responseArray['status'] = 0;
                $responseArray['content'] = '';
                $responseArray['mssg'] = "User is blocked/ deactivated";
            } else if($user_auth[0]->deviceId == $request->deviceId || $user_auth[0]->deviceId == "")
            {
                $otpVal = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $endpoint = "https://2factor.in/API/V1/852a2b00-032d-11ed-9c12-0200cd936042/SMS/+91".$request->mobileNumber."/".$otpVal."/OTPService";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                curl_setopt($ch, CURLOPT_POST, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
                $response = curl_exec ($ch);
                $err = curl_error($ch);  //if you need
                curl_close ($ch);
                $response_json = json_decode($response);
                if(isset($response_json->Status) && $response_json->Status == 'Success')
                {
                    $otpData = array();

                    $otpData['uuid'] = (string) Str::uuid();
                    $otpData['employeeId'] = $user_auth[0]->uuid;
                    $otpData['device'] = $request->deviceInfo;
                    $otpData['otpCode'] = $otpVal;
                    $otpData['createdTime'] = date("Y-m-d H:i:s");

                    $result = DB::table('otp_master')->insertGetId($otpData);
                    if($result)
                    {
                        $responseArray['status'] = 1;
                        $responseArray['content'][] = array('referenceId' => $otpData['uuid']);
                        $responseArray['mssg'] = 'Success';
                    }
                } else
                {
                    $responseArray['status'] = 0;
                    $responseArray['content'] = '';
                    $responseArray['mssg'] = 'Otp failed';
                }
            } else if($user_auth[0]->deviceId !== $request->deviceId)
            {
                $responseArray['status'] = 0;
                $responseArray['content'] = '';
                $responseArray['mssg'] = "You are already logged in on another device. Please contact your Team Leader";
            }
            return $responseArray;
        }
    }

    public function verifyOtp(Request $request)
    {
        if($request->referenceId != '')
        {
            $check_otp = DB::table('otp_master')
                        ->where('uuid', '=', $request->referenceId)
                        ->limit(1)->get();

            if(count($check_otp) > 0)
            {
                if($check_otp[0]->otpCode == $request->otpCode)
                {
                    $updateEmp = array();

                    $updateEmp['deviceId'] = $request->deviceId;
                    $updateEmp['appCode'] = $request->appCode;
                    $updateEmp['appVersion'] = $request->appVersion;
                    $updateEmp['deviceInfo'] = $request->deviceInfo;

                    $login_token = Str::random(60);

                    DB::table('employees')->where('uuid', '=', $check_otp[0]->employeeId)->update(array('loginToken' => $login_token));

                    $updt = DB::table('employees')->where('uuid', '=', $check_otp[0]->employeeId)->update($updateEmp);
                    
                    $get_emp = DB::table('employees')
                                        ->where('uuid', '=', $check_otp[0]->employeeId)
                                        ->limit(1)->get();
                    if(count($get_emp) > 0)
                    {
                        unset($get_emp[0]->password);
                        $responseArray['status'] = 1;
                        $responseArray['content'][] = $get_emp;
                        $responseArray['mssg'] = 'Success';
                    } else
                    {
                        $responseArray['status'] = 0;
                        $responseArray['content'] = '';
                        $responseArray['mssg'] = 'No data found';
                    }
                } else
                {
                    $responseArray['status'] = 0;
                    $responseArray['content'] = '';
                    $responseArray['mssg'] = 'OTP entered is incorrect';
                }
            } else
            {
                $responseArray['status'] = 0;
                $responseArray['content'] = '';
                $responseArray['mssg'] = 'Fail';
            }
            return $responseArray;
        }
    }

    ### OTP END ###

    public function checkUserToken(Request $request)
    {
        return $next($request);
    }

}
