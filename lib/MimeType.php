<?php

namespace lib;

class MimeType
{
    private static $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'html' => 'text/html',
        'txt' => 'text/plain',
        // Agrega más tipos MIME según sea necesario
    ];

    private static $baseDirs = [
        'resources' => './../',
        'backend' => __DIR__ . '/../lib/src/public/',
        'frontend' => __DIR__ . '/../App/public/',
        'librery' => __DIR__ . '/../vendor/'
    ];

    public static function getBaseDirs()
    {
        return self::$baseDirs;
    }


    public static function get($extension)
    {
        return self::$mimeTypes[$extension] ?? 'application/octet-stream';
    }

    public static function serveFile($filePath)
    {
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $contentType = self::get($ext);
        header("Content-Type: $contentType");
        readfile($filePath);
    }

    public static function handleNotFound()
    {
        http_response_code(404);
        echo '404 Not Found';
        return false;
    }

    public static function serveStaticFile($uri)
    {
        foreach (self::$baseDirs as $key => $baseDir) {
            if (strpos($uri, $key) === 0) {
                $relativeUri = preg_replace("#^$key/#", '', $uri);
                $filePath = realpath($baseDir . $relativeUri);
                if ($filePath && file_exists($filePath)) {
                    self::serveFile($filePath);
                    return true;
                }
            }
        }
        return self::handleNotFound();
    }
}
