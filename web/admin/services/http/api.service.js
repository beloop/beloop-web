import { forEach, size } from 'lodash';
import request from 'superagent';

import endpoints from 'Config/endpoints';

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
const constructUrl = (href, restParams) => {
  const [ path, query ] = href.split('?');
  const [ endpointSegment, ...restUrl ] = path.split('/');
  const endpoint = endpoints[endpointSegment];

  if (!endpoint) {
    throw new Error(`Api endpoint "${endpointSegment}" not found`);
  }

  let url = endpoint.url;

  // Expand restParams in url
  if (size(restParams) > 0) {
    Object.keys(restParams).forEach((key) => {
      if (url.indexOf(`{${key}}`) !== -1) {
        url = url.replace(`{${key}}`, restParams[key]);
        delete restParams[key];
      }
    });
  }

  return url;
};

/**
 * @method: get
 * @param endpoint
 * @param queryParams - GET data
 * @param restParams
 *
 * @returns {Promise}
 */
const get = (endpoint = '', queryParams = {}, restParams = {}) => {
  const url = constructUrl(endpoint, restParams);
  return request.get(url).query(queryParams);
};

export default {
  get
};