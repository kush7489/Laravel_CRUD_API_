<?php

namespace App\Http\Controllers;

use App\Models\Detail;
// use App\Http\Requests\UpdateDetailRequest;
// use GuzzleHttp\Psr7\Message;
// use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;

class DetailController extends Controller
{
    protected $res;
    public function __construct()
    {
        $this->res = [
            'message' => '',
            'code' => 0,
            'body' => []
        ];
    }

    protected function setresponse($message, $code, $body = [])
    {
        $this->res['message'] = $message;
        $this->res['code'] = $code;
        $this->res['body'] = $body;
    }

    public function index()
    {
        try {
            $products = Detail::all();
            if ($products) {
                $this->setresponse('User Fetched Successfully', 200, $products);
            } else {
                $this->setresponse('Data not found', 204, $products);
            }
            // Log::info($this->res);
        } catch (\Exception $e) {
            $this->setresponse('Data fot found', 500);
        }
        return response()->json($this->res, $this->res['code']);
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string',
                'email' => 'required|string|max:255',
            ]);

            $user = Detail::create($request->all());
            $this->setresponse('User Created Successfully', 201, $user);
        } catch (ValidationException $e) {
            $this->setresponse('Validation error hai -> ' . $e->getMessage(), 400);
        }
        return response()->json($this->res, $this->res['code']);
    }

    public function show($detail)
    {

        try {
            $user = Detail::find($detail);
            if (!$user) {
                // return response()->json(['error' => 'User123 not found'], 404);
                $this->setresponse('User nahi mil raha', 404, $user);
            }
            // return response()->json($user);
        } catch (\Exception $e) {

            $this->setresponse(' Server Error ' . $e->getMessage(), 500);
        }
        return response()->json($this->res, $this->res['code']);
    }

    public function update(Request $request, $detail)
    {

        try {
            $user = Detail::find($detail);
            if (!$user) {
                $this->setresponse('User nahi mil raha', 404, $user);
            }

            $user->update($request->all());
            $this->setresponse('User data updated successfully', 200, $user);
        } catch (\Exception $e) {
            $this->setresponse(' Server Error ' . $e->getMessage(), 500);
        }
        return response()->json($this->res, $this->res['code']);
    }


    public function destroy($detail)
    {
        try {
            $user = Detail::find($detail);
            if (!$user) {
                $this->setresponse('User nahi mil raha', 404, $user);
            }

            $user->delete();
            $this->setresponse('User deleted successfully', 200, $user);
        } catch (\Exception $e) {
            $this->setresponse(' Server Error ' . $e->getMessage(), 500);
        }
        return response()->json($this->res, $this->res['code']);
    }
}
