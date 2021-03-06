<?php
    declare(strict_types=1);

    namespace smartbusiness\api2\Endpoints\Contacts\Configuration;

    use LourensSystems\ApiWrapper\Endpoints\Parameters\GetParameters;
    use LourensSystems\ApiWrapper\Exception\LSException;
    use LourensSystems\ApiWrapper\Response\Response;
    use LourensSystems\ApiWrapper\Endpoints\Parameters\ListParameters;
    use LourensSystems\ApiWrapper\Interfaces\CreateInterface;
    use LourensSystems\ApiWrapper\Interfaces\DeleteInterface;
    use LourensSystems\ApiWrapper\Interfaces\GetInterface;
    use LourensSystems\ApiWrapper\Interfaces\ListInterface;
    use LourensSystems\ApiWrapper\Interfaces\UpdateInterface;
    use LourensSystems\ApiWrapper\Endpoints\AbstractEndpoint;

    /**
     * Class GroupsEndpoint
     * @package smartbusiness\api2\Endpoints\Contacts\Configuration
     */
    class GroupsEndpoint extends AbstractEndpoint implements ListInterface, GetInterface, CreateInterface, UpdateInterface, DeleteInterface
    {

        const ENDPOINT_CONTACT_CONFIGURATION_GROUPS_LIST = '/contacts/configuration/groups';
        const ENDPOINT_CONTACT_CONFIGURATION_GROUPS_GET = '/contacts/configuration/groups/{groupId}';
        const ENDPOINT_CONTACT_CONFIGURATION_GROUPS_POST = '/contacts/configuration/groups';
        const ENDPOINT_CONTACT_CONFIGURATION_GROUPS_PUT = '/contacts/configuration/groups/{groupId}';
        const ENDPOINT_CONTACT_CONFIGURATION_GROUPS_DELETE = '/contacts/configuration/groups/{groupsIds}';


        protected $scopes = ['contact'];

        /**
         * Gets list of groups
         *
         * @param ListParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function list(ListParameters $parameters = null): Response
        {
            $url = $this->prepareListUrl(static::ENDPOINT_CONTACT_CONFIGURATION_GROUPS_LIST, $parameters);

            return $this->callApi(self::METHOD_GET, $url);
        }

        /**
         * Gets data of specified group
         *
         * @param int $groupId
         * @param GetParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function get(int $groupId, GetParameters $parameters = null): Response
        {
            $url = $this->prepareGetUrl(static::ENDPOINT_CONTACT_CONFIGURATION_GROUPS_GET, $parameters);
            $url = str_replace('{groupId}', $groupId, $url);

            return $this->callApi(self::METHOD_GET, $url);
        }

        /**
         * Creates new group
         *
         * @param array $groupData
         * @return Response
         * @throws LSException
         */
        public function create(array $groupData): Response
        {
            $url = $this->baseUrl . static::ENDPOINT_CONTACT_CONFIGURATION_GROUPS_POST;

            return $this->callApi(self::METHOD_POST, $url, $groupData);
        }


        /**
         * Updates specified group
         *
         * @param int $groupId
         * @param array $groupData
         * @return Response
         * @throws LSException
         */
        public function update(int $groupId, array $groupData): Response
        {
            $url = $this->baseUrl . static::ENDPOINT_CONTACT_CONFIGURATION_GROUPS_PUT;
            $url = str_replace('{groupId}', $groupId, $url);

            return $this->callApi(self::METHOD_PUT, $url, $groupData);
        }

        /**
         * Deletes specified groups
         *
         * @param array $groupIds Comma separated ids.
         * @return Response
         * @throws LSException
         */
        public function delete(array $groupIds): Response
        {
            $url = $this->baseUrl . static::ENDPOINT_CONTACT_CONFIGURATION_GROUPS_DELETE;
            $url = str_replace('{groupsIds}', implode(',', $groupIds), $url);

            return $this->callApi(self::METHOD_DELETE, $url);
        }
    }

