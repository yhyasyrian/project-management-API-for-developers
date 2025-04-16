<?php

namespace App\Services;

use App\Models\User;
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
    public function __construct()
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
        $dto->user->contactInformations()->create([
            'type' => $dto->type,
            'value' => $dto->value,
        ]);
    }

    /**
     * Update existing contact information for a user
     *
     * @param UpdateContactInformationDto $dto Data transfer object containing user, id, and new value
     * @return void
     * @throws PublicException If the contact information is not found (404)
     */
    public function update(UpdateContactInformationDto $dto)
    {
        $isUpdate = $dto->user->contactInformations()->where('id', $dto->id)->update([
            'value' => $dto->value,
        ]);
        if (!$isUpdate) {
            throw new PublicException('Contact information not found',404);
        }
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
        $isDelete = $user->contactInformations()->where('id', $id)->delete();
        if (!$isDelete) {
            throw new PublicException('Contact information not found',404);
        }
    }
}
