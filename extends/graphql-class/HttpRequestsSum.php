<?php

use Wappr\Cloudflare\SelectionSets\HttpRequests\HttpRequestsSum;

class HttpRequestSum  extends HttpRequestsSum 
{

     protected $selectionSet = [
          'pageViews',
          'requests',
          'threats',
          'bytes',
          'cachedBytes',
          'cachedRequests',
          'encryptedBytes',
          'encryptedRequests',
          'countryMap {
               bytes
               requests
               threats
               clientCountryName
          }',
          'ipClassMap {
               requests
               ipType
          }',
          'contentTypeMap {
               bytes
               requests
               edgeResponseContentTypeName
          }',
          'browserMap {
               pageViews
               uaBrowserFamily
          }',
          'threatPathingMap {
              requests
              threatPathingName
          }',
          ' responseStatusMap {
              requests
              edgeResponseStatus
          }',
          ' clientSSLMap {
              requests
              clientSSLProtocol
          }',
     ];
   
}
