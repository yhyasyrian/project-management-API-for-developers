<?php

namespace App\Services;

use App\Models\User;
use App\Models\ContactInformation;
use App\Traits\AuthorizationTrait;
use App\Exceptions\PublicException;
use App\DTOs\Users\CreateContactInformationDto;
use App\DTOs\Users\UpdateContactInformationDto;

/**
 * Service class for managing user contact information
 *
 * This service handles the creation, updating, and deletion of user contact information
 * through a set of methods that interact with the database.
 */
class ContactInformationService
{
    use AuthorizationTrait;
    public function __construct(private ContactInformation $contactInformation)
    {
    }

    /**
     * Create new contact information for a user
     *
     * @param CreateContactInformationDto $dto Data transfer object containing user, type, and value
     * @return void
     */
    public function create(CreateContactInformationDto $dto)
    {
        $this->canUpdate($dto->user);
        $this->contactInformation->create([
            'type' => $dto->type,
            'value' => $dto->value,
            'user_id' => $dto->user->id,
        ]);
    }

    /**
     * Update existing contact information for a user
     *
     * @param UpdateContactInformationDto $dto Data transfer object containing user, id, and new value
     * @return void
     * @throws PublicException If the contact information is not found (404)
     */
    public function update(int $id, UpdateContactInformationDto $dto)
    {
        $this->canUpdate($dto->user);
        $this->contactInformation->findOrFail($id)->update([
            'value' => $dto->value,
        ]);
    }

    /**
     * Delete contact information for a user
     *
     * @param User $user The user whose contact information will be deleted
     * @param int $id The ID of the contact information to delete
     * @return void
     * @throws PublicException If the contact information is not found (404)
     */
    public function delete(User $user, int $id)
    {
        $this->canUpdate($user);
        $this->contactInformation->findOrFail($id)->delete();
    }
}
