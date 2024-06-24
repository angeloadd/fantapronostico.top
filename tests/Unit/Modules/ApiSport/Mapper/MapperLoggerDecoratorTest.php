<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Exceptions\ApiSportParsingException;
use App\Modules\ApiSport\Exceptions\NoMapperStrategyFoundException;
use App\Modules\ApiSport\Mapper\MapperInterface;
use App\Modules\ApiSport\Mapper\MapperLoggerDecorator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Tests\Unit\UnitTestCase;

final class MapperLoggerDecoratorTest extends UnitTestCase
{
    public const GENERIC_EXTERNAL_RESPONSE = ['get' => 'teams'];

    private MapperLoggerDecorator $subject;

    private LoggerInterface&MockObject $logger;

    private MapperInterface&MockObject $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->mapper = $this->createMock(MapperInterface::class);
        $this->subject = new MapperLoggerDecorator($this->mapper, $this->logger);
    }

    public static function exceptionProvider(): iterable
    {
        yield 'no mapper' => [
            new NoMapperStrategyFoundException(),
        ];

        yield 'parsing error' => [
            new ApiSportParsingException(),
        ];
    }

    #[DataProvider('exceptionProvider')]
    public function test_map_logs_caught_exceptions(RuntimeException $exception): void
    {
        $this->expectException($exception::class);
        $this->mapper->expects(self::once())
            ->method('map')
            ->with(self::GENERIC_EXTERNAL_RESPONSE)
            ->willThrowException($exception);

        $this->logger->expects(self::once())
            ->method('error')
            ->with($exception->getMessage());

        $this->subject->map(self::GENERIC_EXTERNAL_RESPONSE);
    }

    public function test_map_does_not_log_not_caught_exceptions(): void
    {
        $this->expectException(RuntimeException::class);
        $this->mapper->expects(self::once())
            ->method('map')
            ->willThrowException(new RuntimeException());

        $this->logger->expects(self::never())->method('error');

        $this->subject->map(self::GENERIC_EXTERNAL_RESPONSE);
    }
}
