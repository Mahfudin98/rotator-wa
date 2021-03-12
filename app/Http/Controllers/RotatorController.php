<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Rotator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

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
            $data = $request->all();
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

            if ($data['csname'] != null) {
                foreach ($data['csname'] as $item => $value) {
                    $data2 = array(
                        'link_id' => $rotator->id,
                        'urutan' => $data['urutan'][$item],
                        'name' => $data['csname'][$item],
                        'phone' => preg_replace("/^0/", "62", $data['phone'][$item]),
                    );
                    $rotators = Rotator::create($data2);
                    $rotators = Rotator::where('link_id', $rotator->id)->max('urutan');

                    $rotator->update([
                        'jumlah_rotator' => $rotators,
                    ]);
                }
            }

            return redirect()->back()->with(['success' => 'https://lsskincare.id/'.$link->link]);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function showRotator($id)
    {
        $link = Link::find($id);
        $rotator = Rotator::where('link_id', $id)->get();

        return view('showRotator', compact('link', 'rotator'));
    }

    public function showUrl($link)
    {
        $links = Link::where('link', $link)->first();
        // $rotator = $links->rotator()->where('link_id', $links->id)->first();
        // $rotator = Rotator::all();
        $urut = Rotator::all()->where('link_id', $links->id)->random();

        return view('link', compact('links', 'urut'));
    }
}
