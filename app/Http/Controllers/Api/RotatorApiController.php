<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UserSystemInfoHelper;
use App\Http\Controllers\Controller;
use App\Models\Click;
use App\Models\Link;
use App\Models\Rotator;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RotatorApiController extends Controller
{
    function rotatorClick($url)
    {
        $links = Link::where('link', $url)->first();
        if (!$links) {
            return response()->json(['status' => false, 'data' => "Url tidak ditemukan!"], 404);
        }

        $getip = UserSystemInfoHelper::get_ip();
        $getbrowser = UserSystemInfoHelper::get_browsers();
        $getdevice = UserSystemInfoHelper::get_device();
        $getos = UserSystemInfoHelper::get_os();

        $urut = $links->jumlah_rotator;
        $rotator = Rotator::where('link_id', $links->id)->where('status', 1)->orderBy('urutan', 'asc')->first();
        $click = Click::where('url_name', $url)->latest()->first();
        $website = null;

        if ($links->website_id) {
            $websites = Website::where('website_id', $links->website_id)->first();
            $website = $websites->website_name;
        }
        if ($links->link_type == 1) {
            $nomor = DB::select('select * from rotators where link_id =' . $links->id . ' and urutan=' . $urut);
            if ($click != null) {
                if ($click->urut < $urut) {
                    $print = $click->urut + 1;
                    $nomor = DB::select('select * from rotators where link_id =' . $links->id . ' and urutan=' . $print);
                    $create = Click::create([
                        'click_time' => Carbon::now(),
                        'website_name' => $website,
                        'url_name' => $links->link,
                        'urut'  => $print,
                        'rotator_id' => $rotator->id,
                        'referrer' => $getbrowser,
                        'user_device' => $getdevice . ',' . $getos,
                        'ip_address' => $getip
                    ]);

                    $update = $links->update([
                        'count_link' => $links->count_link + 1,
                    ]);
                } elseif ($click->urut > $urut) {
                    $print = 1;
                    $nomor = DB::select('select * from rotators where link_id =' . $links->id . ' and urutan=' . $print);
                    $create = Click::create([
                        'click_time' => Carbon::now(),
                        'website_name' => $website,
                        'url_name' => $links->link,
                        'urut'  => $print,
                        'rotator_id' => $rotator->id,
                        'referrer' => $getbrowser,
                        'user_device' => $getdevice . ',' . $getos,
                        'ip_address' => $getip
                    ]);
                    $update = $links->update([
                        'count_link' => $links->count_link + 1,
                    ]);
                } else {
                    $create = Click::create([
                        'click_time' => Carbon::now(),
                        'website_name' => $website,
                        'url_name' => $links->link,
                        'urut'  => $rotator->urutan,
                        'rotator_id' => $rotator->id,
                        'referrer' => $getbrowser,
                        'user_device' => $getdevice . ',' . $getos,
                        'ip_address' => $getip
                    ]);

                    $nomor = DB::select('select * from rotators where link_id =' . $links->id . ' and urutan=' . $create->urut);
                    $update = $links->update([
                        'count_link' => $links->count_link + 1,
                    ]);
                }
            } else {
                $create = Click::create([
                    'click_time' => Carbon::now(),
                    'website_name' => $website,
                    'url_name' => $links->link,
                    'urut'  => $rotator->urutan,
                    'rotator_id' => $rotator->id,
                    'referrer' => $getbrowser,
                    'user_device' => $getdevice . ',' . $getos,
                    'ip_address' => $getip
                ]);

                $nomor = DB::select('select * from rotators where link_id =' . $links->id . ' and urutan=' . $create->urut);
                $update = $links->update([
                    'count_link' => $links->count_link + 1,
                ]);
            }
        } else {
            $nomor = Link::where('link', $url)->first();
            $create = Click::create([
                'click_time' => Carbon::now(),
                'website_name' => $website,
                'url_name' => $nomor->name,
                'urut'  => $nomor->jumlah_rotator,
                'rotator_id' => $nomor->id,
                'referrer' => $getbrowser,
                'user_device' => $getdevice . ',' . $getos,
                'ip_address' => $getip
            ]);
            $update = $links->update([
                'count_link' => $links->count_link + 1,
            ]);
        }

        $number = $links->link_type == 1 ? $nomor[0]->phone : $links->phone;
        $csName = $links->link_type == 1 ? $nomor[0]->name : $links->link;
        $message = urlencode(strtolower('Hallo ' . $csName . ', ' . $links->pesan));
        $urutan = $links->link_type == 1 ? $nomor[0]->urutan : 1;
        $redirect = 'https://wa.me/' . $number . '?text=' . $message;
        $data = [
            'cs_urutan' => $urutan,
            'cs_name' => $csName,
            'cs_phone' => preg_replace('/^62/', '0', $number),
            'cs_link' => $redirect,
        ];
        return response()->json(['status' => true, 'data' => $data], 200);
    }

    function getRotator()
    {
        $link = Link::orderBy('created_at', 'DESC');
        if (request()->q != '') {
            $link = $link->where('name', request()->q);
        }

        $link = $link->get();
        $data = [];
        foreach ($link as $value) {
            $type = '';
            switch ($value->link_type) {
                case 0:
                    $type = 'Single';
                    break;
                case 1:
                    $type = 'Urutan';
                    break;
                case 2:
                    $type = 'Random';
                    break;
            }
            $number = $value->link_type == 1 ? null : preg_replace('/^62/', '0', $value->phone);
            $website = Website::where('website_id', $value->website_id)->first();
            $data[] = [
                'id'           => $value->id,
                'website'      => $website ? $website->website_name : null,
                'website_id'   => $value->website_id,
                'name'         => $value->name,
                'type'         => $type,
                'type_id'      => $value->link_type,
                'link'         => $value->link,
                'message'      => $value->pesan,
                'phone'        => $number,
                'count_click'  => $value->count_link,
                'status'       => $value->status,
                'created'      => Carbon::parse($value->created_at)->translatedFormat('d F Y'),
            ];
        }

        return response()->json(['status' => true, 'data' => $data], 200);
    }

    function getIdRotator($url)
    {
        $link = DB::table('links')
            ->leftJoin('websites', 'links.website_id', '=', 'websites.website_id')
            ->select(
                'websites.website_icon',
                'websites.website_name',
                'websites.website_link',
                'links.*',
            )
            ->where('links.link', $url)
            ->first();
        $type = '';
        switch ($link->link_type) {
            case 0:
                $type = 'Single';
                break;
            case 1:
                $type = 'Urutan';
                break;
            case 2:
                $type = 'Random';
                break;
        }
        $data = [
            'website_id'     => $link->website_id,
            'website_icon'   => $link->website_icon,
            'website_name'   => $link->website_name,
            'website_link'   => $link->website_link,
            'rotator_id'     => $link->id,
            'name'           => $link->name,
            'phone'          => $link->phone != null ? preg_replace('/^62/', '0', $link->phone) : null,
            'message'        => $link->pesan,
            'link'           => $link->link,
            'type'           => $type,
            'jumlah_rotator' => $link->jumlah_rotator,
            'count_click'    => $link->count_link,
            'status'         => $link->status == 1 ? 'Aktif' : 'Tidak Aktif',
            'created'        => Carbon::parse($link->created_at)->translatedFormat('d F Y'),
        ];

        return response()->json(['status' => true, 'data' => $data], 200);
    }

    function getIDRotatorList($url)
    {
        $link = Link::where('link', $url)->first();
        $rotator = Rotator::where('link_id', $link->id)->where('status', 1)->orderBy('urutan', 'asc')->get();
        $data = [];
        foreach ($rotator as $value) {
            $data[] = [
                'id' => $value->id,
                'urutan' => $value->urutan,
                'name' => $value->name,
                'phone' => preg_replace('/^62/', '0',  $value->phone),
            ];
        }
        return response()->json(['status' => true, 'data' => $data], 200);
    }

    function getClickID($url)
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');
        $link = Link::where('link', $url)->first();
        $click = Click::where('url_name', $link->link)->orderBy('created_at', 'DESC');
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d');
            $end = Carbon::parse($date[1])->format('Y-m-d');
        }
        $click = $click->whereBetween('click_time', [$start, $end])->get();
        $clicks = [];
        foreach ($click as $value) {
            $cs = Rotator::where('link_id', $link->id)->where('urutan', $value->urut)->first();
            $clicks[] = [
                'date_time' => Carbon::parse($value->created_at)->translatedFormat('d F Y H:i:s'),
                'cs' => $cs != null ? $cs->name : $link->name,
                'browser' => $value->referrer,
                'device' => $value->user_device,
                'ip' => $value->ip_address,
            ];
        }

        if ($click == null) {
            return response()->json(['status' => true, 'data' => null], 200);
        }

        return response()->json(['status' => true, 'data' => $clicks], 200);
    }

    function addWebsite(Request $request)
    {
        $request->validate([
            'website_name' => 'required',
            'website_link' => 'required',
        ]);
        $web = Website::create([
            'website_id' => md5($request->website_name . Carbon::now()),
            'website_name' => $request->website_name,
            'website_link' => $request->website_link,
            'website_total_link' => 0,
        ]);

        return response()->json(['status' => true, 'message' => 'Data berhasil diinput', 'data' => $web], 200);
    }

    function getWebsite()
    {
        $web = Website::where('website_status', 1)->get();
        $data = [];
        foreach ($web as $value) {
            $data[] = [
                'website_id' => $value->website_id,
                'website_name' => $value->website_name,
                'website_link' => $value->website_link
            ];
        }

        return response()->json(['status' => true, 'data' => $data], 200);
    }

    function addMultiRotator(Request $request)
    {
        $this->validate($request, [
            'website_id' => 'required',
            'name' => 'required',
            'pesan' => 'required',
            'urutan' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $link = Link::create([
                'website_id' => $request->website_id,
                'name' => $request->name,
                'link' => md5($request->website_id . Carbon::now() . $request->name) . '-' . Str::slug($request->name),
                'link_type' => 1,
                'pesan' => $request->pesan,
                'email' => 'mahfudin@lsskincare.id',
                'count_link' => 0
            ]);

            $rotator = Link::find($link['id']);
            $data = $request->all();

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
            $website = Website::where('website_id', $request->website_id)->first();
            $website->update([
                'website_total_link' => $website->website_total_link + 1
            ]);
            DB::commit();
            return response()->json(['status' => true, 'link' => $link, 'rotator' => $data2], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    function addSingleRotator(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'website_id' => 'required',
            'name' => 'required',
            'pesan' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $link = Link::create([
                'website_id' => $request->website_id,
                'name' => $request->name,
                'phone' => preg_replace("/^0/", "62", $request->phone),
                'link_type' => 0,
                'link' => md5($request->website_id . $request->phone . $request->name) . '-' . Str::slug($request->name),
                'pesan' => $request->pesan,
                'email' => 'mahfudin@lsskincare.id',
                'count_link' => 0
            ]);
            $website = Website::where('website_id', $request->website_id)->first();
            $website->update([
                'website_total_link' => $website->website_total_link + 1
            ]);
            DB::commit();
            return response()->json(['status' => true, 'link' => $link], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    function updateRotator(Request $request, $id)
    {
        $link = Link::find($id);

        $link->update([
            'website_id' => $request->website_id,
            'name' => $request->name,
            'phone' => $link->type == 0 ? preg_replace("/^0/", "62", $request->phone) : null,
            'status' => $request->status,
        ]);
    }

    function updatePesan(Request $request, $id)
    {
        $link = Link::find($id);

        $link->update([
            'pesan' => $request->pesan
        ]);
    }

    function addRotator(Request $request, $id)
    {
        $link = Link::find($id);

        DB::beginTransaction();
        try {
            $data = $request->all();

            if ($data['csname'] != null) {
                foreach ($data['csname'] as $item => $value) {
                    $data2 = array(
                        'link_id' => $link->id,
                        'urutan' => $data['urutan'][$item],
                        'name' => $data['csname'][$item],
                        'phone' => preg_replace("/^0/", "62", $data['phone'][$item]),
                    );
                    $rotators = Rotator::create($data2);
                    $rotators = Rotator::where('link_id', $link->id)->max('urutan');

                    $link->update([
                        'jumlah_rotator' => $rotators,
                    ]);
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'data' => $data2], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    function editRotator(Request $request, $id)
    {
        $rotator = Rotator::find($id);
        $rotator->update([
            'urutan' => $request->urutan,
            'name' => $request->csname,
            'phone' => preg_replace("/^0/", "62", $request->phone),
        ]);
        $rot = Rotator::where('link_id', $rotator->link_id)->max('urutan');
        $link = Link::where('id', $rotator->link_id)->first();
        $link->update([
            'jumlah_rotator' => $rot,
        ]);
        return response()->json(['status' => true, 'data' => $rotator], 200);
    }

    function nonAktifRotator($id)
    {
        $rotator = Rotator::find($id);
        $link = Link::where('id', $rotator->link_id)->first();
        $rotators = Rotator::where('link_id', $link->id)->where('status', 1)->orderBy('urutan', 'asc')->get();
        foreach ($rotators as $value) {
            $urutan = $rotator->urutan < $value->urutan ? $value->urutan - 1 : $value->urutan;
            Rotator::where('link_id', $link->id)
                ->where('id', $value->id)
                ->update([
                    'urutan' => $urutan
                ]);
        }
        $rotator->update([
            'urutan' => 0,
            'status' => 0,
        ]);
        $rot = Rotator::where('link_id', $rotator->link_id)->max('urutan');
        $link->update([
            'jumlah_rotator' => $rot,
        ]);
        return response()->json(['status' => true, 'data' => $rotator], 200);
    }
}
