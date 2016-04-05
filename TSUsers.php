<?php
/*/////////
//Agusanz//
*//////////
require_once("libraries/TeamSpeak3/TeamSpeak3.php");

TeamSpeak3::init();
//primary
$user1 = "username";//query username
$pass1 ="password";//query password
$serverIP1 = "192.168.0.1";//server ip
$serverPort1 = "9987";//server port
$nickname1 = "BotNameP";//bot nickname
//secondary
$user2 = "username";//query username
$pass2 ="password";//query password
$serverIP2 = "192.168.0.2";//server ip
$serverPort2 = "9987";//server port
$nickname2 = "BotNameS";//bot nickname

try
{
	$ts3Primary = TeamSpeak3::factory("serverquery://{$user1}:{$pass1}@{$serverIP1}:10011/?server_port={$serverPort1}&blocking=0&nickname={$nickname1}");
    $serverInfoPrimary = $ts3Primary->getInfo();
    $maxSlotsPrimary = $serverInfoPrimary["virtualserver_maxclients"];
    $clientsOnlinePrimary = $serverInfoPrimary["virtualserver_clientsonline"];
    $slotsReservedPrimary = $serverInfoPrimary["virtualserver_reserved_slots"];
    $slotsAvailablePrimary = $maxSlotsPrimary - $slotsReservedPrimary;
    $unixTime = time();
    $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
    echo $realTime."\t[INFO] Primary done. Users online: {$clientsOnlinePrimary}. Slots: {$slotsAvailablePrimary}.\n";

    $ts3Secondary = TeamSpeak3::factory("serverquery://{$user2}:{$pass2}@{$serverIP2}:10011/?server_port={$serverPort2}&blocking=0&nickname={$nickname2}");
    $serverInfoSecondary = $ts3Secondary->getInfo();
    $maxSlotsSecondary = $serverInfoSecondary["virtualserver_maxclients"];
    $clientsOnlineSecondary = $serverInfoSecondary["virtualserver_clientsonline"];
    $slotsReservedSecondary = $serverInfoSecondary["virtualserver_reserved_slots"];
    $slotsAvailableSecondary = $maxSlotsSecondary - $slotsReservedSecondary;
    $unixTime = time();
    $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
    echo $realTime."\t[INFO] Secondary done. Users online: {$clientsOnlineSecondary}. Slots: {$slotsAvailableSecondary}.\n";

    $clientsOnlineTotal = $clientsOnlinePrimary + $clientsOnlineSecondary;
    $slotsAvailableTotal = $slotsAvailablePrimary + $slotsAvailableSecondary;

    echo $clientsOnlineTotal."\n";
    echo $slotsAvailableTotal."\n";

    $unixTime = time();
    $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
    die($realTime."\t[INFO] Finished.\n");
}
catch(Exception $e)
{
    $unixTime = time();
    $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
    echo "Failed\n";
    die($realTime."\t[ERROR]  " . $e->getMessage() . "\n". $e->getTraceAsString() ."\n");
}