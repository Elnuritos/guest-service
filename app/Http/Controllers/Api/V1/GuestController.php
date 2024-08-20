<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\GuestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Services\GuestService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *     title="Guest API",
 *     version="1.0.0",
 *     description="API для управления гостями"
 * )
 *
 * @OA\Schema(
 *     schema="Guest",
 *     type="object",
 *     title="Guest",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="first_name", type="string", example="Test"),
 *     @OA\Property(property="last_name", type="string", example="Test"),
 *     @OA\Property(property="email", type="string", example="test.test@test.com"),
 *     @OA\Property(property="phone", type="string", example="+1234567890"),
 *     @OA\Property(property="country", type="string", example="RUS"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="StoreGuestRequest",
 *     type="object",
 *     required={"first_name", "last_name", "email", "phone"},
 *     @OA\Property(property="first_name", type="string", example="Test"),
 *     @OA\Property(property="last_name", type="string", example="Test1"),
 *     @OA\Property(property="email", type="string", example="test.test@test.com"),
 *     @OA\Property(property="phone", type="string", example="+1234567890"),
 *     @OA\Property(property="country", type="string", example="RUS")
 * )
 *
 * @OA\Schema(
 *     schema="UpdateGuestRequest",
 *     type="object",
 *     @OA\Property(property="first_name", type="string", example="Test"),
 *     @OA\Property(property="last_name", type="string", example="Test2"),
 *     @OA\Property(property="email", type="string", example="test.test@test.com"),
 *     @OA\Property(property="phone", type="string", example="+1234567890"),
 *     @OA\Property(property="country", type="string", example="RUS")
 * )
 */
class GuestController extends Controller
{
    private $guestService;

    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }
     /**
     * @OA\Get(
     *     path="/api/v1/guests",
     *     summary="Получить список всех гостей",
     *     tags={"Guests"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Список гостей",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Guest")
     *         )
     *     )
     * )
     */

    public function index()
    {
        $guests = $this->guestService->getAllGuests();

        return response()->json($guests);
    }

     /**
     * @OA\Post(
     *     path="/api/v1/guests",
     *     summary="Создать нового гостя",
     *     tags={"Guests"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreGuestRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Гость создан",
     *         @OA\JsonContent(ref="#/components/schemas/Guest")
     *     )
     * )
     */
    public function store(StoreGuestRequest $request)
    {
        $guestDTO = new GuestDTO($request->validated());

        $guest = $this->guestService->createGuest($guestDTO);

        return response()->json($guest, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/guests/{id}",
     *     summary="Получить данные гостя по ID",
     *     tags={"Guests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Данные гостя",
     *         @OA\JsonContent(ref="#/components/schemas/Guest")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Гость не найден"
     *     )
     * )
     */
    public function show($id)
    {
        $guest = $this->guestService->getGuestById($id);

        return response()->json($guest);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/guests/{id}",
     *     summary="Обновить данные гостя",
     *     tags={"Guests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateGuestRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Данные гостя обновлены",
     *         @OA\JsonContent(ref="#/components/schemas/Guest")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Гость не найден"
     *     )
     * )
     */
    public function update(UpdateGuestRequest $request, $id)
    {
        $guestDTO = new GuestDTO($request->validated());
        $guest = $this->guestService->updateGuest($id, $guestDTO);

        return response()->json($guest);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/guests/{id}",
     *     summary="Удалить гостя",
     *     tags={"Guests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Гость удален"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Гость не найден"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->guestService->deleteGuest($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
