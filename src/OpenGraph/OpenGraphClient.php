<?php

/**
 * Open Graph Client class to fetch all open open graph info
 *
 * @package primeobsession/opengraph-io-php
 * @author Jonathan Vaughn
 * @version 1.0
 * @url : https://www.opengraph.io
 * @docs : https://www.opengraph.io/documentation/
 */

namespace OpenGraph;

class OpenGraphClient
{
    /**
     * Base URL of api
     *
     * @var string $base_url
     */
    protected $base_url = "https://opengraph.io/api/";

    /**
     * Default API version
     *
     * @var string $api_version
     */
    protected $api_version  = "1.1";

    /**
     * URL to hit
     *
     * @var string $url_to_hit
     */
    protected $url_to_hit = null;

    /**
     * OpenGraph constructor.
     *
     * @param null $api_key_usr
     * @param boolean $cache_ok
     * @param boolean $full_render
     * @param string $api_version
     * @throws \OpenGraph\OpenGraphException
     */
    function __construct($api_key_usr = null, $cache_ok = false, $full_render = false, $api_version = null)
    {
        if (strlen($api_key_usr)) {
            if (! defined('API_KEY'))
                define('API_KEY', $api_key_usr);
            if ($cache_ok == 1 || strlen($cache_ok)) {
                if (gettype($cache_ok) === "boolean") {
                    if (! defined('CACHE_OK'))
                        define('CACHE_OK', true);
                } else {
                    throw new OpenGraphException("Cache OK type should be of boolean type.");
                }
            }
            if ($full_render == 1 || strlen($full_render)) {
                if (gettype($full_render) === "boolean") {
                    if (! defined('FULL_RENDER'))
                        define('FULL_RENDER', true);
                } else {
                    throw new OpenGraphException("Full render type should be of boolean type.");
                }
            }
            /* If $api_version == false then, $api_version will fallback to default version 1.1 */
            if (strlen($api_version)) {
                if (gettype($api_version) === 'string') {
                    $this->api_version = $api_version;
                } else {
                    throw new OpenGraphException("API version type should be of string type.");
                }
            }
        } else {
            throw new OpenGraphException("Missing required param API key.");
        }
    }

    /**
     * Scrap site content through api call
     *
     * @param string $site_url
     * @return string
     * @throws OpenGraphException
     */
    public function fetch($site_url) {
        if (strlen($site_url) && gettype($site_url) == 'string') {
            /* To unit test formUrl comment first return statement and uncomment last comment statement */
            return (new OpenGraphRequest())->request($this->formUrl($site_url));
            // return $this->formUrl();
        } else {
            throw new OpenGraphException("Missing required param Site URL.");
        }
    }

    /**
     * Setup URL to request through API
     *
     * @param string $url The URL to request.
     *
     * @return mixed
     * @throws OpenGraphException
     */
    private function formUrl($url) {
        if (defined('API_KEY') && ! empty($url)) {
            if (defined('CACHE_OK')) {
                if (defined('FULL_RENDER')) {
                    /* CACHE_OK & FULL_RENDER both are defined */
                    $this->url_to_hit = $this->base_url . $this->api_version . '/site/' . urlencode($url)
                        . '?cache_ok=true&full_render=true&app_id=' . API_KEY;
                } else {
                    /* Only CACHE_OK is defined */
                    $this->url_to_hit = $this->base_url . $this->api_version . '/site/' . urlencode($url)
                        . '?cache_ok=true&app_id=' . API_KEY;
                }
            } else {
                /* Only FULL_RENDER is defined */
                if (defined('FULL_RENDER')) {
                    $this->url_to_hit = $this->base_url . $this->api_version . '/site/' . urlencode($url)
                        . '?full_render=true&app_id=' . API_KEY;
                } else {
                    /* CACHE_OK & FULL_RENDER both are not defined */
                    $this->url_to_hit = $this->base_url . $this->api_version . '/site/' . urlencode($url)
                        . '?app_id=' . API_KEY;
                }
            }
        } else {
            throw new OpenGraphException("Missing params either API key or Site URL.");
        }

        return $this->url_to_hit;
    }
}
