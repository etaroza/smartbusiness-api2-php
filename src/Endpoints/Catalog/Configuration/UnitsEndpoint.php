<?php
    declare(strict_types=1);

    namespace smartbusiness\api2\Endpoints\Catalog\Configuration;

    use LourensSystems\ApiWrapper\Endpoints\Parameters\GetParameters;
    use LourensSystems\ApiWrapper\Endpoints\Parameters\ListParameters;
    use LourensSystems\ApiWrapper\Exception\LSException;
    use LourensSystems\ApiWrapper\Interfaces\GetInterface;
    use LourensSystems\ApiWrapper\Interfaces\ListInterface;
    use LourensSystems\ApiWrapper\Response\Response;
    use LourensSystems\ApiWrapper\Endpoints\AbstractEndpoint;

    /**
     * Class UnitsEndpoint
     * @package smartbusiness\api2\Endpoints\Catalog\Configuration
     */
    class UnitsEndpoint extends AbstractEndpoint implements ListInterface, GetInterface
    {

        const ENDPOINT_CATALOG_CONFIGURATION_UNITS_LIST = '/catalog/configuration/units';
        const ENDPOINT_CATALOG_CONFIGURATION_UNITS_GET = '/catalog/configuration/units/{unitId}';

        protected $scopes = ['configuration'];

        /**
         * Gets list of units.
         *
         * @param ListParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function list(ListParameters $parameters = null): Response
        {
            $url = $this->prepareListUrl(static::ENDPOINT_CATALOG_CONFIGURATION_UNITS_LIST, $parameters);

            return $this->callApi(self::METHOD_GET, $url);
        }

        /**
         * Gets details about specified unit.
         *
         * @param int $unitId
         * @param GetParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function get(int $unitId, GetParameters $parameters = null): Response
        {
            $url = $this->prepareGetUrl(static::ENDPOINT_CATALOG_CONFIGURATION_UNITS_GET, $parameters);
            $url = str_replace('{unitId}', $unitId, $url);

            return $this->callApi(self::METHOD_GET, $url);
        }


    }