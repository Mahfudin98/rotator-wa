<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Rotator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RotatorController extends Controller
{
    public function index()
    {
        $link = Link::orderBy('id', 'DESC')->get();
        return view('rotator', compact('link'));
    }

    public function create()
    {
        return view('single');
    }

    public function postSingle(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'type_pixel' => 'nullable',
            'pixel' => 'nullable',
            'link' => 'required|unique:links',
            'pesan' => 'required',
            'email' => 'required',
        ]);
        // $links = Str::link($request->link);

        $link = Link::create([
            'name' => $request->name,
            'phone' => preg_replace("/^0/", "62", $request->phone),
            'type_pixel' => $request->type_pixel,
            'pixel' => $request->pixel,
            'link' => Str::slug($request->link),
            'pesan' => $request->pesan,
            'email' => $request->email,
        ]);

        return redirect()->back()->with(['success' => 'https://lsskincare.id/'.$link->link]);
        // dd($link);
    }

    public function postRotator(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'type_pixel' => 'nullable',
            'pixel' => 'nullable',
            'link' => 'required|unique:links',
            'pesan' => 'required',
            'email' => 'required',
            'urutan' => 'required',
        ]);

        try {
            $link = Link::create([
                'name' => $request->name,
                'type_pixel' => $request->type_pixel,
                'pixel' => $request->pixel,
                'link' => Str::slug($request->link),
                'link_type' => $request->link_type,
                'pesan' => $request->pesan,
                'email' => $request->email,
            ]);

            $rotator = Link::find($link['id']);
            $rotators = Rotator::create([
                'link_id' => $rotator,
                'urutan' => $request->urutan,
                'name' => $request->csname,
                'phone' => preg_replace("/^0/", "62", $request->phone),
            ]);

            $rotators = Rotator::where('link_id', $rotator);

            $rotator->update([
                'jumlah_rotator' => $rotators->count,
            ]);

            DB::commit();

            return redirect()->back()->with(['success' => 'https://lsskincare.id/'.$link->link]);
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
