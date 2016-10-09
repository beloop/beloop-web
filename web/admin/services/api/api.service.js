class ApiService {
    // @ngInject
    constructor($http, $log, API_SETTINGS) {
        this.$http = $http;
        this.$log = $log;
        this.config = API_SETTINGS;
    }

    /**
     * @method: get
     * @param endpoint
     * @param queryParams - GET data
     *
     * @returns {Promise}
     */
    get(endpoint = '', queryParams = {}, restParams = {}) {
        const url = this.constructUrl(endpoint, restParams);
        return this.request({
            url: url,
            method: 'GET',
            queryParams
        });
    }

    /**
     * @method: constructUrl
     * @description:
     * Lookup of the api endpoint in config based on the first segment in href until first slash
     * Then expands variables in href with restParams object, for example:
     *
     * some-api/{id}/{user}?someParam=true
     *
     * might expand to:
     *
     * http://full-url-to-api/some-api/12/bob?someParam=true
     *
     * @param href
     * @param restParams - object to expand {var}'s in href with
     * @returns {Object} contains url and channel
     */
    constructUrl(href, restParams) {
        const [ path, query ] = href.split('?');
        const [ endpointSegment, ...restUrl ] = path.split('/');
        const endpoint = this.config.endpoints[endpointSegment];

        if (angular.isUndefined(endpoint)) {
            throw new Error(`Api endpoint "${endpointSegment}" not found`);
        }

        return endpoint;
    }

    /**
     * @method: request
     * @description:
     * Method that actually calls the api
     *
     * @param url
     * @param method
     * @param queryParams - GET data
     * @param payload - POST data
     * @param headers - An array of header objects to be added to the request
     * @param cache - boolean to cache the request
     * @returns {Promise}
     */
    request({ url, method, queryParams = {}, payload = undefined, headers = undefined, cache = false }) {

        const httpConfig = {
            method: method,
            headers: this.getDefaultHeaders(),
            url: url,
            params: queryParams,
            cache: cache
        };

        if (!angular.isUndefined(payload)) {
            httpConfig.data = payload;
        }

        return this.$http(httpConfig);
    }

    /**
     * @method: getDefaultHeaders
     * @description:
     * Gets default headers based on logged-in state
     *
     * @param addContentTypeJson
     * @returns {Object} headers to be used in $http config
     */
    getDefaultHeaders(addContentTypeJson = true) {
        return addContentTypeJson ? { 'Content-Type': 'application/json' } : {};
    }
}

export default ApiService;