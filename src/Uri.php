<?php
namespace Bobel\Helpers;

/**
 * Uri helpers
 *
 * @author Dmitrii Litovchenko
 */
class Uri
{
    /**
     * Return the current URL.
     *
     * @return string
     */
    public static function getCurrent(): string
    {
        $url = '';

        // Check to see if it's over https
        $is_https = self::isHttps();

        if ($is_https) {
            $url .= 'https://';
        } else {
            $url .= 'http://';
        }

        // Was a username or password passed?
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $url .= $_SERVER['PHP_AUTH_USER'];

            if (isset($_SERVER['PHP_AUTH_PW'])) {
                $url .= ':' . $_SERVER['PHP_AUTH_PW'];
            }

            $url .= '@';
        }

        // We want the user to stay on the same host they are currently on,
        // but beware of security issues
        // see http://shiflett.org/blog/2006/mar/server-name-versus-http-host
        $url .= $_SERVER['HTTP_HOST'];
        $port = $_SERVER['SERVER_PORT'];

        // Is it on a non standard port?
        if ($is_https && ($port != 443)) {
            $url .= ':' . $_SERVER['SERVER_PORT'];
        } elseif (!$is_https && ($port != 80)) {
            $url .= ':' . $_SERVER['SERVER_PORT'];
        }

        // Get the rest of the URL
        if (!isset($_SERVER['REQUEST_URI'])) {
            // Microsoft IIS doesn't set REQUEST_URI by default
            $url .= $_SERVER['PHP_SELF'];

            if (isset($_SERVER['QUERY_STRING'])) {
                $url .= '?' . $_SERVER['QUERY_STRING'];
            }
        } else {
            $url .= $_SERVER['REQUEST_URI'];
        }

        return $url;
    }

    /**
     * Checks to see if the page is being server over SSL or not
     *
     * @param bool $trustProxyHeaders
     * @return boolean
     */
    public static function isHttps($trustProxyHeaders = false): bool
    {
        // Check standard HTTPS header
        if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            return isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off';
        }

        // Check proxy headers if allowed
        return $trustProxyHeaders && isset($_SERVER['X-FORWARDED-PROTO']) && $_SERVER['X-FORWARDED-PROTO'] == 'https';
    }
}
