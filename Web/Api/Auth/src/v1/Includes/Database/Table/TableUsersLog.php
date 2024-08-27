<?php
// Slavnem @2024-07-05
// Kullanıcı Bağlantı Kayıt Tablosu
namespace AuthApi\v1\Includes\Database\Table;

trait TableUsersLog {
    // Değişkenleri Tanımlama
    protected static string $id = "userslogId";
    protected static string $userid = "userslogUserid";
    protected static string $country = "userslogCountry";
    protected static string $city = "userslogCity";
    protected static string $browser = "userslogBrowser";
    protected static string $ipv4 = "userslogIpv4";
    protected static string $isp = "userslogIsp";
    protected static string $created = "userslogCreated";

    // Değişkenleri Getirtme
    // Kayıt numarası sütunu
    final public static function getId(): ?string {
        return self::$id;
    }

    // Kullanıcı numarası sütunu
    final public static function getUserId(): ?string {
        return self::$userid;
    }

    // Ülke sütunu
    final public static function getCountry(): ?string {
        return self::$country;
    }

    // Şehir sütunu
    final public static function getCity(): ?string {
        return self::$city;
    }

    // İnternet Tarayıcı sütunu
    final public static function getBrowser(): ?string {
        return self::$browser;
    }

    // Ipv4 Adresi sütunu
    final public static function getIpv4(): ?string {
        return self::$ipv4;
    }

    // İnternet Servis Sağlayıcı (Isp) sütunu
    final public static function getIsp(): ?string {
        return self::$isp;
    }

    // Kayıt oluşturulma sütunu
    final public static function getCreated(): ?string {
        return self::$created;
    }

    // Tüm hepsini çağırma
    final public static function getAll(): ?array {
        return array(
            self::getId(),
            self::getUserId(),
            self::getCountry(),
            self::getCity(),
            self::getBrowser(),
            self::getIpv4(),
            self::getIsp(),
            self::getCreated()
        );
    }
}