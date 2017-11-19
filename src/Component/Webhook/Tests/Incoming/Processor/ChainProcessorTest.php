<?php

namespace Component\Webhook\Tests\Incoming\Processor;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Component\Webhook\Incoming\Processor\ProcessorInterface;
use Component\Webhook\Incoming\Processor\ChainProcessor;

class ChainProcessorTest extends TestCase
{
    /**
     * @test
     */
    public function set_get_name()
    {
        $processor = new ChainProcessor('test', []);
        $this->assertEquals('test', $processor->getName());
    }

    /**
     * @test
     */
    public function chain_processor_executes_all_processors()
    {
        $processor1 = $this->getMockBuilder(ProcessorInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['process'])
            ->getMock();
        $processor1->expects($this->once())
            ->method('process');

        $processor2 = $this->getMockBuilder(ProcessorInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['process'])
            ->getMock();
        $processor2->expects($this->once())
            ->method('process');

        $processor3 = $this->getMockBuilder(ProcessorInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['process'])
            ->getMock();
        $processor3->expects($this->once())
            ->method('process');

        $request = $this->createMock(Request::class);
        $processors = [$processor1, $processor2, $processor3];
        (new ChainProcessor('chain-processor', $processors))->process($request);
    }
}