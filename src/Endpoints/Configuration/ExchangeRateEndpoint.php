<?php
    declare(strict_types=1);

    namespace smartbusiness\api2\Endpoints\Configuration;

    use LourensSystems\ApiWrapper\Endpoints\Parameters\GetParameters;
    use LourensSystems\ApiWrapper\Endpoints\Parameters\ListParameters;
    use LourensSystems\ApiWrapper\Exception\LSException;
    use LourensSystems\ApiWrapper\Interfaces\CreateInterface;
    use LourensSystems\ApiWrapper\Interfaces\DeleteInterface;
    use LourensSystems\ApiWrapper\Interfaces\GetInterface;
    use LourensSystems\ApiWrapper\Interfaces\ListInterface;
    use LourensSystems\ApiWrapper\Interfaces\UpdateInterface;
    use LourensSystems\ApiWrapper\Response\Response;
    use LourensSystems\ApiWrapper\Endpoints\AbstractEndpoint;

    /**
     * Class ExchangeRateEndpoint
     * @package smartbusiness\api2\Endpoints\Configuration
     */
    class ExchangeRateEndpoint extends AbstractEndpoint implements ListInterface, GetInterface, CreateInterface, UpdateInterface, DeleteInterface
    {

        const ENDPOINT_CONFIGURATION_EXCHANGE_RATES_LIST = '/configuration/exchange-rates';
        const ENDPOINT_CONFIGURATION_EXCHANGE_RATES_GET = '/configuration/exchange-rates/{exchangeId}';
        const ENDPOINT_CONFIGURATION_EXCHANGE_RATES_POST = '/configuration/exchange-rates';
        const ENDPOINT_CONFIGURATION_EXCHANGE_RATES_PUT = '/configuration/exchange-rates/{exchangeId}';
        const ENDPOINT_CONFIGURATION_EXCHANGE_RATES_DELETE = '/configuration/exchange-rates/{exchangeIds}';

        protected $scopes = ['configuration'];

        /**
         * Gets list of currency exchange rates.
         *
         * @param ListParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function list(ListParameters $parameters = null): Response
        {
            $url = $this->prepareListUrl(static::ENDPOINT_CONFIGURATION_EXCHANGE_RATES_LIST, $parameters);

            return $this->callApi(self::METHOD_GET, $url);
        }

        /**
         * Gets details of specified currency exchange rate.
         *
         * @param int $exchangeRateId
         * @param GetParameters|null $parameters
         * @return Response
         * @throws LSException
         */
        public function get(int $exchangeRateId, GetParameters $parameters = null): Response
        {
            $url = $this->prepareGetUrl(static::ENDPOINT_CONFIGURATION_EXCHANGE_RATES_GET, $parameters);
            $url = $this->replaceExchangeId($exchangeRateId, $url);

            return $this->callApi(self::METHOD_GET, $url);
        }

        /**
         * Creates new currency exchange rate.
         *
         * @param array $exchangeData
         * @return Response
         * @throws LSException
         */
        public function create(array $exchangeData): Response
        {
            $url = $this->baseUrl . static::ENDPOINT_CONFIGURATION_EXCHANGE_RATES_POST;

            return $this->callApi(self::METHOD_POST, $url, $exchangeData);
        }

        /**
         * Updates specified currency exchange rate.
         *
         * @param int $exchangeRateId
         * @param array $exchangeData
         * @return Response
         * @throws LSException
         */
        public function update(int $exchangeRateId, array $exchangeData): Response
        {
            $url = $this->replaceExchangeId($exchangeRateId,
                $this->baseUrl . static::ENDPOINT_CONFIGURATION_EXCHANGE_RATES_PUT);

            return $this->callApi(self::METHOD_PUT, $url, $exchangeData);
        }

        /**
         * Deletes specified currency exchange rates.
         *
         * @param array $exchangeRateIds
         * @return Response
         * @throws LSException
         */
        public function delete(array $exchangeRateIds): Response
        {
            $url = $this->replaceExchangeId(implode(',', $exchangeRateIds),
                $this->baseUrl . static::ENDPOINT_CONFIGURATION_EXCHANGE_RATES_DELETE, '{exchangeIds}');

            return $this->callApi(self::METHOD_DELETE, $url);
        }

        /**
         * Helper function for replacing ids in URL.
         *
         * @param mixed $replacement
         * @param string $subject
         * @param string $placeholder
         * @return string
         */
        private function replaceExchangeId($replacement, string $subject, string $placeholder = '{exchangeId}'): string
        {
            return str_replace($placeholder, $replacement, $subject);
        }
    }