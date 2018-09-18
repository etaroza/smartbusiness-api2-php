<?php
    declare(strict_types=1);

    namespace smartbusiness\api2\Endpoints\Contacts;

    use LourensSystems\ApiWrapper\Endpoints\Parameters\GetParameters;
    use LourensSystems\ApiWrapper\Exception\LSException;
    use LourensSystems\ApiWrapper\Response\Response;
    use LourensSystems\ApiWrapper\Endpoints\Parameters\ListParameters;
    use LourensSystems\ApiWrapper\Exception\InvalidUseException;
    use LourensSystems\ApiWrapper\Interfaces\CreateInterface;
    use LourensSystems\ApiWrapper\Interfaces\DeleteInterface;
    use LourensSystems\ApiWrapper\Interfaces\GetInterface;
    use LourensSystems\ApiWrapper\Interfaces\ListInterface;
    use LourensSystems\ApiWrapper\Interfaces\UpdateInterface;
    use LourensSystems\ApiWrapper\Endpoints\AbstractEndpoint;

    /**
     * Class AddressesEndpoint
     * @package smartbusiness\api2\Endpoints\Contacts
     */
    class AddressesEndpoint extends AbstractEndpoint implements ListInterface, GetInterface, CreateInterface, UpdateInterface, DeleteInterface
    {

        const ENDPOINT_CONTACT_ADDRESSES_LIST = '/contacts/{contactId}/addresses';
        const ENDPOINT_CONTACT_ADDRESSES_GET = '/contacts/{contactId}/addresses/{addressId}';
        const ENDPOINT_CONTACT_ADDRESSES_POST = '/contacts/{contactId}/addresses';
        const ENDPOINT_CONTACT_ADDRESSES_PUT = '/contacts/{contactId}/addresses/{addressId}';
        const ENDPOINT_CONTACT_ADDRESSES_DELETE = '/contacts/{contactId}/addresses/{addressesIds}';

        protected $scopes = ['contact'];

        /**
         * Contact id
         * @var int
         */
        private $contactId;

        /**
         * Sets contact id
         *
         * @param int $contactId
         */
        public function setContactId(int $contactId)
        {
            $this->contactId = $contactId;
        }

        /**
         * Lists addresses of specified contact
         *
         * @param int $contactId
         * @param ListParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function listForContact(int $contactId, ListParameters $parameters = null): Response
        {
            $url = $this->prepareListUrl(static::ENDPOINT_CONTACT_ADDRESSES_LIST, $parameters);

            return $this->callApi(self::METHOD_GET, $this->replaceContactId($contactId, $url));
        }

        /**
         * Lists addresses of current contact
         *
         * @param ListParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function list(ListParameters $parameters = null): Response
        {
            $this->checkContactId();

            return $this->listForContact($this->contactId, $parameters);
        }


        /**
         * Gets data of specified contact's address
         *
         * @param int $contactId
         * @param int $addressId
         * @param GetParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function getForContact(int $contactId, int $addressId, GetParameters $parameters = null): Response
        {
            $url = $this->prepareGetUrl(static::ENDPOINT_CONTACT_ADDRESSES_GET, $parameters);
            $url = $this->replaceContactId($contactId, $url);
            $url = $this->replaceAddressId($addressId, $url);

            return $this->callApi(self::METHOD_GET, $url);
        }

        /**
         * Gets data of specified address of current contact
         *
         * @param int $addressId
         * @param GetParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function get(int $addressId, GetParameters $parameters = null): Response
        {
            $this->checkContactId();

            return $this->getForContact($this->contactId, $addressId, $parameters);
        }

        /**
         * Creates new address for specified contact
         *
         * @param int $contactId
         * @param array $addressData
         * @return Response
         * @throws LSException
         */
        public function createForContact(int $contactId, array $addressData): Response
        {
            $url = $this->replaceContactId($contactId, $this->baseUrl . static::ENDPOINT_CONTACT_ADDRESSES_POST);

            return $this->callApi(self::METHOD_POST, $url, $addressData);
        }

        /**
         * Creates new address for current contact
         *
         * @param array $addressData
         * @return Response
         * @throws LSException
         */
        public function create(array $addressData): Response
        {
            $this->checkContactId();

            return $this->createForContact($this->contactId, $addressData);
        }


        /**
         * Updates specified contact's address
         *
         * @param int $contactId
         * @param int $addressId
         * @param array $addressData
         * @return Response
         * @throws LSException
         */
        public function updateForContact(int $contactId, int $addressId, array $addressData): Response
        {
            $url = $this->replaceContactId($contactId, $this->baseUrl . static::ENDPOINT_CONTACT_ADDRESSES_PUT);
            $url = $this->replaceAddressId($addressId, $url);

            return $this->callApi(self::METHOD_PUT, $url, $addressData);
        }

        /**
         * Updates specified address of current contact
         *
         * @param int $addressId
         * @param array $addressData
         * @return Response
         * @throws LSException
         */
        public function update(int $addressId, array $addressData): Response
        {
            $this->checkContactId();

            return $this->updateForContact($this->contactId, $addressId, $addressData);
        }

        /**
         * Deletes specified contact's addresses
         *
         * @param int $contactId
         * @param array $addressIds
         * @return Response
         * @throws LSException
         */
        public function deleteForContact(int $contactId, array $addressIds): Response
        {
            $url = $this->replaceContactId($contactId, $this->baseUrl . static::ENDPOINT_CONTACT_ADDRESSES_DELETE);
            $url = $this->replaceAddressId(implode(',', $addressIds), $url, '{addressesIds}');

            return $this->callApi(self::METHOD_DELETE, $url);
        }

        /**
         * Deletes specified addresses of current contact
         *
         * @param array $addressIds .
         * @return Response
         * @throws LSException
         */
        public function delete(array $addressIds): Response
        {
            $this->checkContactId();

            return $this->deleteForContact($this->contactId, $addressIds);
        }


        /**
         * Helper function for replacing {contactId} placeholder in URL.
         *
         * @param int $contactId
         * @param string $subject
         * @return string
         */
        private function replaceContactId(int $contactId, string $subject): string
        {
            return str_replace('{contactId}', $contactId, $subject);
        }

        /**
         * Helper function for replacing {addressId} or different placeholder in URL.
         *
         * @param mixed $replacement
         * @param string $subject
         * @return string
         */
        private function replaceAddressId($replacement, string $subject, string $placeholder = '{addressId}'): string
        {
            return str_replace($placeholder, $replacement, $subject);
        }

        /**
         * Checks whether there is current contact id set
         *
         * @throws InvalidUseException
         */
        private function checkContactId()
        {
            if (is_null($this->contactId)) {
                throw new InvalidUseException('Contact id should be first set by setContactId method.');
            }
        }
    }
