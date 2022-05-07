<?php
declare(strict_types=1);
namespace App\Http\Controllers\User;

use App\Core\Storage\Storage;
use App\Core\User\User;
use App\Exceptions\File\FileInvalidExtension;
use App\Exceptions\File\FileNotUploaded;
use App\Exceptions\User\UserImageProfileNotSetted;
use App\Exceptions\User\UserNameNotUpdated;
use App\Exceptions\User\UserNotStored;
use App\Exceptions\User\UserNotUpdated;
use App\Files\Image;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\Repository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     * @throws UserNotStored
     */
    public function store(UserRequest $request): JsonResponse
    {
        $user = new User($request->first_name, $request->last_name, $request->email, $request->password);

        $model = $this->repository->store($user);

        return ResponseHelper::created(['_id' => $model->_id]);
    }

    /**
     * @param UserRequest $request
     * @param \App\Models\User $user
     * @return JsonResponse
     * @throws UserNameNotUpdated
     * @throws UserNotUpdated
     */
    public function changeName(UserRequest $request, \App\Models\User $user): JsonResponse
    {
        if (!$this->repository->changeName($user, $request->first_name ?? null,$request->last_name ?? null))
            throw new UserNameNotUpdated();

        return ResponseHelper::results(['_id' => $user->_id]);
    }

    /**
     * @param UserRequest $request
     * @param \App\Models\User $user
     * @return JsonResponse
     * @throws FileInvalidExtension
     * @throws FileNotUploaded
     * @throws UserImageProfileNotSetted
     */
    public function setImageProfile(UserRequest $request, \App\Models\User $user): JsonResponse
    {
        $profile_image = new Image([
            'file' => $request->base64,
            'name' => Str::uuid(),
            'folder' => config('files.folders.user_profile_image')
        ]);

        $storage = new Storage();

        $file = $storage->putObject($profile_image);

        $this->repository->setImageProfile($user, $file);

        return ResponseHelper::results(['message' => trans('user.image.profile-setted')]);
    }
}
