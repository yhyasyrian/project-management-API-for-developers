<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\ContactTypeEnum;
use App\Services\ApiResponseService;
use App\Services\ContactInformationService;
use App\DTOs\Users\CreateContactInformationDto;
use App\DTOs\Users\UpdateContactInformationDto;
use App\Http\Requests\ContactInformations\CreateRequest;
use App\Http\Requests\ContactInformations\UpdateRequest;
use App\Traits\AuthorizationTrait;

/**
 * Controller for managing user contact information
 *
 * This controller handles the creation, updating, and deletion of user contact information
 * through RESTful endpoints. It utilizes the ContactInformationService for business logic
 * and enforces authorization checks using the AuthorizationTrait.
 */
class ContactInformationController extends Controller
{
    use AuthorizationTrait;

    /**
     * Constructor for dependency injection
     *
     * @param ContactInformationService $contactInformationService Service for handling contact information operations
     */
    public function __construct(private ContactInformationService $contactInformationService)
    {
    }

    /**
     * Store a newly created contact information for a user
     *
     * @param User $user The user to add contact information for
     * @param CreateRequest $request Validated request containing contact information data
     * @return \Illuminate\Http\JsonResponse Success response with empty data
     *
     * @response {
     *   "data": []
     * }
     */
    public function store(User $user, CreateRequest $request)
    {
        // Check if the authenticated user has permission to update this user's contact information
        $this->canUpdate($user);

        // Create new contact information using the service
        $this->contactInformationService->create(
            new CreateContactInformationDto(
                user: $user,
                type: ContactTypeEnum::from($request->get('label')),
                value: $request->get('value')
            )
        );

        // Return success response
        return ApiResponseService::success([]);
    }

    /**
     * Update existing contact information for a user
     *
     * @param User $user The user whose contact information will be updated
     * @param int $id The ID of the contact information to update
     * @param UpdateRequest $request Validated request containing the new value
     * @return \Illuminate\Http\JsonResponse Success response with empty data
     *
     * @response {
     *   "data": []
     * }
     */
    public function update(User $user, int $id, UpdateRequest $request)
    {
        // Check if the authenticated user has permission to update this user's contact information
        $this->canUpdate($user);

        // Update the contact information using the service
        $this->contactInformationService->update(
            new UpdateContactInformationDto(
                user: $user,
                id: $id,
                value: $request->get('value')
            )
        );

        // Return success response
        return ApiResponseService::success([]);
    }

    /**
     * Remove contact information for a user
     *
     * @param User $user The user whose contact information will be deleted
     * @param int $id The ID of the contact information to delete
     * @return \Illuminate\Http\JsonResponse Success response with empty data
     *
     * @response {
     *   "data": []
     * }
     */
    public function destroy(User $user, int $id)
    {
        // Check if the authenticated user has permission to update this user's contact information
        $this->canUpdate($user);

        // Delete the contact information using the service
        $this->contactInformationService->delete($user, $id);

        // Return success response
        return ApiResponseService::success([]);
    }
}
