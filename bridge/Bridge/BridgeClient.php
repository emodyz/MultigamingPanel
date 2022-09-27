<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Bridge;

/**
 * The greeting service definition.
 */
class BridgeClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Sends a greeting
     * @param \Bridge\HelloRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SayHello(\Bridge\HelloRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/bridge.Bridge/SayHello',
        $argument,
        ['\Bridge\HelloReply', 'decode'],
        $metadata, $options);
    }

    /**
     * Get the current version of the control panel
     * @param \Bridge\EmptyMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCpVersion(\Bridge\EmptyMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/bridge.Bridge/GetCpVersion',
        $argument,
        ['\Bridge\GetCpVersionReply', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Bridge\EmptyMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CheckForCpUpdate(\Bridge\EmptyMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/bridge.Bridge/CheckForCpUpdate',
        $argument,
        ['\Bridge\CheckForCpUpdateReply', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Bridge\UpgradeCpRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpgradeCp(\Bridge\UpgradeCpRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/bridge.Bridge/UpgradeCp',
        $argument,
        ['\Bridge\EmptyMessage', 'decode'],
        $metadata, $options);
    }

}
