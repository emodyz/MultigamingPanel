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
     * @param \Bridge\GetVersionRequest $request client request
     * @param \Grpc\ServerContext $context server request context
     * @return \Bridge\GetVersionReply for response data, null if if error occured
     *     initial metadata (if any) and status (if not ok) should be set to $context
     */
    public function GetVersion(
        \Bridge\GetVersionRequest $request,
        \Grpc\ServerContext $context
    ): ?\Bridge\GetVersionReply {
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
            '/bridge.Bridge/GetVersion' => new \Grpc\MethodDescriptor(
                $this,
                'GetVersion',
                '\Bridge\GetVersionRequest',
                \Grpc\MethodDescriptor::UNARY_CALL
            ),
        ];
    }

}
