<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Click;
use App\Models\Link;
use App\Models\Rotator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RotatorApiController extends Controller
{
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
            $data[] = [
                'id'   => $value->id,
                'name' => $value->name,
                'type' => $type,
                'link' => $value->link,
                'count_click' => $value->count_link,
                'status' => $value->status == 1 ? 'Aktif' : 'Tidak Aktif',
                'created' => $value->created_at->format('Y-m-d'),
            ];
        }

        return response()->json(['status' => true, 'data' => $data], 200);
    }

    function getIdRotator($id)
    {
        $link = Link::find($id);
        $rotator = Rotator::where('link_id', $id)->orderBy('urutan', 'asc')->get();
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
            'name' => $link->name,
            'phone' => $link->phone != null ? $link->phone : null,
            'message' => $link->pesan,
            'link' => $link->link,
            'type' => $type,
            'jumlah_rotator' => $link->jumlah_rotator,
            'count_click' => $link->count_link,
            'status' => $link->status == 1 ? 'Aktif' : 'Tidak Aktif',
        ];

        $rotators = [];
        foreach ($rotator as $value) {
            $rotators[] = [
                'id' => $value->id,
                'urutan' => $value->urutan,
                'name' => $value->name,
                'phone' => $value->phone,
            ];
        }

        return response()->json(['status' => true, 'data' => $data, 'rotator' => $rotators], 200);
    }

    function getClickID($id)
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');
        $link = Link::find($id);
        $click = Click::where('url_name', $link->link)->orderBy('click_time', 'DESC');
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d');
            $end = Carbon::parse($date[1])->format('Y-m-d');
        }
        $click = $click->whereBetween('click_time', [$start, $end])->get();
        $clicks = [];
        foreach ($click as $value) {
            $cs = Rotator::where('link_id', $id)->where('urutan', $value->urut)->first();
            $clicks[] = [
                'date_time' => $value->created_at,
                'cs' => $cs != null ? $cs->name : $value->urut,
                'device' => $value->user_device,
                'ip' => $value->ip_address,
            ];
        }

        if ($clicks == null) {
            return response()->json(['status' => true, 'data' => null], 200);
        }

        return response()->json(['status' => true, 'data' => $clicks], 200);
    }
}
