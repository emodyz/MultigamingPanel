<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Bridge;

/**
 * The greeting service definition.
 */
class BridgeStub {

    /**
     * Sends a greeting
     * @param \Bridge\HelloRequest $request client request
     * @param \Grpc\ServerContext $context server request context
     * @return \Bridge\HelloReply for response data, null if if error occured
     *     initial metadata (if any) and status (if not ok) should be set to $context
     */
    public function SayHello(
        \Bridge\HelloRequest $request,
        \Grpc\ServerContext $context
    ): ?\Bridge\HelloReply {
        $context->setStatus(\Grpc\Status::unimplemented());
        return null;
    }

    /**
     * Get the current version of the control panel
     * @param \Bridge\EmptyMessage $request client request
     * @param \Grpc\ServerContext $context server request context
     * @return \Bridge\GetCpVersionReply for response data, null if if error occured
     *     initial metadata (if any) and status (if not ok) should be set to $context
     */
    public function GetCpVersion(
        \Bridge\EmptyMessage $request,
        \Grpc\ServerContext $context
    ): ?\Bridge\GetCpVersionReply {
        $context->setStatus(\Grpc\Status::unimplemented());
        return null;
    }

    /**
     * @param \Bridge\EmptyMessage $request client request
     * @param \Grpc\ServerContext $context server request context
     * @return \Bridge\CheckForCpUpdateReply for response data, null if if error occured
     *     initial metadata (if any) and status (if not ok) should be set to $context
     */
    public function CheckForCpUpdate(
        \Bridge\EmptyMessage $request,
        \Grpc\ServerContext $context
    ): ?\Bridge\CheckForCpUpdateReply {
        $context->setStatus(\Grpc\Status::unimplemented());
        return null;
    }

    /**
     * @param \Bridge\UpgradeCpRequest $request client request
     * @param \Grpc\ServerContext $context server request context
     * @return \Bridge\EmptyMessage for response data, null if if error occured
     *     initial metadata (if any) and status (if not ok) should be set to $context
     */
    public function UpgradeCp(
        \Bridge\UpgradeCpRequest $request,
        \Grpc\ServerContext $context
    ): ?\Bridge\EmptyMessage {
        $context->setStatus(\Grpc\Status::unimplemented());
        return null;
    }

    /**
     * Get the method descriptors of the service for server registration
     *
     * @return array of \Grpc\MethodDescriptor for the service methods
     */
    public final function getMethodDescriptors(): array
    {
        return [
            '/bridge.Bridge/SayHello' => new \Grpc\MethodDescriptor(
                $this,
                'SayHello',
                '\Bridge\HelloRequest',
                \Grpc\MethodDescriptor::UNARY_CALL
            ),
            '/bridge.Bridge/GetCpVersion' => new \Grpc\MethodDescriptor(
                $this,
                'GetCpVersion',
                '\Bridge\EmptyMessage',
                \Grpc\MethodDescriptor::UNARY_CALL
            ),
            '/bridge.Bridge/CheckForCpUpdate' => new \Grpc\MethodDescriptor(
                $this,
                'CheckForCpUpdate',
                '\Bridge\EmptyMessage',
                \Grpc\MethodDescriptor::UNARY_CALL
            ),
            '/bridge.Bridge/UpgradeCp' => new \Grpc\MethodDescriptor(
                $this,
                'UpgradeCp',
                '\Bridge\UpgradeCpRequest',
                \Grpc\MethodDescriptor::UNARY_CALL
            ),
        ];
    }

}
