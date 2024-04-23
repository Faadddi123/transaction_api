<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessCard;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *      schema="BusinessCard",
 *      required={"id", "name", "company", "title", "phone", "email", "address", "website"},
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="company", type="string"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="phone", type="string"),
 *      @OA\Property(property="email", type="string", format="email"),
 *      @OA\Property(property="address", type="string"),
 *      @OA\Property(property="website", type="string"),
 * )
 */

class BusinessCard_controller extends Controller
{


    /**
     * Display a listing of the business cards.
     *
     * @OA\Get(
     *     path="/api/business-cards",
     *     tags={"Business Cards"},
     *     summary="Display a listing of the business cards",
     *     @OA\Response(
     *         response=200,
     *         description="List of business cards",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/BusinessCard"),
     *         )
     *     )
     * )
     */

     public function index()
     {
         $businessCards = BusinessCard::all();

         return response()->json($businessCards);
     }



    /**
     * Store a newly created business card.
     *
     * @OA\Post(
     *     path="/api/business-cards",
     *     tags={"Business Cards"},
     *     summary="Store a newly created business card",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "company", "title", "phone", "email", "address", "website"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="company", type="string"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="website", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Business card successfully created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="company", type="string"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="website", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid"),
     *             @OA\Property(property="errors", type="object"),
     *         )
     *     )
     * )
     */

     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|string',
             'company' => 'required|string',
             'title' => 'required|string',
             'phone' => 'required|string',
             'email' => 'required|email',
             'address' => 'required|string',
             'website' => 'required|string',
         ]);
         $userId = auth()->id();
         $businessCard = new BusinessCard();
         $businessCard->user_id = $userId;
         $businessCard->name = $request->name;
         $businessCard->company = $request->company;
         $businessCard->title = $request->title;
         $businessCard->phone = $request->phone;
         $businessCard->email = $request->email;
         $businessCard->address = $request->address;
         $businessCard->website = $request->website;

         $businessCard->save();

         return response()->json($businessCard, 201);
     }

    /**
     * Display the specified business card.
     *
     * @OA\Get(
     *     path="/api/business-cards/{id}",
     *     tags={"Business Cards"},
     *     summary="Display the specified business card",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the business card",
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Business card details",
     *         @OA\JsonContent(ref="#/components/schemas/BusinessCard"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Business card not found",
     *     )
     * )
            */
        public function show()
        {
            $userId = Auth::id();
            $businessCard = BusinessCard::where('user_id', $userId)->get();

            return response()->json($businessCard, 200);
        }

    /**
     * Update the specified business card.
     *
     * @OA\Put(
     *     path="/api/business-cards/{id}",
     *     tags={"Business Cards"},
     *     summary="Update the specified business card",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the business card",
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "company", "title", "phone", "email", "address", "website"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="company", type="string"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="website", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Business card successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/BusinessCard"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Business card not found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid"),
     *             @OA\Property(property="errors", type="object"),
     *         )
     *     )
     * )
     */

     public function update(Request $request, $id)
     {
         $request->validate([
             'name' => 'required|string',
             'company' => 'required|string',
             'title' => 'required|string',
             'phone' => 'required|string',
             'email' => 'required|email',
             'address' => 'required|string',
             'website' => 'required|string',
         ]);
            // dd('hh');
         $userId = Auth::id();

         $businessCard = BusinessCard::where('id', $id)
             ->where('user_id', $userId)
             ->firstOrFail();

         $businessCard->update($request->all());

         return response()->json($businessCard, 200);
     }

    /**
     * Remove the specified business card.
     *
     * @OA\Delete(
     *     path="/api/business-cards/{id}",
     *     tags={"Business Cards"},
     *     summary="Remove the specified business card",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the business card",
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Business card successfully deleted",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Business card not found",
     *     )
     * )
     */

    public function destroy($id)
    {
        $businessCard = BusinessCard::findOrFail($id);
        $businessCard->delete();

        return response()->json(null, 204);
    }

    public function getusersandstuff(){

        $businessCards = BusinessCard::select('users')->join('users' , 'users.id' , '=' , 'business_cards.user_id')->count('users')->groupBy('users.id');

        dd($businessCards);
    }
    

}
