<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Response;

class SubscribersController extends Controller
{
    /**
     * Get list of subscribers
     *
     * @return Response
     */
    public function all()
    {
        return response()->json(
            Subscriber::all()
        );
    }

    /**
     * Remove subscriber
     *
     * @param string $id
     * @return Response
     */
    public function delete($id)
    {
        return response()->json([
            'id' => $id,
            'success' => (bool) Subscriber::destroy($id),
        ]);
    }
}
