<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\cartsDataTable;
use Sentinel;
use App\cart;
use App\cart_curriculum;
use App\cart_game;
use App\Exports\orderExport;
use App\Exports\gameOrder;
use App\Notifications\orderApprove;

class cartControl extends Controller
{
    public function index(cartsDataTable $cart)
    {
        if (Sentinel::hasAnyAccess(['admin.*'])) {
            return $cart->render("admin.cart.all");
        } else {
            return redirect()->back();
        }
    }


    public function multi_Delete()
    {


        if (is_array(request('item'))) {
            cart::destroy(request('item'));
        } else {
            cart::find(request('item'))->delete();
        }

        return redirect()->route('order')->with('success', 'Data has been deleted successfully');
    }


    public function removeOrder(Request $request)
    {
        $id = $request->get("id");

        $game_cart = cart_game::findOrfail($id);

        if ($game_cart) {
            $game_cart->delete();
            return response(["state" => "true"]);
        } else {
            return response(["state" => "false"]);
        }
    }

    public function removeOrderCurriculum(Request $request)
    {
        $id = $request->get("id");

        $game_cart = cart_curriculum::findOrfail($id);

        if ($game_cart) {
            $game_cart->delete();
            return response(["state" => "true"]);
        } else {
            return response(["state" => "false"]);
        }
    }

    public function export($id)
    {
        return \Excel::download(new orderExport($id), 'Order.xlsx');
    }

    public function export_game_details($id)
    {
        return \Excel::download(new gameOrder($id), 'game_order.xlsx');
    }

    public function update($id)
    {

        if (Sentinel::hasAccess('admin.create')) {
            $cart = cart::find($id);

            if (request()->isMethod('post')) {



                $data = $this->validate(request(), [
                    'name_camp' => 'required|string',
                    'date_camp' => 'required|date',
                    "administration" => 'required|string',
                    "other_inforamtion" => 'nullable|string',
                    "state" => "required"

                ]);

                $cart->name_camp = request()->name_camp;
                $cart->date_camp = request()->date_camp;
                $cart->administration = request()->administration;
                $cart->other_inforamtion = request()->other_inforamtion;
                $cart->state = request()->state;
                $cart->save();


                if ($cart->state == "Approve") {
                    $notification = \App\User::find($cart->id_user);
                    \Notification::send($notification, new orderApprove($cart->id));
                }

                return redirect()->route("order")->with("success", "data has been update");
            }




            return view("admin.cart.update", ["cart" => $cart]);
        } else {
            return redirect()->back();
        }
    }
}
