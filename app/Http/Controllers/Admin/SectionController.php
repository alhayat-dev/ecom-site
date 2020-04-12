<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    public function sections()
    {
        Session::put('page', 'sections');
        $sections = Section::get();
        return view('admin.sections.section')->with(compact('sections'));
    }

    public function updateSectionStatus(Request $request)
    {
        if ($request->ajax()){
            $data = $request->all();
            if ($data['status'] == 'Active'){
                $status = 0;
            }else{
                $status = 1;
            }

            Section::where('id', $data['section_id'])->update([
                'status' => $status
            ]);
            return response()->json(['status' => $status, 'section_id' => $data['section_id']]);
        }
    }
}
