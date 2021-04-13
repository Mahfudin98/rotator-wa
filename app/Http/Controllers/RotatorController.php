<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Link;
use App\Models\Rotator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Helpers\UserSystemInfoHelper;
use Carbon\Carbon;

class RotatorController extends Controller
{
    public function dashboard()
    {
        $link = Link::orderBy('id', 'DESC');
        if (request()->q != '') {
            $link = $link->where('pixel', 'LIKE', '%' . request()->q . '%');
        }
        $link = $link->paginate(10);

        return view('dashboard', compact('link'));
    }
    public function index()
    {
        $link = Link::orderBy('id', 'DESC');
        if (request()->q != '') {
            $link = $link->where('pixel', request()->q);
        }

        $link = $link->paginate(10);

        return view('rotator', compact('link'));
    }

    public function edit($id)
    {
        $link = Link::find($id);
        $rotator = Rotator::where('link_id', $link->id)->orderBy('urutan', 'asc')->get();
        $urut = Rotator::where('link_id', $link->id)->orderBy('urutan', 'desc')->first();

        return view('editrotator', compact('link', 'rotator', 'urut'));
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

        return redirect()->back()->with(['success' => 'https://orderan.lsstore.id/cs/'.$link->link]);
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

            return redirect()->back()->with(['success' => 'https://orderan.lsstore.id/cs/'.$link->link]);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function updateRotator(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'nullable',
            'type_pixel' => 'nullable',
            'pixel' => 'nullable',
            'link' => 'required',
            'pesan' => 'required',
            'email' => 'required',
        ]);

        $link = Link::find($id);

        try {
            $link->update([
                'name' => $request->name,
                'type_pixel' => $request->type_pixel,
                'pixel' => $request->pixel,
                'phone' => $request->phone,
                'link' => Str::slug($request->link),
                'link_type' => $request->link_type,
                'pesan' => $request->pesan,
                'email' => $request->email,
                'status' => $request->status
            ]);

            return redirect()->route('dashboard')->with(['success' => 'Data berhasil diperbarui']);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function tambah($link)
    {
        $links = Link::where('link', $link)->first();

        return view('add', compact('links'));
    }

    public function postTambah(Request $request)
    {
        $this->validate($request, [
            'csname' => 'required',
            'phone' => 'required',
            'urutan' => 'required',
        ]);

        try {
            $data = $request->all();

            if ($data['csname'] != null) {
                foreach ($data['csname'] as $item => $value) {
                    $data2 = array(
                        'link_id' => $request->link_id,
                        'urutan' => $data['urutan'][$item],
                        'name' => $data['csname'][$item],
                        'phone' => preg_replace("/^0/", "62", $data['phone'][$item]),
                    );
                    $rotators = Rotator::create($data2);
                    $rotators = Rotator::where('link_id', $request->link_id)->max('urutan');

                    $link = Link::where('id', $request->link_id)->first();
                    $link->update([
                        'jumlah_rotator' => $rotators,
                    ]);
                }
            }

            return redirect()->back()->with(['success' => 'CS Telah berhasil ditambah']);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function guestShowRotator($id)
    {
        $link = Link::find($id);
        $rotator = Rotator::where('link_id', $id)->orderBy('urutan', 'asc')->get();
        $click = Click::where('url_name', $link->link)->orderBy('click_time', 'desc');
        if (request()->q != '') {
            $click = $click->where('click_time', 'LIKE', '%' . request()->q . '%');
        }
        $click = $click->paginate(50);
        return view('guestshow', compact('link', 'rotator', 'click'));
    }

    public function showRotator($id)
    {
        $link = Link::find($id);
        $rotator = Rotator::where('link_id', $id)->orderBy('urutan', 'asc')->get();
        $click = Click::where('url_name', $link->link)->orderBy('click_time', 'desc');
        if (request()->q != '') {
            $click = $click->where('click_time', 'Like', '%' . request()->q . '%');
        }
        $click = $click->paginate(50);
        return view('showRotator', compact('link', 'rotator', 'click'));
    }

    public function updateRot(Request $request, $id)
    {
        $rotator = Rotator::find($id);
        $rotator->update([
            'link_id' => $request->link_id,
            'urutan' => $request->urutan,
            'name' => $request->csname,
            'phone' => preg_replace("/^0/", "62", $request->phone),
        ]);

        $rot = Rotator::where('link_id', $rotator->link_id)->max('urutan');
        $link = Link::where('id', $rotator->link_id)->first();
        $link->update([
            'jumlah_rotator' => $rot,
        ]);

        return redirect()->back()->with(['success' => 'Data Berhasil diperbahauri']);
    }

    public function deleteCS($id)
    {
        $rotator = Rotator::find($id);
        $rotator->delete();
        $rot = Rotator::where('link_id', $rotator->link_id)->max('urutan');
        $link = Link::where('id', $rotator->link_id)->first();
        $link->update([
            'jumlah_rotator' => $rot,
        ]);

        return redirect()->back()->with(['success' => 'CS Berhasil dihapus']);
    }

    public function showUrl($link)
    {
        // get ip
        $getip = UserSystemInfoHelper::get_ip();
        $getbrowser = UserSystemInfoHelper::get_browsers();
        $getdevice = UserSystemInfoHelper::get_device();
        $getos = UserSystemInfoHelper::get_os();


        $links = Link::where('link', $link)->first();
        $urut = $links->jumlah_rotator;
        $rotator = Rotator::where('link_id', $links->id)->orderBy('urutan', 'asc')->first();
        $click = Click::where('url_name', $link)->latest()->first();
        if ($links->link_type == 1) {
            if ($click != null) {
                $nomor = DB::select('select * from rotators where link_id ='.$links->id. ' and urutan='.$urut);
                if ($click->urut < $urut) {
                    $print = $click->urut+1;
                    $nomor = DB::select('select * from rotators where link_id ='.$links->id. ' and urutan='.$print);
                    $create = Click::create([
                        'click_time' => Carbon::now(),
                        'url_name' => $links->link,
                        'urut'  => $print,
                        'referrer' => $getbrowser,
                        'user_device' => $getdevice.','. $getos,
                        'ip_address' => $getip
                    ]);

                    $update = $links->update([
                        'count_link' => $links->count_link+1,
                    ]);

                } elseif ($click->urut > $urut) {
                    $print = 1;
                    $nomor = DB::select('select * from rotators where link_id ='.$links->id. ' and urutan='.$print);
                    $create = Click::create([
                        'click_time' => Carbon::now(),
                        'url_name' => $links->link,
                        'urut'  => $print,
                        'referrer' => $getbrowser,
                        'user_device' => $getdevice.','. $getos,
                        'ip_address' => $getip
                    ]);
                    $update = $links->update([
                        'count_link' => $links->count_link+1,
                    ]);

                }else {
                    $nomor = DB::select('select * from rotators where link_id ='.$links->id. ' and urutan='.$rotator->urutan);
                    $create = Click::create([
                        'click_time' => Carbon::now(),
                        'url_name' => $links->link,
                        'urut'  => $rotator->urutan,
                        'referrer' => $getbrowser,
                        'user_device' => $getdevice.','. $getos,
                        'ip_address' => $getip
                    ]);
                    $update = $links->update([
                        'count_link' => $links->count_link+1,
                    ]);

                }
            } else {
                $create = Click::create([
                    'click_time' => Carbon::now(),
                    'url_name' => $links->link,
                    'urut'  => $rotator->urutan,
                    'referrer' => $getbrowser,
                    'user_device' => $getdevice.','. $getos,
                    'ip_address' => $getip
                ]);

                $nomor = DB::select('select * from rotators where link_id ='.$links->id. ' and urutan='.$create->urut);
                $update = $links->update([
                    'count_link' => $links->count_link+1,
                ]);
            }
        } elseif ($links->link_type == 0) {
            $nomor = Link::where('link', $link)->first();
            $create = Click::create([
                'click_time' => Carbon::now(),
                'url_name' => $nomor->link,
                'urut'  => $nomor->jumlah_rotator,
                'referrer' => $getbrowser,
                'user_device' => $getdevice.','. $getos,
                'ip_address' => $getip
            ]);
        }


        // $jatah = $rotator;

        // dd($nomor);
        return view('link', compact('nomor', 'links'));
    }
}
