<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: bridge.proto

namespace GPBMetadata;

class Bridge
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
bridge.protobridge"
EmptyMessage"
HelloRequest
name (	"

HelloReply
message (	"\'
CheckForCpUpdateReply
target (	"$
GetCpVersionReply
version (	"#
UpgradeCpRequest
version (	2�
Bridge6
SayHello.bridge.HelloRequest.bridge.HelloReply" A
GetCpVersion.bridge.EmptyMessage.bridge.GetCpVersionReply" I
CheckForCpUpdate.bridge.EmptyMessage.bridge.CheckForCpUpdateReply" =
	UpgradeCp.bridge.UpgradeCpRequest.bridge.EmptyMessage" bproto3'
        , true);

        static::$is_initialized = true;
    }
}

