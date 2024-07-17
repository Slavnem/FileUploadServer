<?php
// Block The Direct Access
switch(true) {
    case (isset($_SERVER['REQUEST_URI']) !== true):
    case ((bool)strpos(strtolower($_SERVER['REQUEST_URI']), strtolower(".php"))):
        http_response_code(404);
        header('Location: /error-client');
        exit; // sonlandır
}

// Arkaplan verilerini tutan sınıf
class BackgroundData {
    protected static $BackgroundAll = [
        [ // 0
            "url" => "/asset/global/image/background/webp/wallpaper-cartoon-network-adventure-time-cartoon-d0-05-04-2024-19-30.webp",
            "name" => "Adventure Time",
            "width" => 1600,
            "height" => 900,
            "widthpx" => "1600px",
            "heightpx" => "900px",
            "align" => "horizontal"
        ],
        [ // 1
            "url" => "/asset/global/image/background/webp/wallpaper-minions-together-d0-21-03-2024-17-44.webp",
            "name" => "Minions",
            "width" => 2880,
            "height" => 1773,
            "widthpx" => "2880px",
            "heightpx" => "1773px",
            "align" => "horizontal"
        ],
        [ // 2
            "url" => "/asset/global/image/background/webp/wallpaper-minions-together-d1-21-03-2024-17-44.webp",
            "name" => "Minions",
            "width" => 3840,
            "height" => 2160,
            "widthpx" => "3840px",
            "heightpx" => "2160px",
            "align" => "horizontal"
        ],
        [ // 3
            "url" => "/asset/global/image/background/webp/wallpaper-minions-d0-05-04-2024-19-30.webp",
            "name" => "Minions",
            "width" => 1920,
            "height" => 1080,
            "widthpx" => "1920px",
            "heightpx" => "1080px",
            "align" => "horizontal"
        ],
        [ // 4
            "url" => "/asset/global/image/background/webp/wallpaper-breaking-bad-d0-21-03-2024-18-22.webp",
            "name" => "Breaking Bad",
            "width" => 1920,
            "height" => 1080,
            "widthpx" => "1920px",
            "heightpx" => "1080px",
            "align" => "horizontal"
        ],
        [ // 5
            "url" => "/asset/global/image/background/webp/wallpaper-owl-d0-05-04-2024-19-30.webp",
            "name" => "Owl",
            "width" => 2560,
            "height" => 1440,
            "widthpx" => "2560px",
            "heightpx" => "1440px",
            "align" => "horizontal"
        ],
        [ // 6
            "url" => "/asset/global/image/background/webp/wallpaper-warrior-d0-31-03-2024-18-21.webp",
            "name" => "Warrior",
            "width" => 3840,
            "height" => 2160,
            "widthpx" => "3840px",
            "heightpx" => "2160px",
            "align" => "horizontal"
        ],
        [ // 7
            "url" => "/asset/global/image/background/webp/wallpaper-ducks-d0-25-03-2024-14-46.webp",
            "name" => "Ducks",
            "width" => 1800,
            "height" => 2700,
            "widthpx" => "1800px",
            "heightpx" => "2700px",
            "align" => "vertical"
        ],
        [ // 8
            "url" => "/asset/global/image/background/webp/wallpaper-nature-d0-25-03-2024-14-46.webp",
            "name" => "Nature",
            "width" => 6000,
            "height" => 4000,
            "widthpx" => "6000px",
            "heightpx" => "4000px",
            "align" => "horizontal"
        ]
    ];

    // Arkaplan numaralandırmaları
    protected static $Background = [
        0, 2, 3, 4, 5, 6, 7, 8
    ];

    protected static $BackgroundServerStatus = [
        0, 2, 3
    ];

    protected static $BackgroundAuth = [
        0, 1, 2, 3, 4, 6, 7
    ];

    protected static $BackgroundCrypt = [
        0, 1, 2, 3, 4, 6, 7
    ];

    // Arkaplan isimlendirmeleri
    protected static $KeyServerStatus = "server-status";
    protected static $KeyAuth = "auth";
    protected static $KeyCrypt = "crypt";

    // Arkaplan uzunluğunu getirtme
    public static function getBackgroundSelected(string $type = null, int $id = 0): array {
        // eğer verilen sayı desteklenenden fazla ise türüne göre rastgele alsın
        if($id < 1 || $id >= count(self::$BackgroundAll)) {
            switch($type) {
                case (self::$KeyServerStatus):
                    $id = intval(self::$BackgroundServerStatus[rand(0, (count(self::$BackgroundServerStatus) - 1))]);
                    break;
                case (self::$KeyAuth):
                    $id = intval(self::$BackgroundAuth[rand(0, (count(self::$BackgroundAuth) - 1))]);
                    break;
                case (self::$KeyCrypt):
                    $id = intval(self::$BackgroundCrypt[rand(0, (count(self::$BackgroundCrypt) - 1))]);
                    break;
                default:
                    $id = intval(self::$Background[rand(0, (count(self::$Background) - 1))]);
                    break;
            }
        }

        // Arkaplanı getirtme
        return (array)(self::getBackground($id));
    }

    // Arkaplan getiren fonksiyon
    protected static function getBackground(int $id): array {
        // eğer verilen sayı desteklenenden fazla ise rastgele alsın
        if($id < 0 || $id >= count(self::$BackgroundAll)) {
            $id = rand(0, (count(self::$BackgroundAll) - 1));
        }

        // arkaplanı getirsin
        return (array)((isset(self::$BackgroundAll[$id]) && !empty(self::$BackgroundAll[$id])) ? self::$BackgroundAll[$id] : []);
    }
}