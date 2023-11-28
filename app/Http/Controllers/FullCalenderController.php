<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class FullCalenderController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get([ 'id', 'title', 'start', 'end' ]);

            return response()->json($data);
        }

        return view('test');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request)
    {
        switch ($request->type) {
            case 'add':
                $event = Event::create([
                    'title' => $request->title ?? '',
                    'start' => $request->start,
                    'phone' => $request->phone ?? '',
                    'name'  => $request->name ?? '',
                    'email' => $request->email ?? '',
                    'end'   => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'update':
                $events = Event::find($request->id);
//                    ->update([
//                    'title' => $request->title ?? '',
//                    'start' => $request->start,
//                    'phone' => $request->phone ?? '',
//                    'name'  => $request->name ?? '',
//                    'email' => $request->email ?? '',
//                    'end'   => $request->end,
//                ]);
                $event = Event::create([
                    'title' => $events->title ?? '',
                    'start' => $request->start,
                    'phone' => $events->phone ?? '',
                    'name'  => $events->name ?? '',
                    'email' => $events->email ?? '',
                    'end'   => $request->end,
                ]);
                return response()->json($event);
                break;

            case 'delete':
                $event = Event::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # code...
                break;
        }
    }
}
