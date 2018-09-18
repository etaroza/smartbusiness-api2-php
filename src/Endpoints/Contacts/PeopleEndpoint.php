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
     * Class PeopleEndpoint
     * @package smartbusiness\api2\Endpoints\Contacts
     */
    class PeopleEndpoint extends AbstractEndpoint implements ListInterface, GetInterface, CreateInterface, UpdateInterface, DeleteInterface
    {

        const ENDPOINT_CONTACT_PEOPLE_LIST = '/contacts/{contactId}/people';
        const ENDPOINT_CONTACT_PEOPLE_GET = '/contacts/{contactId}/people/{personId}';
        const ENDPOINT_CONTACT_PEOPLE_POST = '/contacts/{contactId}/people';
        const ENDPOINT_CONTACT_PEOPLE_PUT = '/contacts/{contactId}/people/{personId}';
        const ENDPOINT_CONTACT_PEOPLE_DELETE = '/contacts/{contactId}/people/{peopleIds}';


        protected $scopes = ['contact'];

        /**
         * Contact id
         * @var int
         */
        private $contactId;

        /**
         * Sets contact id.
         *
         * @param int $contactId
         */
        public function setContactId(int $contactId)
        {
            $this->contactId = $contactId;
        }

        /**
         * Gets list of people of specified contact.
         *
         * @param int $contactId
         * @param ListParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function listForContact(int $contactId, ListParameters $parameters = null): Response
        {
            $url = $this->prepareListUrl(static::ENDPOINT_CONTACT_PEOPLE_LIST, $parameters);

            return $this->callApi(self::METHOD_GET, $this->replaceContactId($contactId, $url));
        }

        /**
         * Gets list of people of current contact.
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
         * Gets data of specified contact's person.
         *
         * @param int $contactId
         * @param int $personId
         * @param GetParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function getForContact(int $contactId, int $personId, GetParameters $parameters = null): Response
        {
            $url = $this->prepareGetUrl(static::ENDPOINT_CONTACT_PEOPLE_GET, $parameters);
            $url = $this->replaceContactId($contactId, $url);
            $url = $this->replacePersonId($personId, $url);

            return $this->callApi(self::METHOD_GET, $url);
        }

        /**
         * Gets data of specified person of current contact.
         *
         * @param int $personId
         * @param GetParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function get(int $personId, GetParameters $parameters = null): Response
        {
            $this->checkContactId();

            return $this->getForContact($this->contactId, $personId, $parameters);
        }

        /**
         * Creates new person for specified contact.
         *
         * @param int $contactId
         * @param array $personData
         * @return Response
         * @throws LSException
         */
        public function createForContact(int $contactId, array $personData): Response
        {
            $url = $this->replaceContactId($contactId, $this->baseUrl . static::ENDPOINT_CONTACT_PEOPLE_POST);

            return $this->callApi(self::METHOD_POST, $url, $personData);
        }

        /**
         * Creates new person for current contact.
         *
         * @param array $personData
         * @return Response
         * @throws LSException
         */
        public function create(array $personData): Response
        {
            $this->checkContactId();

            return $this->createForContact($this->contactId, $personData);
        }


        /**
         * Updates specified contact's person.
         *
         * @param int $contactId
         * @param int $personId
         * @param array $personData
         * @return Response
         * @throws LSException
         */
        public function updateForContact(int $contactId, int $personId, array $personData): Response
        {
            $url = $this->replaceContactId($contactId, $this->baseUrl . static::ENDPOINT_CONTACT_PEOPLE_PUT);
            $url = $this->replacePersonId($personId, $url);

            return $this->callApi(self::METHOD_PUT, $url, $personData);
        }

        /**
         * Updates specified person of current contact.
         *
         * @param int $personId
         * @param array $personData
         * @return Response
         * @throws LSException
         */
        public function update(int $personId, array $personData): Response
        {
            $this->checkContactId();

            return $this->updateForContact($this->contactId, $personId, $personData);
        }

        /**
         * Deletes specified contact's people
         *
         * @param int $contactId
         * @param array $peopleIds
         * @return Response
         * @throws LSException
         */
        public function deleteForContact(int $contactId, array $peopleIds): Response
        {
            $url = $this->replaceContactId($contactId, $this->baseUrl . static::ENDPOINT_CONTACT_PEOPLE_DELETE);
            $url = $this->replacePersonId(implode(',', $peopleIds), $url, '{peopleIds}');

            return $this->callApi(self::METHOD_DELETE, $url);
        }

        /**
         * Deletes specified people of current contact
         *
         * @param array $peopleIds Comma separated ids.
         * @return Response
         * @throws LSException
         */
        public function delete(array $peopleIds): Response
        {
            $this->checkContactId();

            return $this->deleteForContact($this->contactId, $peopleIds);
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
         * Helper function for replacing {personId} or different placeholder in URL.
         *
         * @param mixed $replacement
         * @param string $subject
         * @param string $placeholder
         * @return string
         */
        private function replacePersonId($replacement, string $subject, string $placeholder = '{personId}'): string
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

