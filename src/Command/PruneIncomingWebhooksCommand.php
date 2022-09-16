<?php

declare(strict_types=1);

namespace Setono\SyliusWebhookPlugin\Command;

use Setono\SyliusWebhookPlugin\Repository\IncomingWebhookRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;

final class PruneIncomingWebhooksCommand extends Command
{
    protected static $defaultName = 'setono:sylius-webhook:prune-incoming-webhooks';

    /** @var string|null */
    protected static $defaultDescription = 'Prune the table with incoming webhook requests';

    private IncomingWebhookRepositoryInterface $incomingWebhookRepository;

    private int $threshold;

    /**
     * @param int $threshold the number of minutes to wait before pruning incoming webhooks
     */
    public function __construct(IncomingWebhookRepositoryInterface $incomingWebhookRepository, int $threshold)
    {
        $this->incomingWebhookRepository = $incomingWebhookRepository;
        $this->threshold = $threshold;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'threshold',
            null,
            InputOption::VALUE_REQUIRED,
            'The number of minutes to wait before deleting incoming webhooks',
            $this->threshold
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $threshold = $input->getOption('threshold');
        Assert::integerish($threshold);
        Assert::greaterThanEq($threshold, 0);

        $olderThan = (new \DateTimeImmutable())->sub(new \DateInterval(sprintf('PT%dM', (int) $threshold)));
        Assert::notFalse($olderThan);

        $this->incomingWebhookRepository->prune($olderThan);

        return 0;
    }
}
