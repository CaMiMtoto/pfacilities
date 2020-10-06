<?php


namespace App;


class Roles
{
    public static $PARTNER = 'partner';
    public static $APPLICANT = 'normal';
    public static $ADMIN = 'admin';
    public static $PHF = 'phf';
    public static $DG = 'DG';
    public static $PS = 'ps';
    public static $DGCPHS = 'dgcphs';
    public static $DHPRU = 'dhpru';
    public static $MINISTER = 'minister';
    public static $MOS = 'MOS';
    public static $DGP = 'DGP';


    public static function roles()
    {
        return [self::$PARTNER, self::$ADMIN, self::$PS, self::$PHF, self::$DGCPHS, self::$DHPRU, self::$MINISTER];
    }
}
